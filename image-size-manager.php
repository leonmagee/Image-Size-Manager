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

/**
 * Abort if file is called directly
 */
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Activate Plugin
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
require plugin_dir_path(__FILE__) . 'includes/class-image-size-manager-ajax.php';

