<?php

/**
 * Class Image_Size_Manager_Ajax
 */
class Image_Size_Manager_Ajax {

	public function ism_array_from_data( $data_string ) {

		// create array of image sizes
		$option_explode = explode( ',', $data_string );

		// remove empty elements from array
		return array_filter( $option_explode );
	}


	static function image_size_manager_custom_ajax_hook() {

		add_action( 'wp_ajax_ism_custom_ajax_hook', array( new Self(), 'image_size_manager_ajax' ) );
	}

	public function image_size_manager_ajax() {

		if ( isset( $_POST['ism_user_id'] ) ) {

			$ism_user_id = $_POST['ism_user_id'];

			$ism_option_string = 'image-size-manager-removed-sizes_' . $ism_user_id;

			if ( isset( $_POST['image_size_click_happened'] ) ) {

				$checked_boxes_array = $_POST['checked_boxes_array'];

				$data_array = self::ism_array_from_data( $checked_boxes_array );

				// DEBUG START
				require plugin_dir_path( __FILE__ ) . '../debug/class-debug-print-to-file.php';
				new Debug_Print_To_File( $data_array );
				// DEBUG END

				update_option( $ism_option_string, $data_array );
				//update_option( 'image-size-manager-removed-sizes', $boxes_serialized );

				die( 'returning ajax data from PHP - option updated with JS' );

			} elseif ( isset( $_POST['image_size_deselect_all'] ) ) {

				/**
				 * Get Image Size Data
				 */
				require plugin_dir_path( __FILE__ ) . 'class-image-size-manager-get-size-names.php';

				$image_sizes_array = Image_Size_Manager_Get_Size_Names::get_sizes();

				/**
				 * Update Option
				 */
				update_option( $ism_option_string, $image_sizes_array );


				// DEBUG START
				require plugin_dir_path( __FILE__ ) . '../debug/class-debug-print-to-file.php';
				new Debug_Print_To_File();
				// DEBUG END

				die( 'all deselected' );

			} elseif ( isset( $_POST['image_size_select_all'] ) ) {

				update_option( $ism_option_string, '' );

				die( 'all selected' );
			}
		}

	}


}

