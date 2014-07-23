<?php

/**
 * Company profile page
 * 
 * This template displays company profile page
 * 
 * 
 * @author Greg Winiarski
 * @package Templates
 * @subpackage JobBoard
 */

/* @var $jobList array List of active company job openings */
/* @var $company Wpjb_Model_Company Company information */

?>

<div id="wpjb-main" class="wpjb-page-company" >

    <?php wpjb_flash() ?>

    <?php if($company->isVisible() || (Wpjb_Model_Company::current() && Wpjb_Model_Company::current()->id == $company->id)): ?>

    <table class="wpjb-info">
        <tbody>
            <?php if($company->locationToString()): ?>
            <tr>
                <td class="wpjb-info-label"><?php _e("Company Location", "wpjobboard") ?></td>
                <td class="wpjb-row-icon-location">
                    <?php if(wpjb_conf("show_maps") && $company->getGeo()->status==2): ?>
                    <a href="http://maps.google.com/?ie=UTF8&amp;t=m&amp;near=<?php esc_attr_e($company->location()) ?>&amp;ll=<?php echo $company->getGeo()->lnglat ?>&amp;spn=0.107734,0.686646&amp;z=15&amp;output=embed&amp;iwloc=near" class="wpjb-tooltip"><?php esc_html_e($company->locationToString()) ?></a>
                    <?php else: ?>
                    <?php esc_html_e($company->locationToString()) ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php if(wpjb_conf("show_maps") && $company->getGeo()->status==2): ?>
            <tr class="wpjb-none wpjb-map-slider">
                <td colspan="2">
                    <iframe style="width:100%;height:250px;margin:0;padding:0;" width="100%" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src=""></iframe>
                </td>
            </tr>
            <?php endif; ?>
            <?php endif; ?>
            
            <?php if($company->company_website): ?>
            <tr>
                <td class="wpjb-info-label"><?php _e("Company Website", "wpjobboard") ?></td>
                <td><a href="<?php esc_attr_e($company->company_website) ?>" class="wpjb-company-link"><?php esc_html_e($company->company_website) ?></a></td>
            </tr>
            <?php endif; ?>
            
            <?php foreach($company->getMeta(array("visibility"=>0, "meta_type"=>3, "empty"=>false, "field_type_exclude"=>"ui-input-textarea")) as $k => $value): ?>
            <tr>
                <td class="wpjb-info-label"><?php esc_html_e($value->conf("title")); ?></td>
                <td><?php esc_html_e(join(", ", (array)$value->values())) ?></td>
            </tr>
            <?php endforeach; ?>
            
            <?php do_action("wpjb_template_company_meta_text", $company) ?>
        </tbody>
    </table>
    
    <div class="wpjb-job-content">

        <div class="wpjb-job-text">

            <?php if($company->getLogoUrl()): ?>
            <div><img src="<?php echo $company->getLogoUrl() ?>" id="wpjb-logo" alt="" /></div>
            <?php endif; ?>

            <?php wpjb_rich_text($company->company_info, $company->meta->company_info_format->value()) ?>

        </div>
        
        <?php foreach($company->getMeta(array("visibility"=>0, "meta_type"=>3, "empty"=>false, "field_type"=>"ui-input-textarea")) as $k => $value): ?>
        <h3><?php esc_html_e($value->conf("title")); ?></h3>
        <div class="wpjb-job-text">
            <?php wpjb_rich_text($value->value()) ?>
        </div>
        <?php endforeach; ?>

        <?php do_action("wpjb_template_job_meta_richtext", $company) ?>

        <h3><?php _e("Current job openings at", "wpjobboard") ?> <?php esc_html_e($company->company_name) ?></h3>
        <div class="wpjb-company-openings">
        <ul class="wpjb-company-list wpjb-shortlist">
            <?php $jobList = wpjb_find_jobs($param) ?>
            <?php if ($jobList->total>0): foreach($jobList->job as $job): ?>
            <?php /* @var $job Wpjb_Model_Job */ ?>
            <li class="<?php wpjb_job_features($job); ?>">
                <a href="<?php echo wpjb_link_to("job", $job); ?>"><?php esc_html_e($job->job_title) ?></a>
                <?php if($job->isNew()): ?><span class="wpjb-bulb"><?php _e("new", "wpjobboard") ?></span><?php endif; ?>
                <?php wpjb_time_ago($job->job_created_at, __("posted {time_ago} ago.", "wpjobboard")) ?>
             </li>
            <?php endforeach; else :?>
            <li>
                <?php _e("Currently this employer doesn't have any openings.", "wpjobboard"); ?>
            </li>
            <?php endif; ?>
        </ul>
        </div>

    </div>

    <?php endif; ?>

</div>
