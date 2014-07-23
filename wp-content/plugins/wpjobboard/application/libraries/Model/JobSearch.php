<?php
/**
 * Description of JobSearch
 *
 * @author greg
 * @package 
 */

class Wpjb_Model_JobSearch extends Daq_Db_OrmAbstract
{
    protected $_name = "wpjb_job_search";
    
    protected function _init()
    {
        
    }

    public static function createFrom(Wpjb_Model_Job $job)
    {
        $query = new Daq_Db_Query();
        $object = $query->select()
            ->from(__CLASS__." t")
            ->where("job_id = ?", $job->getId())
            ->limit(1)
            ->execute();

        if(empty($object)) {
            $object = new self;
        } else {
            $object = $object[0];
        }

        $country = Wpjb_List_Country::getByCode($job->job_country);

        $location = array(
            $country['iso2'],
            $country['iso3'],
            $country['name'],
            $job->job_state,
            $job->job_city,
            $job->job_zip_code
        );

        $object->job_id = $job->getId();
        $object->title = $job->job_title;
        $object->description = strip_tags($job->job_description);
        $object->company = $job->company_name;
        $object->location = join(" ", $location);
        $object->save();
        
        do_action("wpjb_customize_job_search", $object);
    }
    
    protected static function _found($query, $grouped)
    {
        if($grouped || $query->get("having")) {
            return count($query->fetchAll());
        } else {
            return $query->fetchColumn();
        }
    }
    
