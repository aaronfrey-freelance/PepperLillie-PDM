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
			<div class="white-box-content pull-left"></div>
		</div>

	</div>

</div>

<div class="red-footer">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<ul id="teaser-links">
					<li><a href="#">Featured Project</a></li>
					<li><a href="#">Services Spotlight</a></li>
					<li><a href="#">Recent News</a></li>
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