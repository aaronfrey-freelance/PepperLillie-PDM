<?php get_template_part('templates/head'); ?>

<body <?php body_class(); ?>>

  	<!--[if lt IE 8]>
    <div class="alert alert-warning">
      <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'roots'); ?>
    </div>
    <![endif]-->

	<div id="wrap">

	    <?php

	    do_action('get_header');

	    // Use Bootstrap's navbar if enabled in config.php
	    if (current_theme_supports('bootstrap-top-navbar')) {
	    	get_template_part('templates/header-top-navbar');
	    } else {
	    	get_template_part('templates/header');
	    }
	    ?>

	    <div class="wrap container" role="document">

	    	<div class="content row">

	    		<?php if(!is_page('home')) : ?>

	    		<?php
	    		$category = get_the_category();
	    		$cat_name = $category[0]->cat_name;
	    		$title = $cat_name ? $cat_name : get_the_title();
	    		$title = $title ? $title : single_cat_title('', false);
	    		?>

	    		<div class="blue-top col-md-10 col-md-offset-1">
	    			<div class="blue-top-top">
	    				<div class="blue-top-left pull-left"><h1><?php echo $title; ?></h1></div>
	    				<div class="blue-top-right pull-left"></div>
	    				<a href="#" class="pull-right dropdown hidden-lg hidden-md">Show Menu</a>
	    			</div>
	    			<div class="blue-top-bottom"></div>
	    		</div>

	    		<div class="center-content col-md-10 col-md-offset-1">

	    			<main class="main <?php echo roots_main_class(); ?>" role="main">
	    				<?php include roots_template_path(); ?>
	    			</main><!-- /.main -->

	    			<?php
	    				$gallery = get_field('gallery_name');
	    				$singular = is_singular();
	    			?>

	    			<?php if (roots_display_sidebar()) : ?>
	    			<aside class=" hidden-sm hidden-xs sidebar <?php echo roots_sidebar_class(); ?> <?php echo strtolower($cat_name); ?>" role="complementary">
	    				<?php include roots_sidebar_path(); ?>
	    			</aside><!-- /.sidebar -->
	    			<?php endif; ?>

					<?php
						global $wpdb;
						$results = $wpdb->get_results( "SELECT * FROM wp_ngg_gallery WHERE title = '$gallery'", OBJECT );
						if($singular && count($results)) : ?>

							<div class="hidden-xs">
							<?php $gid = $results[0]->gid;
							echo do_shortcode("[nggallery id=$gid w=600 h=450]"); ?>
							</div>
						<?php endif;
					?>

		    	</div>

			    <?php else : ?>

			    <div class="col-md-12">

			    	<main class="main <?php echo roots_main_class(); ?>" role="main">
			    		<?php include roots_template_path(); ?>
			    	</main><!-- /.main -->

			    </div>

				<?php endif; ?>

			</div><!-- /.content -->

		</div><!-- /.wrap -->

	</div>

	<?php get_template_part('templates/footer'); ?>

</body>

</html>