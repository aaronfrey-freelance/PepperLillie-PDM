<?php get_template_part('templates/page', 'header'); ?>

<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
  	<?php if(is_search()) : ?>
    	<?php _e('Sorry, no results were found. Please try a new search.', 'roots'); ?>
	<?php else : ?>
		<?php _e('Sorry, no results were found.', 'roots'); ?>
	<?php endif; ?>
  </div>
<?php endif; ?>

<?php if (is_category('about') || is_category('projects')) query_posts($query_string."&orderby=date&order=ASC"); ?>
<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/content', 'category'); ?>
<?php endwhile; ?>