<div class="wrap">
<?php $this->_include("header.php"); ?>
    
<h2>
    <?php _e("Candidates", "wpjobboard"); ?>
    <a class="add-new-h2" href="<?php echo wpjb_admin_url("resumes", "add") ?>"><?php _e("Add New", "wpjobboard") ?></a> 
</h2>

<?php $this->_include("flash.php"); ?>

<form method="post" action="" id="wpjb-delete-form">
    <input type="hidden" name="delete" value="1" />
    <input type="hidden" name="id" value="" id="wpjb-delete-form-id" />
</form>

<ul class="subsubsub">
    <li><a <?php if($show == "all"): ?>class="current"<?php endif; ?> href="<?php esc_attr_e(wpjb_admin_url("resumes", "index", null, array("show"=>"all"))) ?>"><?php _e("All", "wpjobboard") ?></a><span class="count">(<?php echo (int)$stat->total ?>)</span> | </li>
    <li><a <?php if($show == "active"): ?>class="current"<?php endif; ?>href="<?php esc_attr_e(wpjb_admin_url("resumes", "index", null, array("show"=>"active"))) ?>"><?php _e("Active", "wpjobboard") ?></a><span class="count">(<?php echo (int)$stat->active ?>)</span> </li>
    <li><a <?php if($show == "inactive"): ?>class="current"<?php endif; ?>href="<?php esc_attr_e(wpjb_admin_url("resumes", "index", null, array("show"=>"inactive"))) ?>"><?php _e("Inactive", "wpjobboard") ?></a><span class="count">(<?php echo (int)$stat->inactive ?>)</span> </li>
</ul>

<form method="post" action="<?php esc_attr_e(wpjb_admin_url("resumes", "redirect", null, array("noheader"=>true))) ?>" id="posts-filter">
<input type="hidden" name="action" id="wpjb-action-holder" value="-1" />

<div class="tablenav">

<div class="alignleft actions">
    <select id="wpjb-action1">
        <option selected="selected" value="-1"><?php _e("Bulk Actions", "wpjobboard") ?></option>
        <option value="activate"><?php _e("Activate", "wpjobboard") ?></option>
        <option value="deactivate"><?php _e("Deactivate", "wpjobboard") ?></option>
        <option value="delete"><?php _e("Delete", "wpjobboard") ?></option>
    </select>

    <input type="submit" class="button-secondary action" id="wpjb-doaction1" value="<?php _e("Apply", "wpjobboard") ?>"/>

</div>

</div>
    
<div class="clear"/>&nbsp;</div>

<table cellspacing="0" class="widefat post fixed">
    <?php foreach(array("thead", "tfoot") as $tx): ?>
    <<?php echo $tx; ?>>
        <tr>
            <th style="" class="manage-column column-cb check-column" scope="col"><input type="checkbox"/></th>
            <th style="" class="" scope="col"><?php _e("Name", "wpjobboard") ?></th>
            <th style="" class="" scope="col"><?php _e("Headline", "wpjobboard") ?></th>
            <th style="" class="" scope="col"><?php _e("E-mail", "wpjobboard") ?></th>
            <th style="" class="" scope="col"><?php _e("Phone", "wpjobboard") ?></th>
            <th style="" class="" scope="col"><?php _e("Updated (By Owner)", "wpjobboard") ?></th>
            <th style="" class="" scope="col"><?php _e("Status", "wpjobboard") ?></th>
        </tr>
    </<?php echo $tx; ?>>
    <?php endforeach; ?>

    <tbody>
        <?php foreach($data as $i => $item): ?>
        <?php $user = new WP_User($item->user_id); ?>
	<tr valign="top" class="<?php if($i%2==0): ?>alternate <?php endif; ?>  author-self status-publish iedit">
            <th class="check-column" scope="row">
                <input type="checkbox" value="<?php echo $item->getId() ?>" name="item[]"/>
            </th>
            <td class="post-title column-title">
                <strong><a title='<?php _e("Edit", "wpjobboard") ?>' href="<?php echo wpjb_admin_url("resumes", "edit", $item->getId()); ?>" class="row-title"><?php echo ($user->first_name || $user->last_name) ? esc_html(trim($user->first_name." ".$user->last_name)) : esc_html("ID: ".$item->getId()) ?></a></strong>
                <div class="row-actions">
                    <span class="edit"><a title="<?php _e("Edit", "wpjobboard") ?>" href="<?php echo wpjb_admin_url("resumes", "edit", $item->getId()); ?>"><?php _e("Edit", "wpjobboard") ?></a> | </span>
                    <span class="view"><a rel="permalink" title="<?php _e("View", "wpjobboard") ?>" href="<?php echo wpjr_link_to("resume", $item) ?>"><?php _e("View", "wpjobboard") ?></a> | </span>
                    <span><a href="<?php echo wpjb_admin_url("resumes", "remove")."&".http_build_query(array("users"=>array($item->id))) ?>" class="wpjb-delete wpjb-no-confirm"><?php _e("Delete", "wpjobboard") ?></a> </span>
                </div>
            </td>
            <td class="author column-author"><?php echo esc_html($item->headline) ?></td>
            <td class="categories column-categories"><?php echo $item->getUser()->user_email ?></td>
            <td class="tags column-tags"><?php echo $item->phone ?></td>
            <td class="date column-date">
                <?php echo wpjb_date($item->modified_at) ?><br/>
                <small>
                    <?php if($item->modified_at == date("Y-m-d")): ?>
                    <?php _e("Today", "wpjobboard"); ?>
                    <?php else: ?>
                    <?php esc_html_e(daq_time_ago_in_words(strtotime($item->modified_at))." ".__("ago", "wpjobboard")) ?>
                    <?php endif; ?>
                </small>
            </td>
            <td class="date column-date">
                <?php if($item->is_active): ?>
                <span class="wpjb-bulb wpjb-bulb-active"><?php _e("Active", "wpjobboard") ?></span>
                <?php else: ?>
                <span class="wpjb-bulb wpjb-bulb-inactive"><?php _e("Disabled", "wpjobboard") ?></span>
                <?php endif; ?>
                
                <?php if($item->is_public): ?>
                <span class="wpjb-bulb wpjb-bulb-active"><?php _e("Public", "wpjobboard") ?></span>
                <?php else: ?>
                <span class="wpjb-bulb wpjb-bulb-inactive"><?php _e("Private", "wpjobboard") ?></span>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="tablenav">
    <div class="tablenav-pages">
        <?php
        echo paginate_links( array(
            'base' => wpjb_admin_url("resumes", "index", null, $param)."%_%",
            'format' => '&p=%#%',
            'prev_text' => __('&laquo;'),
            'next_text' => __('&raquo;'),
            'total' => $total,
            'current' => $current
        ));
        ?>
    </div>


    <div class="alignleft actions">
        <select id="wpjb-action2">
            <option selected="selected" value="-1"><?php _e("Bulk Actions", "wpjobboard") ?></option>
            <option value="activate"><?php _e("Activate", "wpjobboard") ?></option>
            <option value="deactivate"><?php _e("Deactivate", "wpjobboard") ?></option>
            <option value="delete"><?php _e("Delete", "wpjobboard") ?></option>
        </select>
        <input type="submit" class="button-secondary action" id="wpjb-doaction2" value="<?php _e("Apply", "wpjobboard") ?>"/>

        <br class="clear"/>
    </div>

    <br class="clear"/>
</div>


</form>


<?php $this->_include("footer.php"); ?>