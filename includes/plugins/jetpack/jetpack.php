<?php
/**
 * Plugin integration
 *
 * Jetpack
 *
 * @link  https://wordpress.org/plugins/jetpack/
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

	if ( ! class_exists( 'Jetpack' ) ) {
		return;
	}





/**
 * 20) Plugin integration
 */

	/**
	 * Jetpack setup
	 *
	 * @uses  firefly_jetpack_is_render()
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_jetpack_setup() {

		// Processing

			// Site logo

				add_theme_support( 'site-logo' );

			// Responsive videos

				add_theme_support( 'jetpack-responsive-videos' );

			// Infinite scroll

				add_theme_support( 'infinite-scroll', apply_filters( 'wmhook_fn_firefly_jetpack_setup_infinite_scroll', array(
						'container'      => 'posts',
						'footer'         => false,
						'posts_per_page' => 6,
						'render'         => 'firefly_jetpack_is_render',
						'type'           => 'scroll',
						'wrapper'        => false,
					) ) );

	} // /firefly_jetpack_setup

	add_action( 'after_setup_theme', 'firefly_jetpack_setup', 30 );



	/**
	 * Accessibility fixes
	 */

		/**
		 * Level up heading tags
		 *
		 * Levels up the HTML headings in single post/page view.
		 * Transforms H3 to H2 and H4 to H3.
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  string $html
		 */
		function firefly_headings_level_up( $html ) {

			// Requirements check

				if ( ! firefly_is_singular() ) {
					return $html;
				}


			// Processing

				switch ( $html ) {

					case 'h3':
							$html = tag_escape( 'h2' );
						break;

					case 'h4':
							$html = tag_escape( 'h3' );
						break;

					default:
							$html = str_replace(
									array(
										'<h3', '</h3', // 1) H3...
										'<h4', '</h4', // 2) H4...
									),
									array(
										'<h2', '</h2', // 1) ...to H2
										'<h3', '</h3', // 2) ...to H3
									),
									$html
								);
						break;

				} // /switch


			// Output

				return $html;

		} // /firefly_headings_level_up

		add_filter( 'jetpack_sharing_display_markup',           'firefly_headings_level_up', 999 );
		add_filter( 'jetpack_relatedposts_filter_headline',     'firefly_headings_level_up', 999 );
		add_filter( 'jetpack_relatedposts_filter_post_heading', 'firefly_headings_level_up', 999 );



	/**
	 * Jetpack sharing buttons
	 */

		/**
		 * Jetpack sharing display
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  bool $show
		 * @param  obj  $post
		 */
		function firefly_jetpack_sharing_show( $show, $post ) {

			// Processing

				if (
						in_array( 'the_excerpt', (array) $GLOBALS['wp_current_filter'] )
						|| ! firefly_is_singular()
					) {

					$show = false;

				}


			// Output

				return $show;

		} // /firefly_jetpack_sharing_show

		add_filter( 'sharing_show', 'firefly_jetpack_sharing_show', 10, 2 );



	/**
	 * Jetpack infinite scroll
	 */

		/**
		 * Jetpack infinite scroll JS settings array modifier
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  array $settings
		 */
		function firefly_jetpack_is_js_settings( $settings ) {

			// Helper variables

				$settings['text'] = esc_js( esc_html__( 'Load more&hellip;', 'firefly' ) );


			// Output

				return $settings;

		} // /firefly_jetpack_is_js_settings

		add_filter( 'infinite_scroll_js_settings', 'firefly_jetpack_is_js_settings', 10 );



		/**
		 * Jetpack infinite scroll posts renderer
		 *
		 * @see  firefly_jetpack_setup()
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		function firefly_jetpack_is_render() {

			// Output

				while ( have_posts() ) :

					the_post();

					get_template_part( 'template-parts/content', get_post_format() );

				endwhile;

		} // /firefly_jetpack_is_render
