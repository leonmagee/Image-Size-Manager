<?php

/**
 * @link              http://mageemedia.net
 * @since             1.0.0
 * @package           Image_Size_Manager
 *
 * @wordpress-plugin
 * Plugin Name:       Image Size Manager
 * Plugin URI:        http://mageemedia.net
 * Description:       Choose which images sizes are automatically generated as you upload an image. This plugin adds additional controls to the upload area.
 * Version:           1.0.0
 * Author:            Leon Magee
 * Author URI:        http://mageemedia.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       image-size-manager
 * Domain Path:       /languages
 */

// tester
//
//$ism_option_string = 'image-size-manager-removed-sizes_1';
//$option_serialized = get_option( $ism_option_string );
//
//foreach( $option_serialized as $item ) {
//	var_dump( $item );
//}
//var_dump( $option_serialized );
//
//die('so far...');

// end tester




/**
 * Abort if file is called directly
 */
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Get Current User ID - define constant for option name
 * This is done so more than one user can same images concurrently
 * @todo Think about design pattern for doing all this
 */

//$user_id = get_current_user_id();
//$option_string = 'image-size-manager-removed-sizes_' . $user_id;
//define( "IMAGE_SIZE_MANAGER_OPTION_NAME", $option_string );



add_action( 'init', 'image_size_manager_get_current_user_id' );

function image_size_manager_get_current_user_id() {

	$user_id = get_current_user_id();
	if ( $user_id ) {

		global $IMAGE_SIZE_MANAGER_OPTION_NAME;
		$IMAGE_SIZE_MANAGER_OPTION_NAME = 'image-size-manager-removed-sizes_' . $user_id;
		//define( "IMAGE_SIZE_MANAGER_OPTION_NAME", $option_string );
		//echo IMAGE_SIZE_MANAGER_OPTION_NAME;
	}
}



/**
 * Admin Template
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-image-size-manager.php';

Image_Size_Manager::plugin_activation_action();

/**
 * Enqueue Scripts and Styles
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-image-size-manager-scripts.php';

Image_Size_Manager_Scripts::scripts_styles_actions();

/**
 * Process modified image size creation
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-image-size-manager-image-creation-hook.php';

Image_Size_Manager_Image_Creation_Hook::modify_image_sizes();

/**
 * Require Custom AJAX
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-image-size-manager-ajax.php';

Image_Size_Manager_Ajax::image_size_manager_custom_ajax_hook();



