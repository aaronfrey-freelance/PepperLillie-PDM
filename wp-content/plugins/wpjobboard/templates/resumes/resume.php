<?php 

/**
 * Job details
 * 
 * This template is responsible for displaying job details on job details page
 * (template single.php) and job preview page (template preview.php)
 * 
 * @author Greg Winiarski
 * @package Templates
 * @subpackage Resumes
 */

 /* @var $resume Wpjb_Model_Resume */
 /* @var $can_browse boolean True if user has access to resumes */

?>

<div id="wpjb-main" class="wpjr-page-resume">

    <?php wpjb_flash() ?>
    
    <div class="wpjb-resume-headline">
        <?php if($resume->getAvatarUrl()): ?>
        <img src="<?php esc_attr_e($resume->getAvatarUrl()) ?>" alt="" class="wpjb-resume-photo" />
        <?php endif; ?>
        <strong><?php esc_html_e($resume->headline) ?></strong>
        <div><?php echo wpjb_rich_text($resume->description, "html") ?></div>
    </div>
    
    <table class="wpjb-info">
        <tbody>
            <tr>
                <td><?php _e("Last Resume Update", "wpjobboard") ?></td>
                <td class="wpjb-row-icon-date"><?php echo wpjb_date_display(get_option('date_format'), $resume->modified_at) ?></td>
            </tr>
            
            <?php if($resume->locationToString()): ?>
            <tr>
                <td><?php _e("Address", "wpjobboard") ?></td>
                <td class="wpjb-row-icon-location">
                    <?php if(wpjb_conf("show_maps") && $resume->getGeo()->status==2): ?>
                    <a href="http://maps.google.com/?ie=UTF8&amp;t=m&amp;near=<?php esc_attr_e(urlencode($resume->location())) ?>&amp;ll=<?php echo $resume->getGeo()->lnglat ?>&amp;spn=0.107734,0.686646&amp;z=15&amp;output=embedmfe&amp;iwloc=near" class="wpjb-tooltip"><?php esc_html_e($resume->locationToString()) ?></a>
                    <?php else: ?>
                    <?php esc_html_e($resume->locationToString()) ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php if(wpjb_conf("show_maps") && $resume->getGeo()->status==2): ?>
            <tr class="wpjb-none wpjb-map-slider">
                <td colspan="2">
                    <iframe style="width:100%;height:250px;margin:0;padding:0;" width="100%" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src=""></iframe>
                </td>
            </tr>
            <?php endif; ?>
            <?php endif; ?>
            
            <?php if($resume->getUser(true)): ?>
            <tr>
                <td><?php _e("E-mail", "wpjobboard") ?></td>
                <td><?php echo ($can_browse) ? $resume->getUser()->user_email : wpjb_block_resume_details(); ?></td>
            </tr>
            <?php endif; ?>
            
            <?php if($resume->phone): ?>
            <tr>
                <td><?php _e("Phone Number", "wpjobboard") ?></td>
                <td><?php echo $can_browse ? $resume->phone : wpjb_block_resume_details() ?></td>
            </tr>
            <?php endif; ?>
            
            <?php if($resume->getUser(true)->user_url): ?>
            <tr>
                <td><?php _e("Website", "wpjobboard") ?></td>
                <td><?php echo $can_browse ? $resume->getUser(true)->user_url : wpjb_block_resume_details() ?></td>
            </tr>
            <?php endif; ?>
            
            <?php foreach($resume->getMeta(array("visibility"=>0, "meta_type"=>3, "empty"=>false, "field_type_exclude"=>"ui-input-textarea")) as $k => $value): ?>
            <tr>
                <td class="wpjb-info-label"><?php esc_html_e($value->conf("title")); ?></td>
                <td>
                    <?php if($value->conf("type") == "ui-input-file"): ?>
                        <?php foreach($resume->file->{$value->name} as $file): ?>
                        <a href="<?php esc_attr_e($file->url) ?>" rel="nofollow"><?php esc_html_e($file->basename) ?></a>
                        <?php echo wpjb_format_bytes($file->size) ?><br/>
                        <?php endforeach ?>
                    <?php else: ?>
                        <?php esc_html_e(join(", ", (array)$value->values())) ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            
            <?php do_action("wpjb_template_resume_meta_text", $resume) ?>
        </tbody>
    </table>

    <?php
        $dList = array(
            __("Education", "wpjobboard") => $resume->getEducation(),
            __("Experience", "wpjobboard") => $resume->getExperience()
        );
    ?>
    
    <?php foreach($dList as $title => $details): ?>
    <?php if(!empty($details)): ?>
    <div class="wpjb-job-content">
        <h3><?php esc_html_e($title) ?></h3>
        <?php foreach($details as $detail): ?>
        
        <div class="wpjb-resume-detail">
            <div class="wpjb-column-left">
                <strong><?php esc_html_e($detail->grantor) ?></strong>
                <br/>
                <i><?php esc_html_e($detail->detail_title) ?></i>

            </div>
            <div class="wpjb-column-right">
                <?php $glue = "" ?>
                <?php if($detail->started_at != "0000-00-00"): ?>
                <?php esc_html_e(wpjb_date_display("M Y", $detail->started_at)) ?>
                <?php $glue = "-"; ?>
                <?php endif; ?>

                <?php if($detail->is_current): ?>
                <?php echo $glue." "; esc_html_e("Current", "wpjobboard") ?>
                <?php elseif($detail->completed_at != "0000-00-00"): ?>
                <?php echo $glue." "; esc_html_e(wpjb_date_display("M Y", $detail->completed_at)) ?>
                <?php endif; ?>
            </div>
            <?php if($detail->detail_description): ?>
            <div class="wpjb-clear"><?php echo wpjb_rich_text($detail->detail_description) ?></div>
            <?php endif; ?>
        </div>
        
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <?php endforeach; ?>

    <div class="wpjb-job-content">
        <?php foreach($resume->getMeta(array("visibility"=>0, "meta_type"=>3, "empty"=>false, "field_type"=>"ui-input-textarea")) as $k => $value): ?>
        
        <h3><?php esc_html_e($value->conf("title")); ?></h3>
        <div class="wpjb-job-text">
            <?php wpjb_rich_text($value->value(), $value->conf("textarea_wysiwyg") ? "html" : "text") ?>
        </div>
        
        <?php endforeach; ?>

        <?php do_action("wpjb_template_resume_meta_richtext", $resume) ?>
    </div>

    <div id="wpjb-scroll" class="wpjb-job-content">
        <h3><?php _e("Contact Candidate", "wpjobboard") ?></h3>
        
        <?php if($c_message): ?><div class="wpjb-flash-info"><?php esc_html_e($c_message) ?></div><?php else: ?><div>&nbsp;</div><?php endif; ?>
        
        <div>
            <?php if($button->contact): ?>
            <a class="wpjb-button wpjb-form-toggle wpjb-form-resume-contact" data-wpjb-form="wpjb-form-resume-contact" href="<?php esc_attr_e(wpjr_link_to("resume", $resume, array("form"=>"contact"))) ?>#wpjb-scroll" rel="nofollow"><?php _e("Contact Candidate", "wpjobboard") ?><span class="wpjb-slide-icon wpjb-none">&nbsp;</span></a>
            <?php endif; ?>
            
            <?php if($button->login): ?>
            <a class="wpjb-button" href="<?php esc_attr_e(wpjb_link_to("employer_login", null, array("redirect_to"=>  base64_encode($current_url)))) ?>"><?php _e("Login", "wpjobboard") ?></a>
            <?php endif; ?>
            
            <?php if($button->register): ?>
            <a class="wpjb-button" href="<?php esc_attr_e(wpjb_link_to("employer_new", null, array("redirect_to"=>  base64_encode($current_url)))) ?>"><?php _e("Register", "wpjobboard") ?></a>
            <?php endif; ?>
            
            <?php if($button->purchase): ?>
            <a class="wpjb-button wpjb-form-toggle wpjb-form-resume-purchase" data-wpjb-form="wpjb-form-resume-purchase" href="<?php esc_attr_e(wpjr_link_to("resume", $resume, array("form"=>"purchase"))) ?>#wpjb-scroll" rel="nofollow"><?php _e("Purchase", "wpjobboard") ?><span class="wpjb-slide-icon wpjb-none">&nbsp;</span></a>
            <?php endif; ?>
            
            <?php if($button->verify): ?>
            <a class="wpjb-button" href="<?php esc_attr_e(wpjb_link_to("employer_verify")) ?>"><?php _e("Request verification", "wpjobboard") ?></a>
            <?php endif; ?>
        </div>
        
        <?php foreach($f as $k => $form): ?>
        <div id="wpjb-form-resume-<?php echo $k ?>" class="wpjb-form-resume wpjb-form-slider <?php if(!$show->$k): ?>wpjb-none<?php endif; ?>">
            
        <?php if($form_error): ?>
        <div class="wpjb-flash-error" style="margin:5px">
            <span><?php esc_html_e($form_error) ?></span>
        </div>
        <?php endif; ?>
            
        <form class="wpjb-form wpjb-form-nolines" action="<?php esc_attr_e(wpjr_link_to("resume", $resume, array("form"=>$k))) ?>#wpjb-scroll" method="post">
            <fieldset>
            <?php echo $form->renderHidden() ?>
            <?php foreach($form->getReordered() as $group): ?>
            <?php /* @var $group stdClass */ ?> 

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

            <?php endforeach; ?>

                <div>
                    <input type="submit" value="<?php _e("Submit", "wpjobboard") ?>" />
                </div>
                
            </fieldset>

        </form>
        </div>
        <?php endforeach; ?>
        
    </div>
    
</div>

