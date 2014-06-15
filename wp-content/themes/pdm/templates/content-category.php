<article <?php post_class($wp_query->current_post === 0 ? 'first-post' : ''); ?>>
  <header>
    <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
  </header>
  <div class="entry-summary">
    <?php the_content(); ?>
  </div>
</article>
