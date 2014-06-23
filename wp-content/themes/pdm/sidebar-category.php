<ul id="sidebar-category" class="hidden-sm hidden-xs">
<?php
$category = get_the_category();
$cat_id = $category[0]->cat_ID;
?>

<?php query_posts($query_string."&category__in=$cat_id&orderby=date&order=ASC"); ?>
<?php while (have_posts()) : the_post(); ?>
  <li>
  	<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
  </li>
<?php endwhile; ?>
</ul>