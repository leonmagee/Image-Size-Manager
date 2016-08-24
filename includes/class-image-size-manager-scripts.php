<?php

/**
 * Class Image_Size_Manager_Scripts
 *
 * Load all admin scripts and styles
 *
 * @todo only load these on the media upload page
 */
class Image_Size_Manager_Scripts {

	static function scripts_styles_actions() {

		add_action( 'admin_enqueue_scripts', array( new Self(), 'enqueue_scripts_styles' ) );
	}

	function enqueue_scripts_styles( $page_slug ) {

		if ( $page_slug == 'media-new.php' ) {

			$plugin_dir = plugin_dir_url( __FILE__ );

			// plugin admin css
			wp_enqueue_style(
				'image-size-manager-css',
				$plugin_dir . '../admin/css/image-size-manager-admin.css',
				'',
				'1.0.1'
			);

			// font awesome css
			wp_enqueue_style(
				'font-awesome-cdn',
				'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css'
			);

			// plugin admin js
			wp_enqueue_script(
				'image-size-manager-js',
				$plugin_dir . '../admin/js/image-size-manager-admin.js',
				array( 'jquery' ),
				'1.0.1'
			);
		}
	}


}
