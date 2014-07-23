<div class="news-index">

	<h2 class="title-header">Recent News</h2>

	<?php if (!have_posts()) : ?>
	  <div class="alert alert-warning">
	    <?php _e('Sorry, no results were found.', 'roots'); ?>
	  </div>
	<?php endif; ?>

	<?php while (have_posts()) : the_post();
		$article_file = get_field('article_file');
		$article_url = get_field('article_url');
		$target = $article_file || $article_url ? '_blank' : '_self';
		$url = $article_file ? $article_file : ($article_url ? $article_url : get_the_permalink());
	?>
	  <article <?php post_class(); ?>>
		  <header>
		    <h2 class="entry-title">
		    	<a href="<?php echo $url; ?>" target="<?php echo $target; ?>"><?php the_title(); ?></a>
		    </h2>
		  </header>
		  <div class="entry-summary">
		    <?php the_excerpt(); ?>
		    <a href="<?php echo $url; ?>" target="<?php echo $target; ?>" class="read-more">Read More</a>
		  </div>
		</article>
	<?php endwhile; ?>

</div>