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

		/**
		 * @todo - the markup for the form can move into a different class?
		 */
		?>

		<div class="image-size-manager-options-wrap">

			<h2><?php _e( 'Image Sizes that will be generated' ); ?></h2>

			<p class="description-text"><?php _e( 'Deselect any images sizes you don\'t want to be generated.' ); ?>
				<a class="deselect-all-images"><?php _e( 'Generate No Image Sizes' ); ?></a>
				&nbsp-&nbsp
				<a class="select-all-images"><?php _e( 'Generate All Image Sizes' ); ?></a>
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

					$width_label  = $dimensions['width'] ? $dimensions['width'] . ' w' : 'auto';
					$height_label = $dimensions['height'] ? $dimensions['height'] . ' h' : 'auto';

					if ( $dimensions['width'] == 0 ) {

					} ?>

					<label for="upload_<?php echo $counter; ?>"><?php echo img_sz_nm( $image_size ); ?>
						- <?php echo $width_label; ?> x <?php echo $height_label; ?></label>

				</div>

			<?php } ?>

		</div>

	<?php }
}
