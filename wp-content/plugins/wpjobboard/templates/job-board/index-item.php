<?php 

/**
 * Job list item
 * 
 * This template is responsible for displaying job list item on job list page
 * (template index.php) it is alos used in live search
 * 
 * @author Greg Winiarski
 * @package Templates
 * @subpackage JobBoard
 */

 /* @var $job Wpjb_Model_Job */

?>
<tr class="<?php wpjb_job_features($job); ?>">
    <td class="wpjb-column-title">
        <a href="<?php echo wpjb_link_to("job", $job) ?>"><?php esc_html_e($job->job_title) ?></a>
        <span class="wpjb-sub"><?php esc_html_e($job->company_name) ?></span>
    </td>
    <td class="wpjb-column-location">
        <?php esc_html_e($job->locationToString()) ?>
    </td>
    <td class="wpjb-column-date wpjb-last">
        <?php if($job->isNew()): ?><span class="wpjb-bulb"><?php _e("new", "wpjobboard") ?></span><?php endif; ?>
        <?php echo wpjb_date_display("M, d", $job->job_created_at, true); ?>
        <?php if(isset($job->getTag()->type[0])): ?>
        <span class="wpjb-sub" style="color:#<?php echo $job->getTag()->type[0]->meta->color ?>">
        <?php esc_html_e($job->getTag()->type[0]->title) ?>
        </span>
        <?php endif; ?>
    </td>
</tr>