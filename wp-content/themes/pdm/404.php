<?php get_template_part('templates/page', 'header'); ?>

<div class="alert alert-warning">
  Sorry, but the page you were trying to view does not exist. Please visit the <a href="<?php echo home_url(); ?>">Home Page</a> to find the new location of the page, or <a href="<?php echo home_url('contact'); ?>">Contact Us</a> for assistance.
</div>

<p><?php _e('It looks like this was the result of either:', 'roots'); ?></p>
<ul>
  <li><?php _e('a mistyped address', 'roots'); ?></li>
  <li><?php _e('an out-of-date link', 'roots'); ?></li>
</ul>

<?php get_search_form(); ?>