    public static function search($params = array())
    {
        $category = null;
        $type = null;
        $posted = null;
        $query = null;
        $location = null;
        $page = null;
        $date_from = null;
        $date_to = null;

        /**
         * @var $count int
         * items per page or maximum number of elements to return
         */
        $count = 20;
        
        /**
         * @var $sort_order mixed
         * string or array, specify sort column and order (either DESC or ASC),
         * you can add more then one sort order. 
         */
        $sort_order = "t1.is_featured DESC, t1.job_created_at DESC, t1.id DESC";
        
        /**
         * @var $count_only boolean
         * Count jobs only
         */
        $count_only = false;
        
        /**
         * Return only list of job ids instead of objects
         * @var $ids_only boolean
         */
        $ids_only = false;
        
        /**
         * Do not show filled jobs on the list
         * @var $hide_filled boolean
         */
        $hide_filled = wpjb_conf("front_hide_filled", false);
        
        /**
         * @var $filter string
         * narrow jobs to certain type:
         * - all: all jobs
         * - active: only active jobs
         * - expired: expired jobs
         * - expiring: jobs which will expire in X days
         * - awaiting: jobs awaiting approval
         * - new: posted no longer than X days ago
         * - inactive: jobs deactivated
         */
        $filter = "active";
        
        extract($params);
        $groupResults = false;
        
        $select = new Daq_Db_Query();
        $select = $select->select("t1.*");
        $select->from("Wpjb_Model_Job t1");
        
        if($filter == "active") {
            $select->where("t1.is_active = 1");
            $select->where("t1.job_created_at <= ?", date("Y-m-d"));
            $select->where("t1.job_expires_at >= ?", date("Y-m-d"));
        } elseif($filter == "expired") {
            $select->where("t1.job_expires_at < ?", date("Y-m-d"));
        } elseif($filter == "expiring") {
            $time = strtotime("today +5 day");
            $select->where("t1.is_active = 1");
            $select->where("t1.job_expires_at <= ?", date("Y-m-d", $time));
            $select->where("t1.job_expires_at >= ?", date("Y-m-d"));
        } elseif($filter == "awaiting") {
            $select->where("t1.is_approved = 0");
        } elseif($filter == "new") {
            $time = strtotime("today -5 day");
            $select->where("t1.job_created_at >= ?", date("Y-m-d", $time));
        } elseif($filter == "unread") {
            $select->where("t1.read = 0");
        } elseif($filter == "inactive") {
            $select->where("t1.is_active = 0");
            $select->where("t1.is_approved = 1");
        }
        
        if(is_array($sort_order)) {
            $select->order(join(",", $sort_order));
        } else {
            $select->order($sort_order);
        }
        
        if($hide_filled) {
            $select->where("is_filled = 0");
        }
        
        if(isset($is_featured) && $is_featured) {
            $select->where("t1.is_featured = 1");
        }
        
        if(isset($employer_id) && $employer_id) {
            if(!is_array($employer_id)) {
                $employer_id = explode(",", $employer_id);
            }
            $select->where("t1.employer_id IN(?)", array_map("intval", $employer_id));
        }
        
        if(isset($country) && $country) {
            $select->where("t1.job_country = ?", $country);
        }
        
        if(isset($state) && $state) {
            $select->where("t1.job_state = ?", $state);
        }
        
        if(isset($city) && $city) {
            $select->where("t1.job_city = ?", $city);
        }
        
        if(isset($id) && $id) {
            $select->where("t1.id IN(?)", (array)$id);
        }
        
        if(isset($id__not_in) && $id__not_in) {
            $select->where("t1.id NOT IN(?)", (array)$id__not_in);
        }
        
        if(!empty($category)) {
            if(!is_array($category)) {
                $category = explode(",", $category);
            }
            $select->join("t1.tagged t2c", "t2c.object='job'");
            $select->where("t2c.tag_id IN(?)", array_map("intval", $category));
            $tagJoin = true;
        }
        if(!empty($type)) {
            if(!is_array($type)) {
                $type = explode(",", $type);
            }
            $select->join("t1.tagged t2t", "t2t.object='job'");
            $select->where("t2t.tag_id IN(?)", array_map("intval", $type));
            $tagJoin = true;
        }

        if(!empty($meta)) {
            $job = new Wpjb_Model_Job();
            $m = 1;
            foreach($meta as $k => $v) {
                if(!is_numeric($k)) {
                    $k = $job->meta->$k->id;
                }
                
                foreach((array)$v as $ve) {
                    $select->join("t1.meta t3m$m");
                    $t1 = Daq_Db::getInstance()->quoteInto("t3m$m.meta_id = ?", $k);
                    $t2 = Daq_Db::getInstance()->quoteInto("t3m$m.value = ?", $ve);
                    $select->where("($t1 AND $t2)");
                    $m++;
                }
                
                /*
                    $select->join("t1.meta t3m$m");
                    $t1 = Daq_Db::getInstance()->quoteInto("t3m$m.meta_id = ?", $k);
                    $select->where("($t1 AND t3m$m.value IN(?))", (array)$v);
                    $m++;
                 */

            }
            $groupResults = true;
        }

        if($date_from) {
            $select->where("job_created_at >= ?", $date_from);
        }

        if($date_to) {
            $select->where("job_created_at <= ?", $date_to);
        }
        
        if(strlen($query)>0 || strlen($location)>0) {
            $select->join("t1.search t4");
        }
        
        if(isset($location) && $location) {
            $select->where("t4.location LIKE ?", "%$location%");
        }
        
        if($groupResults) {
            $select->group("t1.id");
        }
        
        $fulltext = "MATCH(t4.title, t4.description, t4.company, t4.location)";
        $fulltext.= "AGAINST (? IN BOOLEAN MODE)";
        
        $q = $fulltext;
        $fulltext = str_replace("?", '\'"'.esc_sql($query).'"\'', $q);
        $itemsFound = 0;
        $t = null;
        
        $custom_columns = apply_filters("wpjb_jobs_query_select_columns", "");
        if(is_array($custom_columns)) {
            $custom_columns = join(", ", $custom_columns);
        }
        if(!empty($custom_columns)) {
            $custom_columns = ", ".ltrim($custom_columns, ", ");
        }
        
        $select->select("COUNT(*) as `cnt`".$custom_columns);
        $select = apply_filters("wpjb_jobs_query", $select);
        
        if($query && strlen($query)<=3) {
            $select->where("(t4.title LIKE ?", "%$query%");
            $select->orWhere("t4.description LIKE ?)", "%$query%");
            $itemsFound = self::_found($select, $groupResults);
        } elseif(strlen($query)>3) {
            foreach(array(1, 2, 3) as $t) {
                
                $test = clone $select;
                if($t == 1) {
                    $test->where($fulltext);
                } elseif($t == 2) {
                    $test->where($q, "+".  str_replace(" ", " +", $query));
                } else {
                    $test->where($q, $query);
                }

                $itemsFound = self::_found($test, $groupResults);;
                if($itemsFound>0) {
                    break;
                }

            }
        } else {
            $itemsFound = self::_found($select, $groupResults);;
            
        }
        
        if($t>0) {
            if($t == 1) {
                $select->where($fulltext);
            } elseif($t == 2) {
                $select->where($q, "+".  str_replace(" ", " +", $query));
            } else {
                $select->where($q, $query);
            }
        }
        
        $select->select("t1.*".$custom_columns);
        
        if($page && $count) {
            $select->limitPage($page, $count);
        }
        
        if($count_only) {
            return $itemsFound;    
        }
        
        if($ids_only) {
            $select->select("t1.id".$custom_columns);
            $jobList = $select->getDb()->get_col($select->toString());
        } else {   
            $jobList = $select->execute();
        }
        
        $response = new stdClass;
        $response->job = $jobList;
        $response->page = $page;
        $response->perPage = $count;
        $response->count = count($jobList);
        $response->total = $itemsFound;
        
        if($response->perPage == 0) {
            $response->pages = 1;
        } else {
            $response->pages = ceil($response->total/$response->perPage);
        }
        
        $link = wpjb_link_to("feed_custom");
        $link2 = wpjb_link_to("search");
        $p2 = $params;
        unset($p2["page"]);
        unset($p2["count"]);
        $q2 = http_build_query($p2);
        $glue = "?";
        if(stripos($link, "?")) {
            $glue = "&";
        }
        $response->url = new stdClass;
        $response->url->feed = $link.$glue.$q2;
        $response->url->search = $link2.$glue.$q2;
        
        
        return $response;
    }
    
