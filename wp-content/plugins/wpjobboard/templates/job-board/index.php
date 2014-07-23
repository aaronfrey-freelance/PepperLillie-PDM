<?php

/**
 * Jobs list
 * 
 * This template file is responsible for displaying list of jobs on job board
 * home page, category page, job types page and search results page.
 * 
 * 
 * @author Greg Winiarski
 * @package Templates
 * @subpackage JobBoard
 * 
 * @var $param array List of job search params
 * @var $search_bar string Either enabled or disabled
 * @var $search_init array Array of initial search params (used only with live search)
 * @var $pagination bool Show or hide pagination
 */

?>

<div id="wpjb-main" class="wpjb-page-index">

    <?php if($search_bar != "disabled"): ?>
    <div id="wpjb-top-search">
    <form action="<?php esc_attr_e(wpjb_link_to("search")) ?>" method="GET" id="wpjb-top-search-form">
        <?php global $wp_rewrite ?>
        <?php if(!$wp_rewrite->using_permalinks()): ?>
        <input type="hidden" name="page_id" value="<?php echo Wpjb_Project::getInstance()->conf("link_jobs") ?>" />
        <input type="hidden" name="job_board" value="find" />
        <?php endif; ?>
        <input autocomplete="off" type="text" class="wpjb-top-search-query wpjb-ls-query" name="query" value="<?php esc_attr_e(isset($param["query"]) ? $param["query"] : "") ?>" placeholder="<?php esc_attr_e("What?", "wpjobboard") ?>" />
        <input autocomplete="off" type="text" class="wpjb-top-search-location wpjb-ls-location" name="location" value="<?php esc_attr_e(isset($param["location"]) ? $param["location"] : "") ?>" placeholder="<?php esc_attr_e("Where?", "wpjobboard") ?>" />
        <br/>
        <ul>
            <?php foreach(wpjb_get_jobtypes() as $jt): ?>
            <li>
            <small>
                <input type="checkbox" class="wpjb-ls-type" name="type[]" value="<?php esc_attr_e($jt->id) ?>" id="<?php esc_attr_e("wpjb-search-".$jt->id) ?>" <?php if(isset($param["type"]) && in_array($jt->id, (array)$param["type"])): ?>checked="checked"<?php endif; ?> /> 
                <label for="<?php esc_attr_e("wpjb-search-".$jt->id) ?>"><?php esc_html_e($jt->title) ?></label>
            </small>
            </li>
            <?php endforeach; ?>
        </ul>
        <div class="wpjb-top-search-submit" style="">
            <input type="submit" value="<?php esc_attr_e("Filter Results", "wpjobboard") ?>" />
            <!--a href="#" class="wpjb-button" onclick="document.getElementById('wpjb-top-search-form').submit();"><?php _e("Filter Results", "wpjobboard") ?></a-->
        </div>
    </form>
    </div>
    <?php if($search_bar == "enabled-live"): ?>
        <script type="text/javascript">
            jQuery(function($) {
                WPJB_SEARCH_CRITERIA = <?php echo json_encode($search_init) ?>;
                wpjb_ls_jobs_init();
            });
        </script>
    <?php endif; ?>
    
    <?php endif; ?>
    
    <?php wpjb_flash(); ?>
    
    <table id="wpjb-job-list" class="wpjb-table">
        <thead>
            <tr>
                <th><?php _e("Job title", "wpjobboard") ?></th>
                <th><?php _e("Location", "wpjobboard") ?></th>
                <th class="wpjb-last">
                    <a href="#" class="wpjb-subscribe"><img src="<?php esc_attr_e(wpjb_img("subscribe.png")) ?>" alt="<?php _e("Subscribe", "wpjobboard") ?>" /></a>
                </th>
            </tr>
        </thead>
        <tbody>
        <?php $result = wpjb_find_jobs($param) ?>
        <?php if ($result->count) : foreach($result->job as $job): ?>
            <?php /* @var $job Wpjb_Model_Job */ ?>
            <?php $this->job = $job; ?>
            <?php $this->render("index-item.php") ?>
            <?php endforeach; else :?>
            <tr>
                <td colspan="3" class="wpjb-table-empty">
                    <?php _e("No job listings found.", "wpjobboard"); ?>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if($pagination): ?>
    <div id="wpjb-paginate-links">
        <?php wpjb_paginate_links($url, $result->pages, $result->page, $query) ?>
    </div>
    <?php endif; ?>

    
</div>

<!-- Begin: Subscribe to anything -->
<?php Wpjb_Project::getInstance()->setEnv("search_feed_url", $result->url->feed);  ?>
<?php Wpjb_Project::getInstance()->setEnv("search_params", $param);  ?>
<?php add_action("wp_footer", "wpjb_subscribe") ?>
<!-- End: Subscribe to anything -->