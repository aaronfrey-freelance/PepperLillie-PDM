<?php get_template_part('templates/page', 'header'); ?>

<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'roots'); ?>
  </div>
<?php endif; ?>

<?php query_posts($query_string."&orderby=date&order=ASC"); ?>
<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/content', 'category'); ?>
<?php endwhile; ?>