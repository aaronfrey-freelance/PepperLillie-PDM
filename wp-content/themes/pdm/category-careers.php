<div class="careers-index">

	<h2 class="title-header">Job Listings</h2>

	<table class="table">
    <thead>
      <tr>
        <th>Job Title</th>
        <th>Location</th>
        <th>Date Posted</th>
      </tr>
    </thead>
    <tbody>
			<?php while (have_posts()) : the_post(); ?>
				<tr <?php post_class(); ?>>
	        <td>
	        	<a href="<?php the_permalink(); ?>" class="job-title">
	        		<?php the_field('job_title'); ?>
	        	</a>
	        </td>
	        <td><?php the_field('job_location'); ?></td>
	        <td>
	        	<?php if(strtotime('+5 Days', strtotime(get_the_time())) > time()) : ?>
	        		<div class="recent pull-left">New</div>
	        	<?php endif; ?>
	        	<?php the_time( get_option( 'date_format' ) ); ?><br>
	        	<?php the_field('job_type'); ?>
	        </td>
	      </tr>
			<?php endwhile; ?>
    </tbody>
  </table>

</div>