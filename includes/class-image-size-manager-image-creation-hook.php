<?php
/**
 * Class Image_Size_Manager_Image_Creation_Hook
 */
class Image_Size_Manager_Image_Creation_Hook {

	static function modify_image_sizes() {

		/**
		 * Change Image Sizes that will be generated
		 */

		add_filter( 'intermediate_image_sizes_advanced', array( new Self(), 'change_image_sizes_to_generate' ) );
	}

	function change_image_sizes_to_generate( $sizes ) {

		/**
		 * @todo Make sure this works correctly if there is no option in the DB.
		 * 'get_option' will unserialize the array
		 */

		$ism_user_id = get_current_user_id();
		$ism_option_string = 'image-size-manager-removed-sizes_' . $ism_user_id;

		/**
		 * @todo verify what happens when the option is empty
		 */
		if ( $option_array = get_option( $ism_option_string ) ) {

			// DEBUG START
			//require plugin_dir_path( __FILE__ ) . '../debug/class-debug-print-to-file.php';
			//new Debug_Print_To_File( $option_array );
			// DEBUG END

			$sizes_new = array();

			foreach ( $sizes as $size => $array ) {

				if ( ! in_array( $size, $option_array ) ) {

					$sizes_new[ $size ] = $array;
				}
			}

			return $sizes_new;

		} else {

			return $sizes;
		}

	}


}
