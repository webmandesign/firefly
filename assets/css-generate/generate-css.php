<?php
/**
 * Main stylesheet generator
 *
 * @uses  `wmhook_firefly_esc_css` global hook
 * @uses  `wmhook_firefly_generate_css_replacements` global hook
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 */





/**
 * Helper variables
 */

	$output = '';

	$firefly_theme_css_files = array(
			10 => 'assets/css/main.css',
			20 => 'assets/css/shortcodes.css',
		);



		/**
		 * Allow filtering
		 */

			$firefly_theme_css_files = apply_filters( 'wmhook_firefly_css_files_ve', $firefly_theme_css_files );

			ksort( $firefly_theme_css_files );





/**
 * Preparing output
 */

	// Buffer

		ob_start();

		// Start including files and editing output

			foreach ( $firefly_theme_css_files as $css_file_name ) {
				locate_template( $css_file_name, true );
			}

		$output = ob_get_clean();





/**
 * Customizer styles
 */

	locate_template( 'assets/css-generate/custom-styles.php', true );

	$output .= "\r\n\r\n\r\n/**\r\n * Customize styles\r\n */\r\n\r\n" . firefly_custom_styles();





/**
 * Replace variables
 */

	$replacements = (array) apply_filters( 'wmhook_firefly_generate_css_replacements', array() );

	if ( ! empty( $replacements ) ) {
		$output = strtr( $output, $replacements );
	}





/**
 * Output
 */

	echo apply_filters( 'wmhook_firefly_esc_css', $output );
