<?php

/**
 * Class Image_Size_Manager_Get_Size_Names
 */
class Image_Size_Manager_Get_Size_Names {

	public $size_names;
	
	public function __construct() {
		var_dump( 'class working' );

		// get regular sizes
		$regular_sizes_array = get_intermediate_image_sizes();

		// get additional sizes
		global $_wp_additional_image_sizes;
		$additional_sizes = array();

		foreach ( $_wp_additional_image_sizes as $key => $size_details ) {

			$additional_sizes[] = $key;
		}

		$size_names_array = array_merge( $regular_sizes_array, $additional_sizes );

		return $size_names_array;
	}
}
