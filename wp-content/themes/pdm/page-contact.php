<strong>Phone: </strong><?php echo get_option('phonenumber'); ?><br>
<strong>Fax: </strong><?php echo get_option('faxnumber'); ?><br>

<br>

<?php echo get_option('address1'); ?><br>
<?php echo get_option('address2'); ?><br>
<?php echo get_option('address3'); ?><br>

<?php if (have_posts()) : while (have_posts()) : the_post();?>
<div>
    <h2><?php the_title();?></h2>
    <div class="entrytext">
        <?php the_content(); ?>
    </div>
</div>
<?php endwhile; endif; ?>