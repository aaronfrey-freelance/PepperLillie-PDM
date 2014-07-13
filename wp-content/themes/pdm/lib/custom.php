<?php

// Custom Theme Settings
add_action('admin_menu', 'add_gcf_interface');

function add_gcf_interface() {
    add_options_page('Global Custom Fields', 'Global Custom Fields', '8', 'functions', 'editglobalcustomfields');
}

function editglobalcustomfields() {
    ?>
    <div class='wrap'>
    <h2>Custom Fields</h2>
    <form method="post" action="options.php">
    <?php wp_nonce_field('update-options') ?>

    <p><strong>Address Line 1:</strong><br />
    <input type="text" name="address1" size="100" value="<?php echo get_option('address1'); ?>" /></p>

    <p><strong>Address Line 2:</strong><br />
    <input type="text" name="address2" size="100" value="<?php echo get_option('address2'); ?>" /></p>

    <p><strong>Address Line 3:</strong><br />
    <input type="text" name="address3" size="100" value="<?php echo get_option('address3'); ?>" /></p>

    <p><strong>Phone Number:</strong><br />
    <input type="text" name="phonenumber" size="100" value="<?php echo get_option('phonenumber'); ?>" /></p>

    <p><strong>Fax Number:</strong><br />
    <input type="text" name="faxnumber" size="100" value="<?php echo get_option('faxnumber'); ?>" /></p>

    <p><strong>LinkedIn URL:</strong><br />
    <input type="text" name="linkedinurl" size="100" value="<?php echo get_option('linkedinurl'); ?>" /></p>

    <p><strong>Facebook URL:</strong><br />
    <input type="text" name="facebookurl" size="100" value="<?php echo get_option('facebookurl'); ?>" /></p>

    <p><strong>YouTube URL:</strong><br />
    <input type="text" name="youtubeurl" size="100" value="<?php echo get_option('youtubeurl'); ?>" /></p>

    <p><input type="submit" name="Submit" value="Update Options" /></p>

    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="address1,address2,address3,phonenumber,faxnumber,linkedinurl,facebookurl,youtubeurl" />

    </form>
    </div>
    <?php

    add_filter( 'wp_nav_menu_objects', 'wpse16243_wp_nav_menu_objects' );
    function wpse16243_wp_nav_menu_objects( $sorted_menu_items )
    {
        foreach ( $sorted_menu_items as $menu_item ) {
            if ( $menu_item->current ) {
                $GLOBALS['wpse16243_title'] = $menu_item->title;
                break;
            }
        }
        return $sorted_menu_items;
    }

    add_filter( 'single_cat_title', 'wpse16243_single_cat_title' );
    function wpse16243_single_cat_title( $cat_title )
    {
        if ( isset( $GLOBALS['wpse16243_title'] ) ) {
            return $GLOBALS['wpse16243_title'];
        }
        return $cat_title;
    }
}

// Excerpt Functions
function custom_excerpt_length( $length ) {
    return 35;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function new_excerpt_more( $more ) {
    return '[...]<a class="read-more" href="'. get_permalink( get_the_ID() ) . '">' . __('Read more', 'your-text-domain') . '</a>';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );