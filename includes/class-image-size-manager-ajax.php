<?php

/**
 * Class Image_Size_Manager_Ajax
 */
class Image_Size_Manager_Ajax {

	static function image_size_manager_custom_ajax_hook() {

		add_action( 'wp_ajax_ism_custom_ajax_hook', array( new Self(), 'image_size_manager_ajax' ) );
	}

	public function image_size_manager_ajax() {

		if ( isset( $_POST['image_size_click_happened'] ) ) {

			$checked_boxes_array = $_POST['checked_boxes_array'];

			$boxes_serialized = serialize( $checked_boxes_array );

			update_option( 'image-size-manager-removed-sizes', $boxes_serialized );

			die( 'returning ajax data from PHP - option updated with JS' );

		} elseif ( isset( $_POST['image_size_deselect_all'])) {

			/**
			 * @todo loop through all image sizes and then add a serialized array of hte values to the database
			 */

			/**
			 * Get Image Size Data
			 */
			require plugin_dir_path( __FILE__ ) . 'class-image-size-manager-get-sizes.php';

			$images_sizes_object = new Image_Size_Manager_Get_Sizes();

			$image_sizes = $images_sizes_object->sizes_array;

			/**
			 * Serialize image size data to add to database
			 */
			$image_size_array = serialize( $image_sizes );

			/**
			 * Update Option
			 */
			update_option( 'image-size-manager-removed-sizes', $image_size_array );


			// DEBUG START
			require plugin_dir_path( __FILE__ ) . 'class-debug-print-to-file.php';
			new Debug_Print_To_File();
			// DEBUG END

			die( 'all deselected' );

		} elseif ( isset( $_POST['image_size_select_all'])) {

			update_option( 'image-size-manager-removed-sizes', '' );

			die( 'all selected' );
		}
	}


}

