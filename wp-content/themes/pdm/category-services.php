<div class="services-index">

	<h1>PDM maintains a variety of products and services:</h1>

	<?php while (have_posts()) : the_post(); ?>
	  <div <?php post_class('row'); ?>>
	  	<div class="col-sm-8">
			  <header>
			    <h2 class="entry-title"><?php the_title(); ?></h2>
			  </header>
			  <div class="entry-summary">
			    <?php the_content(); ?>
			  </div>
		  </div>
		  <div class="col-sm-4 featured">
		  	<?php the_post_thumbnail(); ?>
		  </div>
		</div>
	<?php endwhile; ?>

</div>