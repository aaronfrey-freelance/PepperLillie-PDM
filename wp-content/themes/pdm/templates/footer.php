<footer class="content-info" role="contentinfo">
  <div class="container">

		<ul class="pull-left">
			<li><?php echo get_option('address1'); ?></li>
			<li><?php echo get_option('address2'); ?></li>
			<li><?php echo get_option('address3'); ?></li>
			<li><?php echo get_option('phonenumber'); ?></li>
		</ul>

		<div class="social-footer pull-right">
			<a href="<?php echo get_option('linkedinurl'); ?>" target="_blank" title="Go to LinkedIn" class="linkedin">LinkedIn</a>
			<a href="<?php echo get_option('facebookurl'); ?>" target="_blank" title="Go to Facebook" class="facebook">Facebook</a>
			<a href="<?php echo get_option('youtubeurl'); ?>" target="_blank" title="Go to Youtube" class="youtube">Youtube</a>
		</div>

  </div>
</footer>

<?php wp_footer(); ?>
