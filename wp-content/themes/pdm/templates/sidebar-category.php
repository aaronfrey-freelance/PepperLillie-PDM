<ul class="sidebar-category">
<?php
$category = get_the_category();
$cat_id = $category[0]->cat_ID;
$cat_name = $category[0]->cat_name;
$current_id = get_the_ID();
?>

<?php $current = get_the_ID(); ?>

<?php query_posts($query_string."&category__in=$cat_id&orderby=date&order=ASC"); ?>
<?php while (have_posts()) : the_post(); ?>
  <li class="<?php echo $current_id == get_the_ID() ? 'active' : ''; ?> ">
  	<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
  </li>
<?php endwhile; wp_reset_query(); ?>
</ul>