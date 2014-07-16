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

	   	<?php if(!is_page('home')) : ?>

	    <div class="wrap container" role="document">

	    	<div class="content row">

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

						<!-- If this is the Projects Archive page -->
						<?php if(is_category(4)) : ?>
						<div class="dark-blue hidden-xs">
							<a href="<?php echo get_option('resumelink'); ?>" target="_blank">
	    						<div class="dark-blue-top-left pull-left">DOWNLOAD PROJECT RESUME (PDF)</div>
	    						<div class="dark-blue-top-right pull-left"></div>
	    					</a>
						</div>

						<!-- Else if the post is in the About or Projects categories -->
						<?php elseif(in_category(3) || in_category(4)) : ?>

	    				<a href="#" class="pull-right dropdown hidden-lg hidden-md">Show Menu</a>

	    				<?php endif; ?>

	    			</div>
	    			<div class="blue-top-bottom"></div>

					<?php if(is_category(4)) : ?>
					<div class="dark-blue visible-xs">
						<a href="<?php echo get_option('resumelink'); ?>" target="_blank">
    						<div class="dark-blue-top-left">DOWNLOAD PROJECT RESUME (PDF)</div>
    					</a>
					</div>
					<?php endif; ?>

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

		    	</div>

				<div class="col-md-10 col-md-offset-1 image-slider hidden-xs">
		    		<?php global $wpdb;
					$results = $wpdb->get_results( "SELECT * FROM wp_ngg_gallery WHERE title = '$gallery'", OBJECT );
					if($singular && count($results)) : $gid = $results[0]->gid; ?>
					<div class="slider-grey-bar">
						<div class="slider-header pull-left">Project Gallery</div>
						<div class="slider-sub-header pull-left">Click each photo to view larger</div>
					</div>
					<div class="slider-content">
						<div class="advance-bar"></div>
						<div class="advance-arrow left"></div>
						<?php echo do_shortcode("[nggallery id=$gid w=600 h=450]"); ?>
						<div class="advance-bar right"></div>
						<div class="advance-arrow right"></div>
					</div>
					<div class="slider-bottom"></div>
					<?php endif; ?>
				</div>

			</div><!-- /.content -->

		</div><!-- /.wrap -->

	    <?php else : ?>

		<!-- This is the main page -->

		<?php
			$args = array(
				'posts_per_page'   => 100,
				'category'         => '4',
				'meta_key'         => 'upload_image',
				'orderby'          => 'post_date',
				'order'            => 'DESC',
				'post_type'        => 'post',
				'post_status'      => 'publish');
			$posts_array = get_posts( $args );
		?>

	    <div id="front-page">
	    	<?php if($posts_array) : ?>
	    		<div class="project-info">
	    			<p id="project-title"></p>
	    			<p id="project-location"></p>
	    		</div>
	    		<div class="full-screen-controls hidden-sm hidden-xs">
	    			<a href="#" class="previous"></a>
	    			<a href="#" class="next"></a>
	    		</div>
	    		<?php foreach($posts_array as $post) : ?>
	    		<div
	    			class="full-screen"
	    			data-background="<?php echo $post->upload_image; ?>"
	    			data-title="<?php echo $post->post_title; ?>"
	    			data-location="<?php echo get_field('project_location', $post->ID); ?>">
	    		</div>
				<?php endforeach; ?>
			<?php endif; ?>
	    </div>

		<?php endif; ?>

	</div>

	<?php get_template_part('templates/footer'); ?>

</body>

</html>