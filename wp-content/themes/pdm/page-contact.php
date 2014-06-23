<h2>Contact Information</h2>
<strong>Phone: </strong><?php echo get_option('phonenumber'); ?><br>
<strong>Fax: </strong><?php echo get_option('faxnumber'); ?><br>

<br>

<strong>Address:</strong><br>
<?php echo get_option('address2'); ?><br>
<?php echo get_option('address3'); ?><br>

<br>

<?php if (have_posts()) : while (have_posts()) : the_post();?>
<div>
    <div class="entrytext">
        <?php the_content(); ?>
    </div>
</div>
<?php endwhile; endif; ?>