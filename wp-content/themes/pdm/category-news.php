<div class="news-index">

	<h2 class="title-header">Recent News</h2>

	<?php if (!have_posts()) : ?>
	  <div class="alert alert-warning">
	    <?php _e('Sorry, no results were found.', 'roots'); ?>
	  </div>
	<?php endif; ?>

	<?php while (have_posts()) : the_post(); ?>
	  <article <?php post_class(); ?>>
		  <header>
		    <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		  </header>
		  <div class="entry-summary">
		    <?php the_excerpt(); ?>
		  </div>
		  <h2><a href="<?php the_permalink(); ?>" class="read-more">Read More</a></h2>
		</article>
	<?php endwhile; ?>

</div>