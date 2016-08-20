<?php
/**
 *  AJAX PHP Function
 * @todo make this a class
 */
function image_size_manager_ajax() {

	if ( isset( $_POST['image_size_click_happened'] ) ) {

		$checked_boxes_array = $_POST['checked_boxes_array'];

		update_option( 'image-size-manager-removed-sizes', 'ajax is working!!!!' );


		/**
		 * Return data to AJAX Javascript
		 */
		die( 'workzzz so farzzz' );
		//die( $custom_field_result );
	}
}

/**
 *  Ajax Action Hooks - references name of JS action passed to formdata
 */
add_action( 'wp_ajax_ism_custom_ajax_hook', 'image_size_manager_ajax' );
