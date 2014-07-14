<div class="projects-index">

<?php query_posts($query_string."&orderby=date&order=ASC"); ?>
<?php while (have_posts()) : the_post(); ?>

	<div class="col-sm-4">

		<a href="<?php the_permalink(); ?>">
		  <article <?php post_class(); ?>>
			  <div class="entry-summary">
			    <div class="project-image">
			    	 <?php the_post_thumbnail('project-landing'); ?>
			    </div>
			    <div class="entry-title">
			    	<?php the_title(); ?>
			    </div>
			  </div>
			</article>
		</a>

	</div>

<?php endwhile; ?>

</div>