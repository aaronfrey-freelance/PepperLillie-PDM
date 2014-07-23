<div id="wpjb-main">
    <span style="line-height:2.6em; font-size:1.3em">
        <?php printf(__('Expires <strong>%1$s</strong>', "wpjobboard"), wpjb_date_display(get_option("date_format"), $summary->expires_at)) ?>

        <?php if($summary->days_left == 0): ?>
        <?php _e("(expires today)", "wpjobboard") ?>
        <?php else: ?>
        <?php echo sprintf( _n( '(1 day left)', '(%s days left)', $summary->days_left, 'wpjobboard' ), $summary->days_left ) ?>
        <?php endif; ?>
    </span>
    
    <?php if($summary->updates_at): ?>
    <div class="wpjb-flash-info">
        <span><?php printf(__("Some credits will expire on <strong>%s</strong>.", "wpjobboard"), wpjb_date_display(get_option("date_format"), $summary->expires_at)) ?></span>
    </div>
    <?php endif ?>
    
    <table class="wpjb-info">
        <tbody>
            <?php 
                $package = $summary->bundle;
                $inc_grup = array(
                    Wpjb_Model_Pricing::PRICE_SINGLE_JOB => __("Job Postings Included", "wpjobboard"),
                    Wpjb_Model_Pricing::PRICE_SINGLE_RESUME => __("Resumes Access Included", "wpjobboard")
                );
            ?>
            <?php foreach($inc_grup as $k => $title): ?>
            <?php if(isset($package[$k]) && !empty($package[$k])): ?>
            <tr><td><strong style="font-size:1.2em"><?php esc_html_e($title) ?></strong></td><td>&nbsp;</td></tr>
            <?php foreach($package[$k] as $usage): ?>
            <?php $product = new Wpjb_Model_Pricing($usage["id"]) ?>
            <tr>
                <td>
                    <?php esc_html_e($product->title) ?>
                </td>
                <td>
                    <strong>
                        <?php if($usage["status"] == "unlimited"): ?><?php _e("Unlimited", "wpjobboard") ?><?php else: ?><?php echo $usage["used"]."/".$usage["usage"] ?><?php endif; ?>
                    </strong>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <div>
        <a href="<?php esc_attr_e(wpjb_link_to("membership", null, array("purchase"=>$pricing->id))) ?>" class="wpjb-button"><?php _e("Renew", "wpjobboard") ?></a>
        <a href="<?php esc_attr_e(wpjb_link_to("membership")) ?>" class="wpjb-button"><?php _e("Go Back", "wpjobboard") ?></a>
    </div>
</div>