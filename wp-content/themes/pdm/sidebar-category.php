<ul id="sidebar-category">
<?php query_posts($query_string."&orderby=date&order=ASC"); ?>
<?php while (have_posts()) : the_post(); ?>
  <li <?php post_class(); ?> data-post-id="post-<?php echo the_ID(); ?>">
  	<a href="#"><?php the_title(); ?></a>
  </li>
<?php endwhile; ?>
</ul>