<?php

/**
 * Class Image_Size_Manager_Ajax
 *
 * @todo separate test file creation into separate class
 */
class Image_Size_Manager_Ajax {

	static function modify_image_sizes() {

		/**
		 * Change Image Sizes that will be generated
		 */

		add_filter( 'intermediate_image_sizes_advanced', array( __CLASS__, 'change_image_sizes_to_generate' ) );
	}

	function change_image_sizes_to_generate( $sizes ) {

		/**
		 * Debug Info
		 * this file is saved in 'wp-admin' in the theme
		 * @todo learn how to move this file into the plugin directory?
		 */
		$debug_file = fopen( "leon-debug.txt", "w" );

		if ( ! $debug_file ) {
			die();
		}

		file_put_contents( "leon-debug.txt", print_r( $sizes, true ) );

		$demo_text = "Filter is working Awesome - called from PLUGIN!!!!!... \n";

		fwrite( $debug_file, $demo_text );

		fclose( $debug_file );


		/**
		 * Define new sizes
		 * @todo trigger all of this with ajax - pass in array of sizes that need to be created...
		 */
		$sizes_new = array(
			'medium' => array(
				'width'  => 133,
				'height' => 133,
				'crop'   => 1
			)
		);

		return $sizes_new;

//	[medium] => Array
//	(
//		[width] => 300
//            [height] => 300
//            [crop] =>
//        )

	}


}
