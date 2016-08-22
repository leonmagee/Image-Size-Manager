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
		 */
		if ( $option_serialized = get_option( 'image-size-manager-removed-sizes' ) ) {

			$option = unserialize( $option_serialized );

			$option_explode = explode( ',', $option );

			$option_array = array_filter( $option_explode );

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
