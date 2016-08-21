<?php
/**
 *  AJAX PHP Function
 * @todo make this a class
 */
function image_size_manager_ajax() {

	if ( isset( $_POST['image_size_click_happened'] ) ) {

		$checked_boxes_array = $_POST['checked_boxes_array'];

		//$boxes_array = json_decode( $checked_boxes_array );

		$boxes_serialized = serialize( $checked_boxes_array );

		//update_option( 'image-size-manager-removed-sizes', 'ajax is working!!!!' );
		update_option( 'image-size-manager-removed-sizes', $boxes_serialized );


		/**
		 * Return data to AJAX Javascript
		 */
		die( 'returning ajax data from PHP - option updated with JS' );
		//die( $custom_field_result );
	}
}

/**
 *  Ajax Action Hooks - references name of JS action passed to formdata
 */
add_action( 'wp_ajax_ism_custom_ajax_hook', 'image_size_manager_ajax' );
