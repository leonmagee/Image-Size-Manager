<?php
/**
 * Class Image_Size_Manager_Get_Sizes
 */
class Image_Size_Manager_Get_Sizes {

	public $sizes_array;

	public function __construct() {

		global $_wp_additional_image_sizes;

		$sizes = array();

		foreach ( get_intermediate_image_sizes() as $image_size ) {

			if ( in_array( $image_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {

				$sizes[ $image_size ]['width']  = get_option( "{$image_size}_size_w" );
				$sizes[ $image_size ]['height'] = get_option( "{$image_size}_size_h" );
				$sizes[ $image_size ]['crop']   = (bool) get_option( "{$image_size}_crop" );

			} elseif ( isset( $_wp_additional_image_sizes[ $image_size ] ) ) {

				$sizes[ $image_size ] = array(
					'width'  => $_wp_additional_image_sizes[ $image_size ]['width'],
					'height' => $_wp_additional_image_sizes[ $image_size ]['height'],
					'crop'   => $_wp_additional_image_sizes[ $image_size ]['crop'],
				);
			}
		}

		$this->sizes_array = $sizes;
	}

	
}
