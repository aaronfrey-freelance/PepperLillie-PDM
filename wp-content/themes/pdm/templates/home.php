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

	<div class="project-info">
		<p class="project-title" id="project-title"><?php echo $gallery[$first_key]->alttext; ?></p>
		<p class="project-location" id="project-location"><?php echo $gallery[$first_key]->description; ?></p>
	</div>

	<div class="full-screen-container">

		<div class="overlay visible-xs"></div>

		<?php foreach($gallery as $index => $p) : ?>
		<div
			class="full-screen <?php echo $index === $first_key ? 'active' : '' ?>"
			data-background="<?php echo $p->imageURL; ?>"
			data-title="<?php echo $p->alttext; ?>"
			data-location="<?php echo $p->description; ?>">
		</div>
		<?php endforeach; ?>

	</div>

	<?php endif; ?>
</div>