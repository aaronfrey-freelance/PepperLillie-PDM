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