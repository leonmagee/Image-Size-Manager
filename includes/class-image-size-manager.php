<?php

/**
 * Class Image_Size_Manager
 * it might be easier to have these be objects instead of static classes, since it will
 * make dependency injection easier???
 */
class Image_Size_Manager {

	static function plugin_activation_action() {
		/**
		 * Modify Image Upload to add more options
		 *
		 * Actions: pre-upload-ui | pre-plupload-upload-ui
		 */
		add_action( 'pre-upload-ui', array( new Self(), 'add_upload_controls' ) );
	}

	function add_upload_controls() {

		/**
		 * Get image sizes
		 *
		 * I need to list all of the size dimensions as well - documentation here:
		 * https://codex.wordpress.org/Function_Reference/get_intermediate_image_sizes
		 */

		/**
		 * Get size information for all currently-registered image sizes.
		 *
		 * @global $_wp_additional_image_sizes
		 * @uses   get_intermediate_image_sizes()
		 * @return array $sizes Data for all currently-registered image sizes.
		 *
		 * @todo these should be methods of a class
		 */

		/**
		 * Get Image Size Data
		 */
		require plugin_dir_path( __FILE__ ) . 'class-image-size-manager-get-sizes.php';

		$images_sizes_object = new Image_Size_Manager_Get_Sizes();

		$image_sizes = $images_sizes_object->sizes_array;

		/**
		 * Modify
		 */
		function img_sz_nm( $name ) {

			$name_new = str_replace( array( '_', '-' ), ' ', $name );

			return __( ucfirst( $name_new ) );
		}

		/**
		 * When this page renders, update the option to remove previous contents
		 */
		update_option( 'image-size-manager-removed-sizes', '' );

		/**
		 * @todo - the markup for the form can move into a different class?
		 */
		?>

		<div class="image-size-manager-options-wrap">
			
			<?php $ism_user_id = get_current_user_id(); ?>
			
			<input type="hidden" id="ism-current-user-id" value="<?php echo $ism_user_id; ?>"/>
			
			<h2><?php _e( 'Image Sizes that will be generated' ); ?></h2>

			<p class="description-text"><?php _e( 'Deselect any images sizes you don\'t want to be generated.' ); ?>
				&nbsp;&nbsp;
				<a class="deselect-all-images"><?php _e( 'Generate No Image Sizes' ); ?></a> <i
					class="fa fa-refresh fa-spin deselect" aria-hidden="true"></i>
				<a class="select-all-images"><?php _e( 'Generate All Image Sizes' ); ?></a> <i
					class="fa fa-refresh fa-spin select" aria-hidden="true"></i>
			</p>
			<p class="description-text"><?php _e( 'Additional images sizes are only generated if the original image size exceeds the dimensions of the other image sizes.' ); ?></p>

			<?php

			$counter = 0;

			foreach ( $image_sizes as $image_size => $dimensions ) { ?>

				<div class="one-checkbox" id="<?php echo $image_size; ?>">

					<div class="icon-wrap">

						<i class="fa fa-check-square-o" aria-hidden="true"></i>

					</div>

					<input type="hidden" class="size-count" value="<?php echo $counter; ?>"/>

					<?php ++ $counter;

					/**
					 * @todo what about crop?
					 */
					$width_label  = $dimensions['width'] ? $dimensions['width'] . ' w' : 'auto';
					$height_label = $dimensions['height'] ? $dimensions['height'] . ' h' : 'auto';
					$crop_label    = $dimensions['crop'] ? 'Crop' : 'No Crop';

					if ( $dimensions['width'] == 0 ) {

						/**
						 * @todo what am I doing here?
						 */
					} ?>

					<label for="upload_<?php echo $counter; ?>"><?php echo img_sz_nm( $image_size ); ?>
						- <?php echo $width_label; ?> x <?php echo $height_label; ?> - <?php echo $crop_label; ?></label>

				</div>

			<?php } ?>

		</div>

	<?php }
}
