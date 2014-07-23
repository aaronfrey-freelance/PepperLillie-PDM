    <tr class="">
        <td>
            <a href="<?php echo wpjr_link_to("resume", $resume) ?>"><?php esc_html_e($resume->getSearch(true)->fullname) ?></a>
        </td>
        <td>
            <?php esc_html_e($resume->headline) ?>
        </td>
        <td class="wpjb-last wpjb-column-date">
            <?php echo wpjb_date_display("M, d", $resume->modified_at, true); ?>
        </td>
     </tr>