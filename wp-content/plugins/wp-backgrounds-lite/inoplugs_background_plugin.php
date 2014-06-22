<?php
/**
 *  Plugin Name: WP-Backgrounds Lite
 *  Plugin URI: http://inoplugs.com
 *  Description: Set clickable fullsize background images for Posts/Pages | Get the Premium version here: <a href="http://inoplugs.com/wpbackgroundsII">WP-Backgrounds II</a>
 *  Author: InoPlugs
 *  Version: 2.2.6
 *  Author URI: http://inoplugs.com
 */

	define( 'INO_WPBLITE_URLPATH', WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__ ),'',plugin_basename(__FILE__)) );
	define( 'INO_WPBLITE_TEXTDOMAIN', 'inowpblite' );
	define( 'INO_WPBLITE_OPTIONNAME', 'inoplugs_bglite_options' );

	load_plugin_textdomain( INO_WPBLITE_TEXTDOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	require_once('inoplugs_classes/inoplugs_background_display.php');



	global $ino_bglite_options;
	$ino_bglite_options = array();
	$ino_bglite_options = get_option(INO_WPBLITE_OPTIONNAME);

	//set falback settings
	$ino_bglite_options['zindex'] = empty($ino_bglite_options['zindex']) ? "-1" : $ino_bglite_options['zindex'];
	$ino_bglite_options['bg_color'] = empty($ino_bglite_options['bg_color']) ? "" : $ino_bglite_options['bg_color'];
	$ino_bglite_options['zindexcontainer'] = empty($ino_bglite_options['zindexcontainer']) ? "5" : $ino_bglite_options['zindexcontainer'];
	$ino_bglite_options['positioncontainer'] = empty($ino_bglite_options['positioncontainer']) ? "relative" : $ino_bglite_options['positioncontainer'];
	$ino_bglite_options['containerid'] = empty($ino_bglite_options['containerid']) ? "" : $ino_bglite_options['containerid'];

	//	create objects for handlers
	$inoplugs_wp_backgrounds_display = new inoplugs_background_display();

    # Add the options/actions to WordPress
	add_action('init', array (&$inoplugs_wp_backgrounds_display, 'handler_frontend_includes'));
	add_action('wp_head', array (&$inoplugs_wp_backgrounds_display, 'handler_add_background_slideshow'));

	if (function_exists('register_uninstall_hook')){
		register_uninstall_hook(__FILE__, 'deinstall_inoplugs_wp_backgrounds');
	}

	function deinstall_inoplugs_wp_backgrounds() {
		delete_option('inoplugs_bg_options');

		$allposts = get_posts('numberposts=-1&post_type=post&post_status=any');

		foreach( $allposts as $postinfo) {
			delete_post_meta($postinfo->ID, 'ino_upload_image');
			delete_post_meta($postinfo->ID, 'ino_deactivate');
		}
	}

	//metabox
			$ino_meta_box = array(
                            $meta_box_post = array(
											'id' => 'ino-meta-box_post',
											'title' => __('InoPlugs WP-Background Image',INO_WPBLITE_TEXTDOMAIN),
											'page' => 'post',
											'context' => 'normal',
											'priority' => 'high',
											'fields' => array(
												array(
													'name' => __('Background Image',INO_WPBLITE_TEXTDOMAIN),
													'desc' => __('Select an Image (internal or external url)',INO_WPBLITE_TEXTDOMAIN),
													'id' => 'upload_image',
													'type' => 'text',
													'std' => ''
												),

												array(
													'name' => '',
													'desc' => __('Upload Image',INO_WPBLITE_TEXTDOMAIN),
													'id' => 'upload_image_button',
													'type' => 'button',
													'std' => __('Select Background Image',INO_WPBLITE_TEXTDOMAIN)
												),

												array(
													'name' => '',
													'desc' => __('Apply Link to Background - enter the url. It must start with http://',INO_WPBLITE_TEXTDOMAIN),
													'id' => 'image_url',
													'type' => 'text',
													'std' => ''
												)
										)
                            ),

                         $meta_box_page = array(
											'id' => 'ino-meta-box_page',
											'title' => __('InoPlugs WP-Background Image',INO_WPBLITE_TEXTDOMAIN),
											'page' => 'page',
											'context' => 'normal',
											'priority' => 'high',
											'fields' => array(
												array(
													'name' => __('Background Image',INO_WPBLITE_TEXTDOMAIN),
													'desc' => __('Select a Image (internal or external url)',INO_WPBLITE_TEXTDOMAIN),
													'id' => 'upload_image',
													'type' => 'text',
													'std' => ''
												),
														array(
													'name' => '',
													'desc' => __('Upload Image',INO_WPBLITE_TEXTDOMAIN),
													'id' => 'upload_image_button',
													'type' => 'button',
													'std' => __('Select Background Image',INO_WPBLITE_TEXTDOMAIN)
													),

													array(
													'name' => '',
													'desc' => __('Apply Link to Background - enter the url here. It must start with http://',INO_WPBLITE_TEXTDOMAIN),
													'id' => 'image_url',
													'type' => 'text',
													'std' => ''
													)
												)
										)
							);


			add_action('admin_menu', 'ino_add_box');

			// Add meta box
			function ino_add_box() {
                            global $ino_meta_box;
                            foreach($ino_meta_box as $box){
				add_meta_box($box['id'], $box['title'], 'ino_show_box', $box['page'], $box['context'], $box['priority']);
                            }
                        }


			// Callback function to show fields in meta box
			function ino_show_box() {
				global $ino_meta_box, $post;

				// Use nonce for verification
				echo '<input type="hidden" name="ino_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

				echo '<table class="form-table">';

				foreach ($ino_meta_box[0]['fields'] as $field) {
					// get current post meta data
					$meta = get_post_meta($post->ID, $field['id'], true);

					echo '<tr>',
							'<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
							'<td>';
					switch ($field['type']) {




			//If Text
						case 'text':
							echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />',
								'<br />', $field['desc'];
							break;


			//If Button

							case 'button':
							echo '<input type="button" name="', $field['id'], '" id="', $field['id'], '"value="', $meta ? $meta : $field['std'], '" />';
							break;
					}
					echo 	'<td>',
						'</tr>';
				}

				echo '</table>';
			}

			add_action('save_post', 'ino_save_data');


			// Save data from meta box
			function ino_save_data($post_id) {
				global $ino_meta_box;

				// verify nonce
				if (isset($_POST['ino_meta_box_nonce']) && !wp_verify_nonce($_POST['ino_meta_box_nonce'], basename(__FILE__))) {
					return $post_id;
				}

				// check autosave
				if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
					return $post_id;
				}

				// check permissions
				if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
					if (!current_user_can('edit_page', $post_id)) {
						return $post_id;
					}
				} elseif (!current_user_can('edit_post', $post_id)) {
					return $post_id;
				}

				foreach ($ino_meta_box[0]['fields'] as $field) {
					$old = get_post_meta($post_id, $field['id'], true);
                    if(isset($_POST[$field['id']])){
					    $new = $_POST[$field['id']];
                    }else{
                        $new = '';
                    }

					if ($new && $new != $old) {
						update_post_meta($post_id, $field['id'], $new);
					} elseif ('' == $new && $old) {
						delete_post_meta($post_id, $field['id'], $old);
					}
				}
			}

			function ino_admin_scripts() {
				wp_enqueue_script('media-upload');
				wp_enqueue_script('thickbox');
				wp_register_script('my-upload', INO_WPBLITE_URLPATH.'includes/script.js', array('jquery','media-upload','thickbox'));
				wp_enqueue_script('my-upload');
			}

			function ino_admin_styles() {
				wp_enqueue_style('thickbox');
			}

			add_action('admin_print_scripts', 'ino_admin_scripts');
			add_action('admin_print_styles', 'ino_admin_styles');


    # Register an administration page

	add_action('admin_menu', 'inowpblite_addAdminPage');

    function inowpblite_addAdminPage() {
        add_options_page(__('WP-Backgrounds Lite',INO_WPBLITE_TEXTDOMAIN), 'WP-Backgrounds Lite', 'manage_options', 'WP-Backgrounds', 'inowpblite_adminmenu');
    }

    # Generates the administration menu


	add_action('wp_ajax_inoptions_inowpblite_ajax_save','inoplugs_inowpblite_save_ajax');

	function inoplugs_inowpblite_save_ajax() {

		check_ajax_referer('test-inooptions_inowpblite', 'security');

		$data = $_POST[INO_WPBLITE_OPTIONNAME];
		unset($data['security'], $data['action']);

		if(update_option(INO_WPBLITE_OPTIONNAME, $data))
		{
			die('1');
		} else {
			die('0');
		}
	}

    function inowpblite_adminmenu() {
	?>
	<div class="wrap">
		<div id="message"></div>

		<script type="text/javascript">
		jQuery(document).ready(function($) {

		  jQuery('form#ino_inowpblite_option_form').submit(function() {
			  var data = jQuery(this).serialize();
			  jQuery.post(ajaxurl, data, function(response) {
				  if(response == 1) {
					  show_message(1);
					  t = setTimeout('fade_message()', 2000);
				  } else {
					  show_message(2);
					  t = setTimeout('fade_message()', 2000);
				  }
			  });
			  return false;
		  });

		});

		function show_message(n) {
			if(n == 1) {
				jQuery('#message').html('<div id="notice" class="updated fade"><p><strong><?php _e('Backgrounds Lite options saved.',INO_WPBLITE_TEXTDOMAIN); ?></strong></p></div>').show();
			} else {
				jQuery('#message').html('<div id="notice" class="updated fade"><p><strong><?php _e('Backgrounds Lite options saved.',INO_WPBLITE_TEXTDOMAIN); ?></strong></p></div>').show();
			}
		}

		function fade_message() {
			jQuery('#message').fadeOut(1000);
			clearTimeout(t);
		}
		</script>

		<div class="logo"><a href="http://inoplugs.com"><img style="float:left;" src="<?php $ino_urlpath = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),'',plugin_basename(__FILE__)); echo $ino_urlpath; ?>images/logo.png" height="100" alt="logo" /></a>
			<h2 style="float:left; margin-top: 64px;"><?php _e('Backgrounds Lite Option Page',INO_WPBLITE_TEXTDOMAIN); ?></h2>
			<h2 style="float:left;background: #E2E2E2; border-radius: 5px; padding: 10px;"> <?php _e('Backgrounds Lite is the free version of <a href="http://inoplugs.com/wpbackgroundsII">WP-Backgrounds II</a>. WP-Backgrounds II comes with a lot more features - among them html5 video, youtube, image and kenburns slider backgrounds, a custom login panel and support for custom post types, categories, terms/taxonomies and standard wordpress pages (archive pages, home page, 404 page, search page, etc.). Each author can set/use an individual background.',INO_WPBLITE_TEXTDOMAIN); ?></h2>
		</div>
		<div style="clear: both;"></div>

		<form method="post" action="options.php" name="ino_inowpblite_option_form" id="ino_inowpblite_option_form">
		<?php global $ino_bglite_options; wp_nonce_field('update-options'); ?>

			<div id="ino-options-cont">

				<div id="ino-zindex" class="tab-option">
					<h3 class="option-title"><strong><?php _e('Z-index value of background layer',INO_WPBLITE_TEXTDOMAIN); ?></strong></h3>
					<div class="option-content">
						<label for="zindex">
							<input type="text" name="<?php echo INO_WPBLITE_OPTIONNAME; ?>[zindex]" value="<?php if( !empty($ino_bglite_options['zindex']) ) { echo $ino_bglite_options['zindex']; }else{ echo "-1"; } ?>" /><br />
							<?php _e('Enter the z-index value of the background layer (0 by default).',INO_WPBLITE_TEXTDOMAIN); ?>
						</label><br />

						<div class="clear"></div>
					</div>
				</div>


				<div id="ino-containerid" class="tab-option">
					<h3 class="option-title"><strong><?php _e('ID or class of the content container/wrapper',INO_WPBLITE_TEXTDOMAIN); ?></strong></h3>
					<div class="option-content">

					<label for="containerid">
						<input type="text" name="<?php echo INO_WPBLITE_OPTIONNAME; ?>[containerid]" value="<?php if( !empty($ino_bglite_options['containerid']) ) { echo $ino_bglite_options['containerid']; }else{ echo ""; } ?>" /><br/>
						<br /><?php _e('Enter the ID or class of the content container/wrapper. Eg the default WP Theme TwentyEleven uses the \'#page\' element as content container.',INO_WPBLITE_TEXTDOMAIN); ?>
					</label>

						<div class="clear"></div>
					</div>
				</div>


				<div id="ino-zindexcontainer" class="tab-option">
					<h3 class="option-title"><strong><?php _e('Z-index value of content layer',INO_WPBLITE_TEXTDOMAIN); ?></strong></h3>
					<div class="option-content">

					<label for="zindexcontainer">
						<input type="text" name="<?php echo INO_WPBLITE_OPTIONNAME; ?>[zindexcontainer]" value="<?php if( !empty($ino_bglite_options['zindexcontainer']) ) { echo $ino_bglite_options['zindexcontainer']; }else{ echo "5"; } ?>" />
						<br /><?php _e('Enter the z-index value of the background layer (5 by default).',INO_WPBLITE_TEXTDOMAIN); ?>
					</label>

						<div class="clear"></div>
					</div>
				</div>

				<div id="ino-positioncontainer" class="tab-option">
					<h3 class="option-title"><strong><?php _e('Position of the content container/wrapper',INO_WPBLITE_TEXTDOMAIN); ?></strong></h3>
					<div class="option-content">

					<label for="positioncontainer">
						<input type="text" name="<?php echo INO_WPBLITE_OPTIONNAME; ?>[positioncontainer]" value="<?php if( !empty($ino_bglite_options['positioncontainer']) ) { echo $ino_bglite_options['positioncontainer']; }else{ echo "relative"; } ?>" />
						<br /><?php _e('Enter the position of the content container/wrapper. Default value is \'relative\'. Only change it if you know what you\'re doing.',INO_WPBLITE_TEXTDOMAIN); ?>
					</label>

						<div class="clear"></div>
					</div>
				</div>

				<div id="ino-bg_color" class="tab-option">
					<h3 class="option-title"><strong><?php _e('Body background color',INO_WPBLITE_TEXTDOMAIN); ?></strong></h3>
					<div class="option-content">

					<label for="bg_color">
						<input type="text" name="<?php echo INO_WPBLITE_OPTIONNAME; ?>[bg_color]" value="<?php if( !empty($ino_bglite_options['bg_color']) ) { echo $ino_bglite_options['bg_color']; }else{ echo ""; } ?>" />
						<br /><?php _e('This option helps you to adjust the default body background color. Leave the field empty to deactivate this option.',INO_WPBLITE_TEXTDOMAIN); ?>
					</label>

						<div class="clear"></div>
					</div>
				</div>

		</div>
			<p class="submit">

				<input type="hidden" name="action" value="inoptions_inowpblite_ajax_save" />
				<input type="hidden" name="security" value="<?php echo wp_create_nonce('test-inooptions_inowpblite'); ?>" />
				<input type="submit" class="button-primary" value="<?php _e('Save Changes',INO_WPBLITE_TEXTDOMAIN) ?>" />
			</p>
		</form>
	</div>

	<?php
}