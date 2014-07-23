<?php

/**
 * Job details container
 *
 * Inside this template job details page is generated (using function
 * wpjb_job_template)
 *
 * @author Greg Winiarski
 * @package Templates
 * @subpackage JobBoard
 *
 * @var $application_url string
 * @var $job Wpjb_Model_Job
 * @var $related array List of related jobs
 * @var $show_related boolean
 * @var $show stdClass
 */

?>
<div id="wpjb-main" class="wpjb-job wpjb-page-single">

    <?php wpjb_flash() ?>
    <?php $this->render("job.php") ?>

    <?php if(!wpjb_conf("front_hide_apply_link")): ?>

    <?php if($members_only): ?>
    <div class="wpjb-job-apply">
        <div class="wpjb-flash-error">
            <span><?php esc_html_e($form_error) ?></span>
        </div>

        <div>
            <a class="wpjb-button" href="<?php esc_attr_e(wpjr_link_to("login")) ?>"><?php _e("Login", "wpjobboard") ?></a>
            <a class="wpjb-button" href="<?php esc_attr_e(wpjr_link_to("register")) ?>"><?php _e("Register", "wpjobboard") ?></a>
        </div>
    </div>
    <?php elseif($can_apply): ?>

    <div class="wpjb-job-apply" id="wpjb-scroll">
        <div>
            <?php if($application_url): ?>
            <a class="wpjb-button" href="<?php esc_attr_e($application_url) ?>"><?php _e("Apply", "wpjobboard") ?></a>
            <?php else: ?>
            <a class="wpjb-button wpjb-form-toggle wpjb-form-job-apply" href="<?php esc_attr_e(wpjb_link_to("job", $job, array("form"=>"apply"))) ?>#wpjb-scroll" rel="nofollow" data-wpjb-form="wpjb-form-job-apply"><?php _e("Apply Online", "wpjobboard") ?> <span class="wpjb-slide-icon wpjb-none">&nbsp;</span></a>
            <?php endif; ?>

            <?php do_action("wpjb_tpl_single_actions", $job) ?>
        </div>

        <div id="wpjb-form-job-apply" class="wpjb-form-slider <?php if(!$show->apply): ?>wpjb-none<?php endif;?>">

            <?php if($form_error): ?>
            <div class="wpjb-flash-error" style="margin:5px">
                <span><?php esc_html_e($form_error) ?></span>
            </div>
            <?php endif; ?>

            <form id="wpjb-apply-form" action="<?php esc_attr_e(wpjb_link_to("job", $job, array("form"=>"apply"))) ?>#wpjb-scroll" method="post" enctype="multipart/form-data" class="wpjb-form wpjb-form-nolines">
                <?php echo $form->renderHidden() ?>
                <?php foreach($form->getReordered() as $group): ?>
                <?php /* @var $group stdClass */ ?>
                <fieldset class="wpjb-fieldset-<?php esc_attr_e($group->getName()) ?>">

                    <?php if($group->title): ?>
                    <legend><?php esc_html_e($group->title) ?></legend>
                    <?php endif; ?>

                    <?php foreach($group->getReordered() as $name => $field): ?>
                    <?php /* @var $field Daq_Form_Element */ ?>
                    <div class="<?php wpjb_form_input_features($field) ?>">

                        <label class="wpjb-label">
                            <?php esc_html_e($field->getLabel()) ?>
                            <?php if($field->isRequired()): ?><span class="wpjb-required">*</span><?php endif; ?>
                        </label>

                        <div class="wpjb-field">
                            <?php wpjb_form_render_input($form, $field) ?>
                            <?php wpjb_form_input_hint($field) ?>
                            <?php wpjb_form_input_errors($field) ?>
                        </div>

                    </div>
                    <?php endforeach; ?>
                </fieldset>
                <?php endforeach; ?>
                <fieldset>
                    <legend class="wpjb-empty"></legend>
                    <input type="submit" class="wpjb-submit" id="wpjb_submit" value="<?php _e("Send Application", "wpjobboard") ?>" />
                </fieldset>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <?php $relatedJobs = wpjb_find_jobs($related); ?>
    <?php if($show_related && $relatedJobs->total > 0): ?>
    <div class="wpjb-job-content">
    <h3><?php _e("Related Jobs", "wpjobboard") ?></h3>
    <ul class="wpjb-shortlist">
    <?php foreach($relatedJobs->job as $relatedJob): ?>
    <?php /* @var $relatedJob Wpjb_Model_Job */ ?>
        <li class="<?php wpjb_job_features($relatedJob); ?>">
            <a href="<?php echo wpjb_link_to("job", $relatedJob); ?>"><?php esc_html_e($relatedJob->job_title) ?></a>
            <?php if($relatedJob->isNew()): ?><span class="wpjb-bulb"><?php _e("new", "wpjobboard") ?></span><?php endif; ?>
            <?php wpjb_time_ago($relatedJob->job_created_at, __("posted {time_ago} ago.", "wpjobboard")) ?>
         </li>
    <?php endforeach; ?>
    </ul>
    </div>
    <?php endif; ?>


    <?php endif; ?>

    <p><em>Philadelphia D&M, Inc. is an equal opportunity/affirmative action employer. Individuals who require reasonable accomodations under the Americans with Disbilities Act in order to participate in the search process should notify our office directly at <?php echo get_option('phonenumber'); ?>.</em></p>

    <a href="<?php echo get_permalink(get_page_by_path('jobs')); ?>" class="careers-back">Back to Main Careers Page</a>

</div>