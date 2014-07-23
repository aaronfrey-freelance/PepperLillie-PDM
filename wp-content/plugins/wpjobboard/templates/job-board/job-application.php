<?php

/**
 * Job application details
 *
 * @author Greg Winiarski
 * @package Templates
 * @subpackage JobBoard
 * 
 /* @var $job Wpjb_Model_Job */
 /* @var $application Wpjb_Model_Application */

?>

<div id="wpjb-main" class="wpjb-page-job-application">

    <?php wpjb_flash(); ?>
    
    <div class="wpjb-menu-bar">
        <a href="<?php echo wpjb_link_to("employer_panel") ?>"><?php _e("Company jobs", "wpjobboard") ?></a>
        &raquo; 
        <a href="<?php echo wpjb_link_to("job_applications", $job) ?>"><?php esc_html_e($job->job_title) ?></a>
        &raquo;
        <?php _e($application->applicant_name) ?>
    </div>
    
    
    <table class="wpjb-info">
        <tbody>
            <tr>
                <td><?php _e("Application Status", "wpjobboard") ?></td>
                <td>
                    <form action="" method="post">
                        <select name="status">
                            <?php foreach(wpjb_application_status() as $k => $v): ?>
                            <option value="<?php esc_html_e($k) ?>" <?php if($k==$application->status): ?>selected="selected"<?php endif; ?>><?php esc_html_e($v) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="submit" value="<?php _e("change", "wpjobboard") ?>" />
                    </form>
                </td>
            </tr>
            <tr>
                <td><?php _e("Applicant Name", "wpjobboard") ?></td>
                <td><?php echo $application->applicant_name ?></td>
            </tr>
            <tr>
                <td><?php _e("Applicant E-mail", "wpjobboard") ?></td>
                <td><?php echo $application->email ?></td>
            </tr>
            <tr>
                <td><?php _e("Date Sent", "wpjobboard") ?></td>
                <td><?php echo wpjb_date_display(get_option("date_format"), $application->applied_at) ?></td>
            </tr>
            <?php foreach($application->getMeta(array("visibility"=>0, "meta_type"=>3, "empty"=>false, "field_type_exclude"=>"ui-input-textarea")) as $k => $value): ?>
            <tr>
                <td class="wpjb-info-label"><?php esc_html_e($value->conf("title")); ?></td>
                <td><?php esc_html_e(join(", ", (array)$value->values())) ?></td>
            </tr>
            <?php endforeach; ?>
            
            <?php if(count($application->getFiles())): ?>
            <tr>
                <td><?php _e("Attached Files", "wpjobboard") ?></td>
                <td>
                    <?php foreach($application->getFiles() as $file): ?>
                    <a href="<?php echo esc_attr($file->url) ?>"><?php echo esc_html($file->basename) ?></a>
                    ~ <?php echo esc_html(wpjb_format_bytes($file->size)) ?>
                    <br/>
                    <?php endforeach; ?>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="wpjb-job-content">
        <h3><?php _e("Message", "wpjobboard") ?></h3>
        <div class="wpjb-job-text">
            <?php echo wpjb_rich_text($application->message) ?>
        </div>

        <?php foreach($application->getMeta(array("visibility"=>0, "meta_type"=>3, "empty"=>false, "field_type"=>"ui-input-textarea")) as $k => $value): ?>
        
        <h3><?php esc_html_e($value->conf("title")); ?></h3>
        <div class="wpjb-job-text">
            <?php wpjb_rich_text($value->value()) ?>
        </div>
        
        <?php endforeach; ?>
    </div>

</div>