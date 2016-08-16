<?php

/**
 * Class Image_Size_Manager
 */
class Image_Size_Manager {

	static function plugin_activation_action() {
		/**
		 * Modify Image Upload to add more options
		 *
		 * Actions: pre-upload-ui | pre-plupload-upload-ui
		 */
		add_action( 'pre-upload-ui', array( __CLASS__, 'add_upload_controls' ) );
	}

	function add_upload_controls() {

		/**
		 * This button should display and hide the thumbnail options
		 * By default, if this is not used, it should generate all thumbnails.
		 */
		echo "<a class='button'>" . __( 'Specify Image Sizes' ) . "</a>";

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
		 */
		function get_image_sizes() {
			global $_wp_additional_image_sizes;

			$sizes = array();

			/**
			 * 'Regular' sizes are different since the dimensions are stored in options - you can change them
			 *  in Settings -> Media
			 * @todo this function was taken from online, I should rework this with my own variable names so it's easier for me to read.
			 */
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

			return $sizes;
		}

		$image_sizes = get_image_sizes();

		/**
		 * Modify
		 */
		function img_sz_nm( $name ) {

			$name_new = str_replace( array( '_', '-' ), ' ', $name );

			return __( ucfirst( $name_new ) );
		}

		?>

		<div class="image-size-options-wrap">

			<h2><?php _e( 'Choose Image Sizes to Generate' ); ?></h2>

			<?php

			$counter = 0;

			foreach ( $image_sizes as $image_size => $dimensions ) { ?>

				<div class="one-checkbox">

					<input type="hidden" class="size-count" value="<?php echo $counter; ?>"/>

					<?php ++ $counter; ?>

					<input type="checkbox" id="upload_<?php echo $counter; ?>" name="<?php echo $image_size; ?>"/>

					<label for="upload_<?php echo $counter; ?>"><?php echo img_sz_nm( $image_size ); ?>
						- <?php echo $dimensions['width']; ?> x <?php echo $dimensions['height']; ?></label>

				</div>

			<?php } ?>

		</div>

	<?php }


}
