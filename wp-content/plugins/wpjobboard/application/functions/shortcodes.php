<?php

function wpjb_title() {
    
    $title = "";
    
    if(is_wpjb() || is_wpjr()) {
        $title = "<h2>".esc_html(Wpjb_Project::getInstance()->title)."</h2>";
    }
    
    return $title;
}

function wpjb_jobs_search() {
    
    $view = Wpjb_Project::getInstance()->getApplication("frontend")->getView();
    $view->form = new Wpjb_Form_AdvancedSearch();
    if($view->form->hasElement("query")) {
        $view->form->getElement("query")->setValue("");
    }
    $view->shortcode = true;
    
    wp_enqueue_script("jquery");
    wp_enqueue_style("wpjb-css");
    
    ob_start();
    $view->render("search.php");
    return ob_get_clean();
}

function wpjb_jobs_list($atts) {
    
    $params = shortcode_atts(array(
        "filter" => "active",
        "query" => null,
        "category" => null,
        "type" => null,
        "country" => null,
        "state" => null,
        "city" => null,
        "posted" => null,
        "location" => null,
        "is_featured" => null,
        "employer_id" => null,
        "meta" => array(),
        "hide_filled" => wpjb_conf("front_hide_filled", false),
        "sort" => null,
        "order" => null,
        "sort_order" => "t1.is_featured DESC, t1.job_created_at DESC, t1.id DESC",
        "search_bar" => "disabled",
        "pagination" => true,
        "standalone" => false,
        'page' => 1,
        'count' => 20,
    ), $atts);
    
    foreach((array)$atts as $k=>$v) {
        if(stripos($k, "meta__") === 0) {
            $params["meta"][substr($k, 6)] = $v;
        }
    }
    
    $init = array();
    foreach(array_keys((array)$atts) as $key) {
        if(isset($params[$key]) && !in_array($key, array("search_bar"))) {
            $init[$key] = $params[$key];
        }
    }
    
    $view = Wpjb_Project::getInstance()->getApplication("frontend")->getView();
    $view->param = $params;
    $view->pagination = $params["pagination"];
    $view->url = wpjb_link_to("home");
    $view->query = "";
    $view->shortcode = true;
    $view->search_bar = $params["search_bar"];
    $view->search_init = $init;
    
    Wpjb_Project::getInstance()->placeHolder = $view;
    
    wp_enqueue_style("wpjb-css");
    wp_enqueue_script('wpjb-js');
    
    ob_start();
    $view->render("index.php");
    return ob_get_clean();
}

function wpjb_resumes_search() {
    
    $view = Wpjb_Project::getInstance()->getApplication("resumes")->getView();
    $view->form = new Wpjb_Form_ResumesSearch();
    $view->form->getElement("query")->setValue("");
    $view->shortcode = true;
    
    wp_enqueue_style("wpjb-css");
    
    ob_start();
    $view->render("search.php");
    return ob_get_clean();
}

function wpjb_resumes_list($atts) {
    
    $params = shortcode_atts(array(
        "filter" => "active",
        "query" => null,
        "fullname" => null,
        "category" => null,
        "type" => null,
        "country" => null,
        "posted" => null,
        "location" => null,
        "is_featured" => null,
        "meta" => array(),
        "sort" => null,
        "order" => null,
        "sort_order" => "t1.modified_at DESC, t1.id DESC",
        'page' => 1,
        'count' => 20,
    ), $atts);
    
    foreach((array)$atts as $k=>$v) {
        if(stripos($k, "meta__") === 0) {
            $params["meta"][substr($k, 6)] = $v;
        }
    }
    
    $view = Wpjb_Project::getInstance()->getApplication("resumes")->getView();
    $view->param = $params;
    $view->url = wpjr_link_to("home");
    $view->query = "";
    $view->shortcode = true;
        
    Wpjb_Project::getInstance()->placeHolder = $view;
    
    wp_enqueue_style("wpjb-css");
    
    ob_start();
    $view->render("index.php");
    return ob_get_clean();
}


?>
