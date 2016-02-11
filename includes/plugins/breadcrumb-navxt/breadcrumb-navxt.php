<?php
/**
 * Plugin integration
 *
 * Breadcrumb NavXT
 *
 * @link  https://wordpress.org/plugins/breadcrumb-navxt/
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 *
 * Contents:
 *
 *  1) Requirements check
 * 10) Plugin integration
 */





/**
 * 1) Requirements check
 */

	if ( ! function_exists( 'bcn_display' ) ) {
		return;
	}





/**
 * 10) Plugin integration
 */

	/**
	 * Plugin setup admin page modification
	 *
	 * Don't display breadcrumbs settings for posts with no single view.
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  boolean $display
	 * @param  string  $post_type
	 */
	function firefly_bcn_admin( $display = true, $post_type = '' ) {

		// Helper variables

			$redirects = apply_filters( 'wmhook_firefly_custom_post_redirects', array(
					'wm_logos'        => home_url(),
					'wm_modules'      => home_url(),
					'wm_staff'        => home_url(),
					'wm_testimonials' => home_url(),
				) );


		// Processing

			if ( in_array( $post_type, array_keys( $redirects ) ) ) {
				$display = false;
			}


		// Output

			return $display;

	} // /firefly_bcn_admin

	add_filter( 'bcn_show_cpt_private', 'firefly_bcn_admin', 10, 2 );



	/**
	 * Breadcrumbs
	 *
	 * Adding random number to breadcrumbs label ID to allow multiple breadcrumbs display.
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_bcn_breadcrumbs() {

		// Output

			if (
					function_exists( 'bcn_display' )
					&& ! is_404()
					&& ! is_front_page()
					&& apply_filters( 'wmhook_firefly_breadcrumbs_enabled', true )
				) {

				$id_index = rand( 10, 99 );

				echo '<div class="breadcrumbs-container">'
				     . '<nav class="breadcrumbs" aria-labelledby="breadcrumbs-label-' . absint( $id_index ) . '"' . firefly_schema_org( 'BreadcrumbList' ) . '>'
				     . '<h2 class="screen-reader-text" id="breadcrumbs-label-' . absint( $id_index ) . '">' . esc_attr__( 'Breadcrumbs navigation', 'firefly' ) . '</h2>'
				     . bcn_display( true )
				     . '</nav>'
				     . '</div>';

			}

	} // /firefly_bcn_breadcrumbs

	add_action( 'tha_content_before', 'firefly_bcn_breadcrumbs', 10 );
	add_action( 'tha_content_after',  'firefly_bcn_breadcrumbs', 10 );