    public static function _search($params)
    {
        
        throw new Exception("deprecated!");
        
        $category = null;
        $type = null;
        $posted = null;
        $query = null;
        $field = array();
        $location = null;
        $page = null;
        $count = null;
        $order = null;
        $sort = null;
        
        extract($params);
        
        $query = new Daq_Db_Query();
        $query = $query->select("*");
        $query->from("Wpjb_Model_Job t1");
        $query->where("t1.is_active = 1");
        $query->where("t1.job_expires_at >= ?", date("Y-m-d"));
        $query->order("t1.is_featured DESC, t1.job_created_at DESC");

        if(Wpjb_Project::getInstance()->conf("front_hide_filled")) {
            $query->where("is_filled = 0");
        }
        
        if(isset($is_featured)) {
            $select->where("t1.is_featured = 1");
        }
        
        if(isset($employer_id)) {
            $select->where("t1.employer_id IN(?)", $employer_id);
        }
        
        if(isset($country)) {
            $select->where("t1.job_country = ?", $country);
        }
        
        if(is_array($category)) {
            $category = array_map("intval", $category);
            $select->join("t1.category t2", "t2.id IN (".join(",",$category).")");
        } elseif(!empty($category)) {
            $select->join("t1.category t2", "t2.id = ".(int)$category);
        } else {
            $select->join("t1.category t2");
        }

        if(is_array($type)) {
            $type = array_map("intval", $type);
            $select->join("t1.type t3", "t3.id IN (".join(",",$type).")");
        } elseif(!empty($type)) {
            $select->join("t1.type t3", "t3.id=".(int)$type);
        } else {
            $select->join("t1.type t3");
        }

        $days = $posted;
        if($days == 1) {
            $time = date("Y-m-d");
            $select->where("DATE(job_created_at) = ?", date("Y-m-d"));
        } elseif($days == 2) {
            $time = date("Y-m-d", strtotime("yesterday"));
            $select->where("DATE(job_created_at) = ?", date("Y-m-d", strtotime("now -1 day")));
        } elseif(is_numeric($days)) {
            $select->where("job_created_at >= DATE_SUB(NOW(), INTERVAL ? DAY)", (int)$days);
        }
        
        if(is_array($field)) {
            foreach($field as $k => $v) {
                $k = intval($k);
                if($k<1) {
                    continue;
                }
                $custom = new Wpjb_Model_AdditionalField($k);
                if($custom->field_for != 1) {
                    continue;
                }
                
                $q = new Daq_Db_Query();
                $q->select("COUNT(*) AS c");
                $q->from("Wpjb_Model_FieldValue tf$k");
                $q->where("tf$k.job_id=t1.id");
                if($custom->type == 3 || $custom->type == 4) {
                    $q->where("tf$k.value = ?", $v);
                } else {
                    $q->where("tf$k.value LIKE ?", "%$v%");
                }
                $select->where("($q)>0");
            }
        }
        
        $searchString = $search = $query;
        $q = "MATCH(t4.title, t4.description, t4.location, t4.company)";
        $q.= "AGAINST (? IN BOOLEAN MODE)";

        $select->select("COUNT(*) AS `cnt`");
        $itemsFound = 0;
        
        if($searchString && strlen($searchString)<=3) {
            $select->join("t1.search t4");
            $select->where("(t4.title LIKE ?", '%'.$searchString.'%');
            $select->orWhere("t4.description LIKE ?)", '%'.$searchString.'%');
            $itemsFound = $select->fetchColumn();
            $search = false;

        } elseif($searchString) {

            foreach(array(1, 2, 3) as $t) {
                
                $test = clone $select;
                $test->join("t1.search t4");
                if($t == 1) {
                    $test->where(str_replace("?", '\'"'.esc_sql($search).'"\'', $q));
                } elseif($t == 2) {
                    $test->where($q, "+".  str_replace(" ", " +", $search));
                } else {
                    $test->where($q, $search);
                }

                $itemsFound = $test->fetchColumn();
                if($itemsFound>0) {
                    break;
                }

            }
            
        } else {
            $itemsFound = $select->fetchColumn();
        }

        if($search) {
            $select->join("t1.search t4");
            if($t == 1) {
                $select->where(str_replace("?", '\'"'.esc_sql($search).'"\'', $q));
            } elseif($t == 2) {
                $select->where($q, "+".  str_replace(" ", " +", $search));
            } else {
                $select->where($q, $search);
            }
        }

        if($searchString && $location) {
            $select->where("t4.location LIKE ?", "%$location%");
        } elseif($location) {
            $select->join("t1.search t4");
            $select->where("t4.location LIKE ?", "%$location%");
        }
        
        $select->select("*");
        
        if($page && $count) {
            $select->limitPage($page, $count);
        }
        
        $ord = array("id", "job_created_at", "job_title");
        
        if(!in_array($order, $ord)) {
            $order = null;
        }
        if($sort != "desc") {
            $sort = "asc";
        } 
        if($order) {
            $select->order("t1.is_featured DESC, t1.$order $sort");
        }
        
        if($ids_only) {
            $select->select("t.id");
            $jobList = $select->fetchAll();
        } else {
            $jobList = $select->execute();
        }
        
        
        $response = new stdClass;
        $response->job = $jobList;
        $response->page = $page;
        $response->perPage = $count;
        $response->count = count($jobList);
        $response->total = $itemsFound;
        $response->pages = ceil($response->total/$response->perPage);
        
        $link = wpjb_link_to("feed_custom");
        $link2 = wpjb_link_to("search");
        $p2 = $params;
        unset($p2["page"]);
        unset($p2["count"]);
        $q2 = http_build_query($p2);
        $glue = "?";
        if(stripos($link, "?")) {
            $glue = "&";
        }
        $response->url = new stdClass;
        $response->url->feed = $link.$glue.$q2;
        $response->url->search = $link2.$glue.$q2;
        
        return $response;
    }
}

?>