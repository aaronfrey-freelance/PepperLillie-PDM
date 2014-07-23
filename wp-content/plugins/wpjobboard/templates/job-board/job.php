<?php 

/**
 * Job details
 * 
 * This template is responsible for displaying job details on job details page
 * (template single.php) and job preview page (template preview.php)
 * 
 * @author Greg Winiarski
 * @package Templates
 * @subpackage JobBoard
 */

 /* @var $job Wpjb_Model_Job */
 /* @var $company Wpjb_Model_Employer */

?>

    <?php $job = wpjb_view("job") ?>

    <div itemscope itemtype="http://schema.org/JobPosting">
    <meta itemprop="title" content="<?php esc_attr_e($job->job_title) ?>" />
    <meta itemprop="datePosted" content="<?php esc_attr_e($job->job_created_at) ?>" />
        
    <table class="wpjb-info">
        <tbody>
            <?php if($job->company_name): ?>
            <tr>
                <td class="wpjb-info-label"><?php _e("Company Name", "wpjobboard") ?></td>
                <td class="wpjb-row-icon-company">

                    <span itemprop="hiringOrganization" itemscope itemtype="http://schema.org/Organization">
                        <span itemprop="name">
                            <?php wpjb_job_company($job) ?>
                        </span>
                    </span>
                    <?php wpjb_job_company_profile($job->getCompany(true)) ?>
                </td>
            </tr>
            <?php endif; ?>
            <?php if($job->locationToString()): ?>
            <tr>
                <td class="wpjb-info-label"><?php _e("Location", "wpjobboard") ?></td>
                <td class="wpjb-row-icon-location">

                    <span itemprop="jobLocation" itemscope itemtype="http://schema.org/Place">
                        <span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                            <meta itemprop="addressLocality" content="<?php esc_attr_e($job->job_city) ?>" /> 
                            <meta itemprop="addressRegion" content="<?php esc_attr_e($job->job_state) ?>" />
                            <meta itemprop="addressCountry" content="<?php $country = Wpjb_List_Country::getByCode($job->job_country); esc_attr_e($country["iso2"]) ?>" />
                            <meta itemprop="postalCode" content="<?php esc_attr_e($job->job_zip_code) ?>" />
   
                    
                            <?php if(wpjb_conf("show_maps") && $job->getGeo()->status==2): ?>
                            <a href="http://maps.google.com/?ie=UTF8&amp;t=m&amp;near=<?php esc_attr_e(urlencode($job->location())) ?>&amp;ll=<?php echo $job->getGeo()->lnglat ?>&amp;spn=0.107734,0.686646&amp;z=15&amp;output=embed&amp;iwloc=near" class="wpjb-tooltip"><?php esc_html_e($job->locationToString()) ?></a>
                            <?php else: ?>
                            <?php esc_html_e($job->locationToString()) ?>
                            <?php endif; ?>
                    
                        </span>
                    </span>
                </td>
            </tr>
            <?php if(wpjb_conf("show_maps") && $job->getGeo()->status==2): ?>
            <tr class="wpjb-none wpjb-map-slider">
                <td colspan="2">
                    <iframe style="width:100%;height:250px;margin:0;padding:0;" width="100%" height="200" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src=""></iframe>
                </td>
            </tr>
            <?php endif; ?>
            <?php endif; ?>
            <tr>
                <td class="wpjb-info-label"><?php _e("Date Posted", "wpjobboard") ?></td>
                <td class="wpjb-row-icon-date"><?php echo wpjb_date_display(get_option('date_format'), $job->job_created_at) ?></td>
            </tr>
            <?php if(!empty($job->getTag()->category)): ?>
            <tr>
                <td class="wpjb-info-label"><?php _e("Category", "wpjobboard") ?></td>
                <td class="wpjb-row-icon-category">
                    <?php foreach($job->getTag()->category as $category): ?>
                    <a href="<?php esc_attr_e(wpjb_link_to("category", $category)) ?>">
                        <span itemprop="occupationalCategory"><?php esc_html_e($category->title) ?></span>
                    </a>
                    <br/>
                    <?php endforeach; ?>
                </td>
            </tr>
            <?php endif ?>
            <?php if(!empty($job->getTag()->type)): ?>
            <tr>
                <td class="wpjb-info-label"><?php _e("Job Type", "wpjobboard") ?></td>
                <td class="wpjb-row-icon-type">
                    <?php foreach($job->getTag()->type as $type): ?>
                    <a href="<?php esc_attr_e(wpjb_link_to("type", $type)) ?>">
                        <span itemprop="employmentType"><?php esc_html_e($type->title) ?></span>
                    </a>
                    <br/>
                    <?php endforeach; ?>
                </td>
            </tr>
            <?php endif; ?>
            
            <?php foreach($job->getMeta(array("visibility"=>0, "meta_type"=>3, "empty"=>false, "field_type_exclude"=>"ui-input-textarea")) as $k => $value): ?>
            <tr>
                <td class="wpjb-info-label"><?php esc_html_e($value->conf("title")); ?></td>
                <td>
                    <?php if($value->conf("type") == "ui-input-file"): ?>
                        <?php foreach($job->file->{$value->name} as $file): ?>
                        <a href="<?php esc_attr_e($file->url) ?>" rel="nofollow"><?php esc_html_e($file->basename) ?></a>
                        <?php echo wpjb_format_bytes($file->size) ?><br/>
                        <?php endforeach ?>
                    <?php else: ?>
                        <?php esc_html_e(join(", ", (array)$value->values())) ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            
            <?php do_action("wpjb_template_job_meta_text", $job) ?>
        </tbody>
    </table>



    <div class="wpjb-job-content">

        <h3><?php _e("Description", "wpjobboard") ?></h3>
        <div itemprop="description" class="wpjb-job-text">

            <?php if($job->getLogoUrl()): ?>
            <div><img src="<?php echo $job->getLogoUrl() ?>" id="wpjb-logo" alt="" /></div>
            <?php endif; ?>

            <?php wpjb_rich_text($job->job_description, $job->meta->job_description_format->value()) ?>
            
        </div>

        <?php foreach($job->getMeta(array("visibility"=>0, "meta_type"=>3, "empty"=>false, "field_type"=>"ui-input-textarea")) as $k => $value): ?>
        
        <h3><?php esc_html_e($value->conf("title")); ?></h3>
        <div class="wpjb-job-text">
            <?php wpjb_rich_text($value->value(), $value->conf("textarea_wysiwyg") ? "html" : "text") ?>
        </div>
        
        <?php endforeach; ?>

        <?php do_action("wpjb_template_job_meta_richtext", $job) ?>
    </div>
        
    </div>
