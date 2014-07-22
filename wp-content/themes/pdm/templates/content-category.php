<article <?php post_class($wp_query->current_post === 0 ? 'first-post' : ''); ?>>
  <header>
    <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
  </header>
  <div class="entry-summary">
  <?php if(is_search()) : ?>
		<?php the_excerpt(); ?>
    <a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
	<?php else : ?>
    	<?php the_content(); ?>
	<?php endif; ?>
  </div>
</article>
