<div class="news-index">

	<h2 class="title-header">Recent News</h2>

	<?php if (!have_posts()) : ?>
	  <div class="alert alert-warning">
	    <?php _e('Sorry, no results were found.', 'roots'); ?>
	  </div>
	<?php endif; ?>

	<?php while (have_posts()) : the_post();
		$article_url = get_field('article_url');
		$url = $article_url ? $article_url : get_the_permalink();
	?>
	  <article <?php post_class(); ?>>
		  <header>
		    <h2 class="entry-title">
		    	<a href="<?php echo $url; ?>"><?php the_title(); ?></a>
		    </h2>
		  </header>
		  <div class="entry-summary">
		    <?php the_excerpt(); ?>
		    <a href="<?php echo $url; ?>" class="read-more">Read More</a>
		  </div>
		</article>
	<?php endwhile; ?>

</div>