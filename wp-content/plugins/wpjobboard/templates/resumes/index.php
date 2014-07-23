<?php 

/**
 * Resumes list
 * 
 * 
 * @author Greg Winiarski
 * @package Templates
 * @subpackage Resumes
 */

 /* @var $resumeList array of Wpjb_Model_Resume objects */
 /* @var $can_browse boolean True if user has access to resumes */

?>

<div id="wpjb-main" class="wpjr-page-resumes">

    <?php wpjb_flash(); ?>

    <table id="wpjb-resume-list" class="wpjb-table">
        <thead>
            <tr>
                <th><?php _e("Name", "wpjobboard") ?></th>
                <th><?php _e("Title", "wpjobboard") ?></th>
                <th class="wpjb-last"><?php _e("Updated", "wpjobboard") ?></th>
            </tr>
        </thead>
        <tbody>
        <?php $result = wpjb_find_resumes($param); ?>
        <?php if ($result->count > 0) : foreach($result->resume as $resume): ?>
            <?php /* @var $resume Wpjb_Model_Resume */ ?>
            <?php $this->resume = $resume; ?>
            <?php $this->render("index-item.php") ?>
            <?php endforeach; else :?>
            <tr>
                <td colspan="3" align="center">
                    <?php _e("No resumes found.", "wpjobboard"); ?>
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div id="wpjb-paginate-links">
        <?php wpjb_paginate_links($url, $result->pages, $result->page, $query) ?>
    </div>


</div>
