<?php

/**
 * Company job stats
 * 
 * Template displays company jobs stats
 * 
 * 
 * @author Greg Winiarski
 * @package Templates
 * @subpackage JobBoard
 * 
 */

 /* @var $jobList array List of jobs to display */
 /* @var $browse string One of: active; expired */
 /* @var $routerIndex string */
 /* @var $expiredCount int Total number of company expired jobs */
 /* @var $activeCount int Total number of company active jobs */

?>

<div id="wpjb-main" class="wpjb-page-company-panel">

    <?php wpjb_flash(); ?>

    <div class="wpjb-menu-bar">
        <?php if($browse == "active"): ?>
        <?php _e("Active listings", "wpjobboard"); echo " ($activeCount)" ?> |
        <a href="<?php echo wpjb_link_to("employer_panel_expired") ?>"><?php _e("Expired listings", "wpjobboard"); echo " ($expiredCount)" ?></a>
        <?php else: ?>
        <a href="<?php echo wpjb_link_to("employer_panel") ?>"><?php _e("Active listings", "wpjobboard"); echo " ($activeCount)" ?></a> |
        <?php _e("Expired listings", "wpjobboard"); echo " ($expiredCount)" ?>
        <?php endif; ?>
    </div>
    
    
    <table id="wpjb-job-list" class="wpjb-table">
        <thead>
            <tr>
                <th><?php _e("Expires", "wpjobboard") ?></th>
                <th><?php _e("Title", "wpjobboard") ?></th>
                <th><?php _e("Statistics", "wpjobboard") ?></th>
                <th class="wpjb-last">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
        <?php if(!empty($result->job)): foreach($result->job as $job): ?>
            <tr class="<?php wpjb_job_features($job); wpjb_panel_features($job) ?>">
                <td class="wpjb-column-expires">
                    <?php if($job->job_expires_at === WPJB_MAX_DATE): ?>
                        <?php _e("Never", "wpjobboard") ?>
                    <?php elseif($job->expired()): ?>
                        <?php _e("Expired", "wpjobboard") ?>
                    <?php else: ?>
                        <?php esc_html_e(wpjb_date_display(get_option("date_format"), $job->job_expires_at)) ?>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="<?php echo wpjb_link_to("job_edit", $job); ?>"><?php esc_html_e($job->job_title) ?></a>
                </td>
                <td>
                    <a href="<?php echo wpjb_link_to("job_applications", $job) ?>">
                    <?php if($job->applications) : ?>
                    <?php printf( _n("1 application", "%d applications", $job->applications, "wpjobboard"), $job->applications ) ?>
                    <?php else: ?>
                    <?php _e("0 applications", "wpjobboard") ?>
                    <?php endif; ?>
                    </a>
                </td>
                <td class="wpjb-last">
                    <div class="company-panel-dropdown">
                        <img id="wpjb-dropdown-<?php echo $job->id ?>-img" src="<?php echo wpjb_img("cog.png") ?>" alt="" />
                        <ul id="wpjb-dropdown-<?php echo $job->id ?>" class="wpjb-dropdown">
                            <li><a href="<?php echo wpjb_link_to("job", $job) ?>"><?php _e("View job", "wpjobboard") ?></a></li>
                            <li><a href="<?php echo wpjb_link_to("job_edit", $job); ?>"><?php _e("Edit job", "wpjobboard") ?></a></li>
                            <li><a href="<?php echo wpjb_link_to("step_add")."republish/".$job->id ?>"><?php _e("Republish", "wpjobboard") ?></a></li>
                            <li><a href="<?php echo wpjb_link_to("job_delete", $job) ?>"><?php _e("Delete ...", "wpjobboard") ?></a></li>
                            <li><hr/></li>
                            <li><a href="<?php echo wpjb_link_to("job_applications", $job) ?>"><?php _e("Applicants", "wpjobboard") ?></a></li>
                            <li><hr/></li>
                            <?php if($job->is_filled): ?>
                            <li><a href="<?php echo wpjb_link_to($routerIndex)."notfilled/".$job->id ?>"><?php _e("Mark as not filled", "wpjobboard") ?></a></li>
                            <?php else: ?>
                            <li><a href="<?php echo wpjb_link_to($routerIndex)."filled/".$job->id ?>"><?php _e("Mark as filled", "wpjobboard") ?></a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </td>
             </tr>
            <?php endforeach; else :?>
            <tr>
                <td colspan="4" align="center">
                    <?php _e("No job listings found.", "wpjobboard"); ?>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div id="wpjb-paginate-links">
        <?php wpjb_paginate_links($url, $result->pages, $result->page) ?>
    </div>


</div>

<script type="text/javascript">

    // 
    jQuery(function(){   
        
        jQuery(".company-panel-dropdown").wpjb_menu({
            position: "right"
        });
    });

</script>