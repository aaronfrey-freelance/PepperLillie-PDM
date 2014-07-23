<?php

/**
 * Save job
 * 
 * Template displayed when job is being saved
 * 
 * 
 * @author Greg Winiarski
 * @package Templates
 * @subpackage JobBoard
 * 
 */

 /* @var $job Wpjb_Model_Job */
 /* @var $action string */
 /* @var $online boolean True if job was automatically published */
 /* @var $payment string Payment form */
 /* @var $can_post boolean User has job posting priviledges */

?>

<div id="wpjb-main" class="wpjb-page-save">

    <?php wpjb_flash(); ?>

    <?php if($can_post): ?>
    <?php wpjb_add_job_steps(); ?>

    <p class="wpjb-complete">
    <?php if($action == "job_online"): ?>
        <p><?php _e("Thank you for using our service and submitting your job listing.", "wpjobboard") ?></p>

        <?php if($online): ?>
        <p><?php _e("Your job listing is now live.", "wpjobboard") ?></p>
        <p><a href="<?php echo wpjb_link_to("job", $job) ?>"><?php _e("Click here to view your listing", "wpjobboard") ?></a></p>

        <?php else: ?>
        <p><?php _e("Once it has been moderated and approved your job posting will become active.", "wpjobboard") ?></p>
        
        <?php endif; ?>

    <?php elseif($action == "payment_complete"): ?>
        <?php _e("Thank you for the payment, your order will be processed shortly.", "wpjobboard") ?>
    <?php elseif($action == "payment_already_sent"): ?>
        <?php _e("We already recived payment for this listing. Thank you.", "wpjobboard") ?>
    <?php else: // show payment form ?>
        <?php _e("Please use form below to make payment for job listing. Thank you!", "wpjobboard") ?>

        <table class="wpjb-info" id="wpjb-payment">
            <tbody>
                <tr>
                    <td><b><?php _e("Listing Cost", "wpjobboard") ?>:</b></td>
                    <td><?php esc_html_e(wpjb_price($payment->payment_sum+$payment->payment_discount, $payment->payment_currency)) ?></td>
                </tr>
                <tr>
                    <td><b><?php _e("Discount", "wpjobboard") ?>:</b></td>
                    <td><?php esc_html_e(wpjb_price($payment->payment_discount, $payment->payment_currency)) ?></td>
                </tr>
                <tr>
                    <td><b><?php _e("To Pay", "wpjobboard") ?>:</b></td>
                    <td><?php esc_html_e(wpjb_price($payment->getTotal(), $payment->payment_currency)) ?></td>
                </tr>
                <tr class="wpjb-no-border">
                    <td colspan="2"><?php echo $payment_form ?></td>
                </tr>
            </tbody>
        </table>
        
    <?php endif; ?>
    </p>

    <?php endif; ?>
</div>

