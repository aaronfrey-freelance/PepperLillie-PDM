<?php

/**
 * Company job applications
 * 
 * Template displays job applications
 * 
 * 
 * @author Greg Winiarski
 * @package Templates
 * @subpackage JobBoard
 * 
 */

 /* @var $applicantList array List of applications to display */
 /* @var $job string Wpjb_Model_Job */

?>

<div id="wpjb-main" class="wpjb-page-company-products">

    <?php wpjb_flash(); ?>

    <table class="wpjb-table">
        <thead>
            <tr>
                <th style=""><?php _e("Product", "wpjobboard") ?></th>
                <th class="wpjb-last">&nbsp;</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($result)) : foreach($result as $pricing): ?>
            <?php /* @var $pricing Wpjb_Model_Pricing */ ?>
            <?php $summary = Wpjb_Model_Membership::getPackageSummary($pricing->id, wp_get_current_user()->ID) ?>
            <tr class="">
                <td class="wpjb-membership-product">
                    <span style="font-size: 1.3em; line-height: 1.5em">
                        <em><?php esc_html_e($pricing->title) ?></em>
                    </span>
                    
                    <?php if(is_object($summary)): ?>
                    <span class="wpjb-bulb wpjb-bulb-active">
                        <?php _e("Active", "wpjobboard") ?>
                    </span>
                    <?php endif; ?>                    
                    
                    <?php $package = unserialize($pricing->meta->package->value()) ?>
                    <?php $single_job = $package[Wpjb_Model_Pricing::PRICE_SINGLE_JOB]; ?>
                    <?php $single_resume = $package[Wpjb_Model_Pricing::PRICE_SINGLE_RESUME]; ?>
                    <ul>
                        <?php if(!empty($single_job)): ?>
                        <li class="wpjb-membership-item-title"><strong><?php _e("Job Postings Included", "wpjobboard") ?></strong></li>
                        <?php foreach($single_job as $id => $usage): ?>
                        <?php 
                            $product = new Wpjb_Model_Pricing($id);
                            $param = array();
                            if($product->meta->is_featured->value()) {
                                $param[] = __("Featured", "wpjobboard");
                            }
                            if($product->meta->visible->value()) {
                                $param[] = sprintf(__("Days Visible: %d", "wpjobboard"), $product->meta->visible->value());
                            }
                            if($usage["status"] == "unlimited") {
                                $param[] = sprintf(__("Unlimited", "wpjobboard"));
                            } else {
                                $param[] = sprintf(__('Max. %1$d Uses', "wpjobboard"), $usage["usage"]);
                            }
                        ?>
                        <li>
                            <?php esc_html_e($product->title." (".join(", ", $param).")") ?>
                        </li>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        
                        <?php if(!empty($single_resume)): ?>
                        <li class="wpjb-membership-item-title"><strong><?php _e("Resumes Access Included", "wpjobboard") ?></strong></li>
                        <?php foreach($single_resume as $id => $usage): ?>
                        <?php 
                            $product = new Wpjb_Model_Pricing($id);
                            $param = array();
                            if($usage["status"] == "unlimited") {
                                $param[] = sprintf(__("Unlimited", "wpjobboard"));
                            } else {
                                $param[] = sprintf(__('Max. %1$d Uses', "wpjobboard"), $usage["usage"]);
                            }
                        ?>
                        <li>
                            <?php esc_html_e($product->title." (".join(", ", $param).")") ?>
                        </li>
                        <?php endforeach; ?>
                        <?php endif; ?>

                    </ul>
                </td>
                <td class="wpjb-last">
                    <span class="wpjb-price">
                        <?php if($pricing->meta->visible->value() < 1): ?>
                        <?php esc_html_e(wpjb_price($pricing->price, $pricing->currency)) ?>
                        <?php else: ?>
                        <?php printf(__('%1$s / %2$d days', 'wpjobboard'), wpjb_price($pricing->price, $pricing->currency), $pricing->meta->visible->value()) ?>
                        <?php endif; ?>
                    </span>
                    <br/>
                    <a href="<?php esc_attr_e(wpjb_link_to("membership", null, array("purchase"=>$pricing->id))) ?>" class="wpjb-button"><?php _e("Purchase", "wpjobboard") ?></a>
                    <?php if($summary): ?>
                    <div style="margin-top: 10px">
                    <a href="<?php esc_attr_e(wpjb_link_to("membership_details", $pricing)) ?>" class="wpjb-button" style=""><?php _e("View Details", "wpjobboard") ?></a>
                    </div>
                    <?php endif; ?>
                </td>
             </tr>
            <?php endforeach; else :?>
            <tr>
                <td colspan="3" align="center">
                    <?php _e("No membership products found.", "wpjobboard"); ?>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>


</div>

