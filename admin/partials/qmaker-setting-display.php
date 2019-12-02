<?php
/**
 * Create A Simple Theme Options Panel
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'QMaker_Options' ) ) {

	class QMaker_Options {
		/**
		 * Start things up
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			// We only need to register the admin panel on the back-end
			if ( is_admin() ) {
				add_action( 'admin_init', array( 'QMaker_Options', 'qmaker_register_settings' ) );
			}
		}

		/**
		 * Returns all theme options
		 *
		 * @since 1.0.0
		 */
		public static function get_options() {
			return get_option( 'qmaker_options' );
		}

		/**
		 * Returns single theme option
		 *
		 * @since 1.0.0
		 */
		public static function get_option( $id ) {
			$options = self::get_options();
			if ( isset( $options[$id] ) ) {
				return $options[$id];
			}
			
			return false;
		}

		/**
		 * Register a setting and its sanitization callback.
		 *
		 * We are only registering 1 setting so we can store all options in a single option as
		 * an array. You could, however, register a new setting for each option
		 *
		 * @since 1.0.0
		 */
		public static function qmaker_register_settings() {
			register_setting( 'qmaker_options', 'qmaker_options', array( 'QMaker_Options', 'sanitize' ) );
		}

		/**
		 * Sanitization callback
		 *
		 * @since 1.0.0
		 */
		public static function sanitize( $options ) {
			// If we have options lets sanitize them
			if ( $options ) {

				// Input
                if ( ! empty( $options['quiz_banner_link'] ) ) {
                    $options['quiz_banner_link'] = sanitize_text_field( $options['quiz_banner_link'] );
                } else {
                    unset( $options['quiz_banner_link'] ); 
                }

                // Input
                if ( ! empty( $options['quiz_banner_image'] ) ) {
                    $options['quiz_banner_image'] = sanitize_text_field( $options['quiz_banner_image'] );
                } else {
                    unset( $options['quiz_banner_image'] ); 
                }

			}
			// Return sanitized options
			return $options;
		}

		/**
		 * Settings page output
		 *
		 * @since 1.0.0
		 */
		public static function display_page_options() 
		{
			wp_enqueue_media();
		?>
            <style>
            .ctrl_qmaker_setting{
                width:80%;
			}
			.ctrl_qmaker_subsetting{
				width:40%;
			}
			.qmaker_setting_subtitle{
				padding:15px 10px 0px 0 !important;
			}
			.ctrl_qmaker_subsetting_min{
				width:18%;
			}
			.subsection-setting{
				margin-top:5px;
			}

			#image-preview{
				display: block;
				max-height: 120px;
			}

            </style>
			<div class="wrap">
				<h1><?php esc_html_e( 'Configuración QMaker','qmaker_settings' ); ?></h1>
				<form method="post" action="options.php">
					<?php settings_fields( 'qmaker_options' ); ?>
					<table class="form-table wpex-custom-admin-login-table">
						<!-- Quiz Banner -->
                        <tr valign="top">
                            <th class="qmaker_setting_subtitle" scope="row"><h5><?php esc_html_e( 'Banner del Quiz','qmaker_settings' ); ?></h5></th>
                            <td></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php esc_html_e( 'Hipervinculo del banner', 'qmaker_settings'); ?></th>
                            <td>
                                <?php $value = self::get_option( 'quiz_banner_link' ); ?>
                                <input type="url" class="ctrl_qmaker_setting" name="qmaker_options[quiz_banner_link]" value="<?php echo esc_attr( $value ); ?>">
                                <br />
                                <span class="description"><?php esc_html_e( 'Hipervinculo del banner que aparece en el Quiz', 'qmaker_settings'); ?></span>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row"><?php esc_html_e( 'Imagen del banner', 'qmaker_settings'); ?></th>
                            <td>
								<?php $value = self::get_option( 'quiz_banner_image' ); ?>
								
								<?php if( $value ): ?>
									<img id='image-preview' src='<?php echo wp_get_attachment_url( $value ); ?>'>
								<?php endif ?>

								<br>
								<input id="upload_image_button" type="button" class="button" value="Subir imagen" />
								<br>
								<span class="description"><?php esc_html_e( 'Tamaño ideal de la imagen: 1540px de ancho por 427px de altura ', 'qmaker_settings'); ?></span>
								<input type='hidden' class="ctrl_qmaker_setting" name='qmaker_options[quiz_banner_image]' id='image_attachment_id' value='<?php echo $value ?>'>
                            </td>
                        </tr>
					</table>
					<?php submit_button(); ?>
				</form>
			</div><!-- .wrap -->

			<script type='text/javascript'>
				jQuery( document ).ready( function( $ ) {
					// Uploading files
					var file_frame;

					jQuery('#upload_image_button').on('click', function( event ){
						event.preventDefault();
						// Create the media frame.
						file_frame = wp.media.frames.file_frame = wp.media({
							title: 'Select a image to upload',
							button: {
								text: 'Use this image',
							},
							multiple: false	// Set to true to allow multiple files to be selected
						});
						// When an image is selected, run a callback.
						file_frame.on( 'select', function() {
							// We set multiple to false so only get one image from the uploader
							attachment = file_frame.state().get('selection').first().toJSON();
							// Do something with attachment.id and/or attachment.url here
							$( '#image-preview' ).attr( 'src', attachment.url ).css( 'width', 'auto' );
							$( '#image_attachment_id' ).val( attachment.id );

						});
							// Finally, open the modal
						file_frame.open();
					});
				});
			</script>
		<?php }
	}
}

// Helper function to use in your theme to return a theme option value
function qmaker_get_option( $id = '' ) {
	return QMaker_Options::get_option( $id );
}