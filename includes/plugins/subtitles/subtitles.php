<?php
/**
 * Plugin integration
 *
 * Subtitles
 *
 * @link  https://wordpress.org/plugins/subtitles/
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

	if ( ! class_exists( 'Subtitles' ) ) {
		return;
	}





/**
 * 20) Plugin integration
 */

	// Remove plugin CSS

		if ( method_exists( 'Subtitles', 'subtitle_styling' ) ) {
			remove_action( 'wp_head', array( Subtitles::getInstance(), 'subtitle_styling' ) );
		}



	/**
	 * Plugin setup
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_subtitles_setup() {

		// Processing


			add_post_type_support( 'wm_modules',  'subtitles' );
			add_post_type_support( 'wm_projects', 'subtitles' );
			add_post_type_support( 'wm_staff',    'subtitles' );

	} // /firefly_subtitles_setup

	add_action( 'after_setup_theme', 'firefly_subtitles_setup' );



	/**
	 * Subtitles support in single post title outside the loop
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  string $title
	 * @param  object $post
	 */
	function firefly_subtitles_single_post_title( $title, $post ) {

		// Processing

			if (
					function_exists( 'get_the_subtitle' )
					&& ! doing_action( 'wp_head' )
					&& ! in_the_loop()
					&& ! doing_action( 'tha_header_top' ) // Prevent HTML output in logo too
				) {

				$subtitle = get_the_subtitle( absint( $post->ID ) );

				if ( ! empty( $subtitle ) ) {

					$title  = '<span class="entry-title-primary">' . $title . '</span>';
					$title .= ' <span class="entry-subtitle">' . $subtitle . '</span>';

				}

			}


		// Output

			return $title;

	} // /firefly_subtitles_single_post_title

	add_filter( 'single_post_title', 'firefly_subtitles_single_post_title', 100, 2 );
