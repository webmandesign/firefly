<?php
/**
 * Structure: Content
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 *
 * Contents:
 *
 * 10) Main
 */





/**
 * 10) Main
 */

	/**
	 * Content opening
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_content_open() {

		// Helper variables

			$output  = "\r\n\r\n" . '<div id="content" class="site-content">';
			$output .= "\r\n\t"   . '<div id="primary" class="content-area">';
			$output .= "\r\n\t\t" . '<main id="main" class="site-main" role="main">' . "\r\n\r\n";


		// Output

			echo $output;

	} // /firefly_content_open

	add_action( 'tha_content_top', 'firefly_content_open', 100 );



	/**
	 * Content closing
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_content_close() {

		// Helper variables

			$output  = "\r\n\r\n\t\t" . '</main><!-- /#main -->';
			$output .= "\r\n\t"       . '</div><!-- /#primary -->';
			$output .= "\r\n"         . '</div><!-- /#content -->' . "\r\n\r\n";


		// Output

			echo $output;

	} // /firefly_content_close

	add_action( 'tha_content_bottom', 'firefly_content_close', 100 );
