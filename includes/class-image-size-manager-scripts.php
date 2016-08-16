<?php

/**
 * Class Image_Size_Manager_Scripts
 *
 * Load all admin scripts and styles
 */
class Image_Size_Manager_Scripts {

	function __construct() {

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts_styles' ) );
	}

	function enqueue_scripts_styles() {

		$plugin_dir = plugin_dir_url(__FILE__);

		// plugin admin css
		wp_enqueue_style( 'upload-image-css', $plugin_dir . '../admin/css/image-size-manager-admin.css' );

		// plugin admin js
		wp_enqueue_script( 'upload-image-js', $plugin_dir . '../admin/js/image-size-manager-admin.js' );
	}



}
