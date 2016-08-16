<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://mageemedia.net
 * @since             1.0.0
 * @package           Image_Size_Manager
 *
 * @wordpress-plugin
 * Plugin Name:       Image Size Manager
 * Plugin URI:        http://mageemedia.net
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Leon Magee
 * Author URI:        http://mageemedia.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       image-size-manager
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-image-size-manager-activator.php
 */
function activate_image_size_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-image-size-manager-activator.php';
	Image_Size_Manager_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-image-size-manager-deactivator.php
 */
function deactivate_image_size_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-image-size-manager-deactivator.php';
	Image_Size_Manager_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_image_size_manager' );
register_deactivation_hook( __FILE__, 'deactivate_image_size_manager' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-image-size-manager.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_image_size_manager() {

	$plugin = new Image_Size_Manager();
	$plugin->run();

}
run_image_size_manager();
