<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    <header>
      <h2 class="entry-title"><?php the_title(); ?></h2>
    </header>
    <div class="entry-content">
      <h3><?php the_field('project_location'); ?></h3>
      <?php the_content(); ?>
    </div>
    <footer>
      <?php wp_link_pages(array('before' => '<nav class="page-nav"><p>' . __('Pages:', 'roots'), 'after' => '</p></nav>')); ?>
    </footer>

  </article>
<?php endwhile; ?>
