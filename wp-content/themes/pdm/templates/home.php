<!-- This is the main page -->

<?php
	global $wpdb;
	$results = $wpdb->get_results( "SELECT * FROM wp_ngg_gallery WHERE slug = 'homepage'", OBJECT );
	if(count($results)) {
		global $nggdb;
		$gallery = $nggdb->get_gallery($results[0]->gid, 'sortorder', 'ASC', true, 0, 0);
	}
?>

<div id="front-page">

	<script type="text/javascript">
	jQuery('#front-page .full-screen-container').hide();
	</script>

	<?php if($gallery) :
		reset($gallery);
		$first_key = key($gallery);
	?>

		<div class="full-screen-controls hidden-sm hidden-xs">
			<a href="#" class="previous"></a>
			<a href="#" class="next"></a>
		</div>

		<div class="full-screen-container">

			<?php foreach($gallery as $index => $p) : ?>
			<div
				class="full-screen <?php echo $index === $first_key ? 'active' : '' ?>"
				data-background="<?php echo $p->imageURL; ?>">
				<div class="project-info">
					<p class="project-title"><?php echo $p->alttext; ?></p>
					<p class="project-location"><?php echo $p->description; ?></p>
				</div>
			</div>
			<?php endforeach; ?>

		</div>


		</div>
	<?php endif; ?>
</div>