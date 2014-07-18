<?php if(is_page('home')) : ?>

<div id="teasers">

	<div class="blue-box" id="blue-box">

		<div class="blue-border-corner"></div>
		<div class="blue-border-top"></div>

		<div>
			<div class="blue-border-left pull-left"></div>
			<div class="blue-box-content pull-left">
				<p>Philadelphia D&M (PDM) is the tri-state area’s premier construction subcontractor — specializing in exterior framing, EIFS, drywall, fabricated drywall shapes, rough and finish carpentry, acoustical and specialty ceilings, millwork, spray foam insulation, and spray fireproofing.</p>
				<a href="#">Learn More</a>
			</div>
		</div>
	</div>

	<div class="white-box hidden-xs" id="white-box">

		<div class="white-border-corner"></div>

		<div class="pull-left">
			<div class="white-border-top pull-left"></div>
			<div class="white-border-top-right pull-left"></div>
		</div>

		<div>
			<div class="pull-left">
				<div class="white-border-left"></div>
				<div class="white-border-bottom-left"></div>
			</div>
			<div class="white-box-content pull-left">

				<!-- Get the Featured Project -->
				<div class="teaser-pane" id="teaser-project">
					<?php

					$args = array(
				        'category_name' => 'projects',
				        'posts_per_page' => 1,
				        'tag' => 'featured',
				    );

					$the_query = new WP_Query( $args );

					while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
						<div>
							<div class="pull-left teaser-title">
								<h2><?php the_title(); ?></h2>
								<a href="<?php the_permalink(); ?>">Learn More ></a>
							</div>
							<div class="pull-left teaser-image">
								<?php the_post_thumbnail('teaser'); ?>
							</div>
						</div>
					<?php endwhile;

					wp_reset_postdata()

					?>
				</div>

				<!-- Get the Featured Service -->
				<div class="teaser-pane" id="teaser-service">
					<?php

					$args = array(
				        'category_name' => 'services',
				        'posts_per_page' => 1,
				        'tag' => 'featured',
				    );

					$the_query = new WP_Query( $args );

					while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
						<div>
							<div class="pull-left teaser-title">
								<h1>Services Spotlight:</h1>
								<h2><?php the_title(); ?></h2>
								<a href="<?php the_permalink(); ?>">Learn More ></a>
							</div>
							<div class="pull-left teaser-image">
								<?php the_post_thumbnail('teaser'); ?>
							</div>
						</div>
					<?php endwhile;

					wp_reset_postdata()

					?>
				</div>

				<!-- Get the Recent News -->
				<div class="teaser-pane" id="teaser-news">
					<?php

					$args = array(
				        'category_name' => 'news',
				        'posts_per_page' => 1,
				         'orderby' => 'date',
				         'order' => 'DESC'
				    );

					$the_query = new WP_Query( $args );

					while ( $the_query->have_posts() ) : $the_query->the_post();
						$article_url = get_field('article_url');
						$url = $article_url ? $article_url : get_the_permalink();
					?>
						<div>
							<div class="pull-left teaser-title">
								<h1>Recent News</h1>
								<a href="<?php echo get_category_link(7); ?>">More News ></a>
							</div>
							<div class="pull-left teaser-image">
								<h2><?php the_title(); ?></h2>
								<p><?php the_excerpt(); ?></p>
								<a href="<?php echo $url; ?>" class="read-more">Read More</a>
							</div>
						</div>
					<?php endwhile;

					wp_reset_postdata()

					?>
				</div>
			</div>
		</div>

	</div>

</div>

<div class="red-footer">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<ul id="teaser-links">
					<li><a data-type="teaser-project">Featured Project</a></li>
					<li><a data-type="teaser-service">Services Spotlight</a></li>
					<li><a data-type="teaser-news">Recent News</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<?php endif; ?>

<footer class="content-info" role="contentinfo">

  <div class="container">

		<div class="row">

			<div class="col-md-9 col-sm-10 col-xs-12">
				<div class="address-footer">
					<span class="first"><?php echo get_option('address1'); ?></span>
					<span class="border"></span>
					<span><?php echo get_option('address2'); ?></span>
					<span class="border"></span>
					<span><?php echo get_option('address3'); ?></span>
					<span class="border"></span>
					<span><?php echo get_option('phonenumber'); ?></span>
					<a href="#" class="ftp hidden-sm hidden-xs">FTP</a>
				</div>
			</div>

			<div class="col-md-3 col-sm-2 col-xs-12">
				<div class="social-footer">
					<span class="hidden-sm">Connect</span>
					<a href="<?php echo get_option('linkedinurl'); ?>" target="_blank" title="Go to LinkedIn" class="linkedin">LinkedIn</a>
					<a href="<?php echo get_option('facebookurl'); ?>" target="_blank" title="Go to Facebook" class="facebook">Facebook</a>
					<a href="<?php echo get_option('youtubeurl'); ?>" target="_blank" title="Go to Youtube" class="youtube">Youtube</a>
				</div>
			</div>

		</div>

  </div>

</footer>

<?php wp_footer(); ?>