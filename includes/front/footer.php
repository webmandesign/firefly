<?php
/**
 * Structure: Footer
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 *
 * Contents:
 *
 * 10) Site footer
 * 20) HTML
 */





/**
 * 10) Site footer
 */

	/**
	 * Footer top
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_footer_top() {

		// Output

			echo "\r\n\r\n" . '<footer id="colophon" class="site-footer" role="contentinfo"' . firefly_schema_org( 'WPFooter' ) . '>' . "\r\n\r\n";

	} // /firefly_footer_top

	add_action( 'tha_footer_top', 'firefly_footer_top', 100 );



	/**
	 * Footer widgets
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_footer_widgets() {

		// Output

			get_sidebar( 'footer' );

	} // /firefly_footer_widgets

	add_action( 'tha_footer_top', 'firefly_footer_widgets', 200 );



	/**
	 * Footer credits
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_footer_credits() {

		// Helper variables

			$theme = Firefly_Theme_Framework::get_theme_slug();

			$footer_credits = trim( get_theme_mod( 'texts_credits' ) );

			if ( empty( $footer_credits ) ) {

				// Default credits text

					$footer_credits = '&copy; ' . date( 'Y' ) . ' <a href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo( 'name' ) . '</a><span class="sep"> | </span>'
						. sprintf(
								esc_html__( 'Powered by %s', 'firefly' ),
								'<a href="' . esc_url( __( 'http://wordpress.org/', 'firefly' ) ) . '">WordPress</a>'
							)
						. '<span class="sep"> | </span>'
						. sprintf(
								esc_html_x( 'Theme: %1$s by %2$s', '1: theme name, 2: theme developer name', 'firefly' ),
								'<a href="' . esc_url( wp_get_theme( $theme )->get( 'ThemeURI' ) ) . '"><strong>' . wp_get_theme( $theme )->get( 'Name' ) . '</strong></a>',
								'<a href="' . esc_url( wp_get_theme( $theme )->get( 'AuthorURI' ) ) . '">' . wp_get_theme( $theme )->get( 'Author' ) . '</a>'
							)
						. '<span class="sep"> | </span>'
						. '<a href="#top" id="back-to-top" class="back-to-top">' . esc_html__( 'Back to top &uarr;', 'firefly' ) . '</a>';

			}


		// Output

			if ( '-' !== $footer_credits ) {

				echo '<div class="site-footer-area footer-area-site-info">';

					echo '<div class="site-footer-area-inner site-info-inner">';

						// No need to apply wp_kses_post() on output as it is already validated via Customizer.

							echo '<div id="site-info" class="site-info">' . (string) $footer_credits . '</div>';

						firefly_menu_social();

					echo '</div>';

				echo '</div>';

			}

	} // /firefly_footer_credits

	add_action( 'tha_footer_bottom', 'firefly_footer_credits', 90 );



	/**
	 * Footer bottom
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_footer_bottom() {

		// Output

			echo "\r\n\r\n" . '</footer>' . "\r\n\r\n";

	} // /firefly_footer_bottom

	add_action( 'tha_footer_bottom', 'firefly_footer_bottom', 100 );





/**
 * 20) HTML
 */

	/**
	 * Body bottom
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_body_bottom() {

		// Helper variables

			$output  = "\r\n\t" . '</div><!-- /.site-inner -->';
			$output .= "\r\n" . '</div><!-- /#page -->' . "\r\n\r\n";


		// Output

			echo $output;

	} // /firefly_body_bottom

	add_action( 'tha_body_bottom', 'firefly_body_bottom', 100 );
