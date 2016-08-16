<?php

/**
 * @link              http://mageemedia.net
 * @since             1.0.0
 * @package           Image_Size_Manager
 *
 * @wordpress-plugin
 * Plugin Name:       Image Size Manager
 * Plugin URI:        http://mageemedia.net
 * Description:       Choose which images sizes are automatically generated as you upload an image. This plugin adds additional controls to the upload area.
 * Version:           1.0.0
 * Author:            Leon Magee
 * Author URI:        http://mageemedia.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       image-size-manager
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-image-size-manager.php';


/**
 * Enqueue Scripts and Styles
 */
function plugin_styles_and_scripts() {

	$plugin_dir = plugin_dir_url(__FILE__);

	// plugin admin css
	wp_enqueue_style( 'upload-image-css', $plugin_dir . 'admin/css/image-size-manager-admin.css' );

	// plugin admin js
	wp_enqueue_script( 'upload-image-js', $plugin_dir . 'admin/js/image-size-manager-admin.js' );
}

add_action( 'admin_enqueue_scripts', 'plugin_styles_and_scripts' );


/**
 * Modify Image Upload to add more options
 *
 * Actions: pre-upload-ui | pre-plupload-upload-ui
 */

add_action( 'pre-upload-ui', 'add_upload_controls' );

function add_upload_controls() {

	/**
	 * This button should display and hide the thumbnail options
	 * By default, if this is not used, it should generate all thumbnails.
	 */
	echo "<a class='button'>Specify Image Sizes</a>";

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
		 */
		foreach ( get_intermediate_image_sizes() as $_size ) {
			if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
				$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
				$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
				$sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
			} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
				$sizes[ $_size ] = array(
					'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
					'height' => $_wp_additional_image_sizes[ $_size ]['height'],
					'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
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

		return ucfirst( $name_new );
	}

	?>

	<div class="image-size-options-wrap">

		<h2>Choose Image Sizes to Generate</h2>

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

