<?php
/**
 * Structure: Header
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 *
 * Contents:
 *
 * 10) Assets
 * 20) HTML
 * 30) Site header
 */





/**
 * 10) Assets
 */

	/**
	 * Registering theme styles and scripts
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_register_assets() {

		// Helper variables

			$theme = Firefly_Theme_Framework::get_theme_slug();

			$wp_upload_dir    = wp_upload_dir();
			$theme_upload_dir = trailingslashit( $wp_upload_dir['basedir'] . get_theme_mod( '__path_theme_generated_files' ) );
			$dev_suffix       = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? ( '.dev' ) : ( '' );
			$version          = esc_attr( trim( wp_get_theme( $theme )->get( 'Version' ) ) );

			$stylesheets = array(
					'global' => ( ! file_exists( $theme_upload_dir . 'global.css' ) ) ? ( Firefly_Theme_Framework::get_stylesheet_directory_uri( 'fallback.css' ) ) : ( str_replace( array( 'http:', 'https:', '.css' ), array( '', '', $dev_suffix . '.css' ), get_theme_mod( '__url_css' ) ) ),
				);

			if ( ! $stylesheets['global'] ) {
				$stylesheets['global'] = get_stylesheet_uri();
			}

			$stylesheets = apply_filters( 'wmhook_fn_firefly_register_assets_stylesheets', $stylesheets );


		// Processing

			/**
			 * Styles
			 */

				$register_styles = apply_filters( 'wmhook_fn_firefly_register_assets_register_styles', array(
						'firefly-google-fonts'      => array( firefly_google_fonts_url() ),
						'firefly-stylesheet'        => array( 'src' => get_stylesheet_uri(), 'deps' => array( 'firefly-stylesheet-global' ) ),
						'firefly-stylesheet-global' => array( $stylesheets['global'] ),
						'firefly-stylesheet-print'  => array( 'src' => Firefly_Theme_Framework::get_stylesheet_directory_uri( 'assets/css/print.css' ), 'media' => 'print' ),
					), $stylesheets );

				foreach ( $register_styles as $handle => $atts ) {
					$src   = ( isset( $atts['src'] )   ) ? ( $atts['src']   ) : ( $atts[0] );
					$deps  = ( isset( $atts['deps'] )  ) ? ( $atts['deps']  ) : ( false    );
					$ver   = ( isset( $atts['ver'] )   ) ? ( $atts['ver']   ) : ( $version );
					$media = ( isset( $atts['media'] ) ) ? ( $atts['media'] ) : ( 'screen' );

					wp_register_style( $handle, $src, $deps, $ver, $media );
				} // /foreach

			/**
			 * Scripts
			 */

				$register_scripts = array(
						'jquery-fitvids'              => array( Firefly_Theme_Framework::get_stylesheet_directory_uri( 'assets/js/fitvids/jquery.fitvids.js' ) ),
						'firefly-skip-link-focus-fix' => array( Firefly_Theme_Framework::get_stylesheet_directory_uri( 'assets/js/skip-link-focus-fix.js' ) ),
						'firefly-scripts-global'      => array( Firefly_Theme_Framework::get_stylesheet_directory_uri( 'assets/js/scripts-global.js' ) ),
						'firefly-scripts-navigation'  => array( Firefly_Theme_Framework::get_stylesheet_directory_uri( 'assets/js/scripts-navigation.js' ) ),
					);

				$register_scripts = apply_filters( 'wmhook_fn_firefly_register_assets_register_scripts', $register_scripts );

				foreach ( $register_scripts as $handle => $atts ) {
					$src       = ( isset( $atts['src'] )       ) ? ( $atts['src']       ) : ( $atts[0]          );
					$deps      = ( isset( $atts['deps'] )      ) ? ( $atts['deps']      ) : ( array( 'jquery' ) );
					$ver       = ( isset( $atts['ver'] )       ) ? ( $atts['ver']       ) : ( $version          );
					$in_footer = ( isset( $atts['in_footer'] ) ) ? ( $atts['in_footer'] ) : ( true              );

					wp_register_script( $handle, $src, $deps, $ver, $in_footer );
				}

	} // /firefly_register_assets

	add_action( 'init', 'firefly_register_assets', -10 );



	/**
	 * Frontend HTML head assets enqueue
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_enqueue_assets() {

		// Helper variables

			global $is_IE, $wp_styles;

			$enqueue_styles = $enqueue_scripts = array();

			$body_classes   = (array) apply_filters( 'body_class', array() );
			$footer_widgets = (array) wp_get_sidebars_widgets();

			$theme = Firefly_Theme_Framework::get_theme_slug();


		// Processing

			/**
			 * Styles
			 */

				// SASS debugging - enqueue default (fallback) stylesheet

					if ( defined( 'FIREFLY_DEBUG_SASS' ) && FIREFLY_DEBUG_SASS ) {

						wp_deregister_style( 'firefly-stylesheet-global' ); // Must deregister to register again with new URL

						wp_register_style(
								'firefly-stylesheet-global',
								Firefly_Theme_Framework::get_stylesheet_directory_uri( 'fallback.css' ),
								false,
								esc_attr( trim( wp_get_theme( $theme )->get( 'Version' ) ) ),
								'screen'
							);

					}

				// Google Fonts

					if ( firefly_google_fonts_url() ) {
						$enqueue_styles[] = 'firefly-google-fonts';
					}

				// Main

					$enqueue_styles[] = 'firefly-stylesheet';

				// Print

					$enqueue_styles[] = 'firefly-stylesheet-print';

				$enqueue_styles = apply_filters( 'wmhook_fn_firefly_enqueue_assets_enqueue_styles', $enqueue_styles );

				foreach ( $enqueue_styles as $handle ) {
					wp_enqueue_style( $handle );
				}

			/**
			 * Scripts
			 */

				// Global theme scripts

					$enqueue_scripts[] = 'firefly-scripts-global';

				// Navigation scripts

					$enqueue_scripts[] = 'firefly-scripts-navigation';

				// Skip link focus fix

					$enqueue_scripts[] = 'firefly-skip-link-focus-fix';

				$enqueue_scripts = apply_filters( 'wmhook_fn_firefly_enqueue_assets_enqueue_scripts', $enqueue_scripts );

				foreach ( $enqueue_scripts as $handle ) {
					wp_enqueue_script( $handle );
				}

	} // /firefly_enqueue_assets

	add_action( 'wp_enqueue_scripts', 'firefly_enqueue_assets', 100 );



	/**
	 * Customizer preview assets enqueue
	 *
	 * @uses  firefly_custom_styles()
	 * @uses  `wmhook_firefly_esc_css` global hook
	 * @uses  `wmhook_firefly_generate_css_replacements` global hook
	 *
	 * @see  assets/css-generate/custom-styles.php
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_customizer_preview_enqueue_assets() {

		// Required files

			locate_template( 'assets/css-generate/custom-styles.php', true );


		// Helper variables

			$theme = Firefly_Theme_Framework::get_theme_slug();

			$output = (string) apply_filters( 'wmhook_fn_firefly_customizer_preview_enqueue_assets_inline_styles', firefly_custom_styles() );


		/**
		 * Styles
		 */

			if ( ! empty( $output ) ) {

				$replacements = (array) apply_filters( 'wmhook_firefly_generate_css_replacements', array() );

				if ( ! empty( $replacements ) ) {
					$output = strtr( $output, $replacements );
				}

				wp_add_inline_style(
						'firefly-stylesheet-global',
						apply_filters( 'wmhook_firefly_esc_css', $output )
					);

			}


		/**
		 * Scripts
		 */

			wp_enqueue_script(
					'firefly-customize-preview',
					Firefly_Theme_Framework::get_stylesheet_directory_uri( 'assets/js/customize-preview.js' ),
					array( 'jquery', 'customize-preview' ),
					esc_attr( trim( wp_get_theme( $theme )->get( 'Version' ) ) ),
					true
				);

	} // /firefly_customizer_preview_enqueue_assets

	add_action( 'customize_preview_init', 'firefly_customizer_preview_enqueue_assets', 10 );



	/**
	 * Enqueue `comment-reply.js` the right way
	 *
	 * @link  http://wpengineer.com/2358/enqueue-comment-reply-js-the-right-way/
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_enqueue_comments_reply() {

		// Processing

			if ( get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}

	} // /firefly_enqueue_comments_reply

	add_action( 'comment_form_before', 'firefly_enqueue_comments_reply', 10 );



	if ( ! ( current_theme_supports( 'jetpack-responsive-videos' ) && function_exists( 'jetpack_responsive_videos_init' ) ) ) :

	/**
	 * Enqueues FitVids only when needed
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  string $html The generated HTML of the shortcodes
	 */
	function firefly_enqueue_fitvids( $html ) {

		// Requirements check

			if (
					is_admin()
					|| empty( $html )
					|| ! is_string( $html )
				) {
				return $html;
			}


		// Processing

			wp_enqueue_script( 'jquery-fitvids' );


		// Output

			return $html;

	} // /firefly_enqueue_fitvids

	add_filter( 'embed_handler_html', 'firefly_enqueue_fitvids' );
	add_filter( 'embed_oembed_html',  'firefly_enqueue_fitvids' );

	endif;





/**
 * 20) HTML
 */

	/**
	 * HTML DOCTYPE
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_doctype() {

		// Output

			echo '<!DOCTYPE html>';

	} // /firefly_doctype

	add_action( 'tha_html_before', 'firefly_doctype', 10 );



	/**
	 * HTML HEAD
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_head() {

		// Helper variables

			$output = array();


		// Processing

			$output[10] = '<meta charset="' . get_bloginfo( 'charset' ) . '" />';
			$output[20] = '<meta name="viewport" content="width=device-width, initial-scale=1" />';
			$output[30] = '<link rel="profile" href="http://gmpg.org/xfn/11" />';
			$output[40] = '<link rel="pingback" href="' . get_bloginfo( 'pingback_url' ) . '" />';

			// Filter output array

				$output = apply_filters( 'wmhook_fn_firefly_head_output_array', $output );


		// Output

			echo implode( "\r\n", $output ) . "\r\n";

	} // /firefly_head

	add_action( 'wp_head', 'firefly_head', 1 );



	/**
	 * IE8 upgrade message
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_message_oldie() {

		// Requirements check

			if ( ! isset( $GLOBALS['is_IE'] ) || ! $GLOBALS['is_IE'] ) {
				return;
			}


		// Processing

			$output  = '<!--[if lt IE 9]>';
			$output .= '<div class="message-oldie">';
			$output .= esc_html__( 'Sorry, but this website does not support Internet Explorer 8 or lower.', 'firefly' ) . '<br />';
			$output .= '<a href="http://windows.microsoft.com/ie">' . esc_html__( 'Please, upgrade your Internet Explorer.', 'firefly' ) . '</a>';
			$output .= ' <a href="http://browsehappy.com/">' . esc_html__( 'Or, switch to another browser.', 'firefly' ) . '</a>';
			$output .= '</div>';
			$output .= '<![endif]-->';


		// Output

			echo $output;

	} // /firefly_message_oldie

	add_action( 'tha_body_top', 'firefly_message_oldie', 5 );



	/**
	 * Skip links: Body top
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_skip_links_body_top() {

		// Processing

			$output  = Firefly_Theme_Framework::link_skip_to( 'content' );
			$output .= Firefly_Theme_Framework::link_skip_to( 'site-navigation', __( 'Skip to navigation', 'firefly' ) );


		// Output

			echo $output;

	} // /firefly_skip_links_body_top

	add_action( 'tha_body_top', 'firefly_skip_links_body_top', 5 );



	/**
	 * Body top
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_body_top() {

		// Processing

			$output  = '<div id="page" class="hfeed site">' . "\r\n";
			$output .= "\t" . '<div class="site-inner">' . "\r\n";


		// Output

			echo $output;

	} // /firefly_body_top

	add_action( 'tha_body_top', 'firefly_body_top', 10 );



	/**
	 * HTML Body classes
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  array $classes
	 */
	function firefly_body_classes( $classes ) {

		// Helper variables

			$body_classes = array();

			$i = 0;


		// Processing

			// Website layout

				if ( $layout = get_theme_mod( 'layout_site' ) ) {
					$body_classes[ esc_attr( 'site-layout-' . $layout ) ] = ++$i;
				} else {
					$body_classes[ esc_attr( 'site-layout-fullwidth' ) ] = ++$i; // Default theme layout
				}

			// Mobile bar enabled?

				if ( has_nav_menu( 'mobile' ) ) {
					$body_classes['has-mobile-bar'] = ++$i;
				}

			// Is not front page?

				if ( ! is_front_page() ) {
					$body_classes['not-front-page'] = ++$i;
				}

			// Singular?

				if ( is_singular() ) {
					$body_classes['is-singular'] = ++$i;
				}

			// Has featured image?

				if ( is_singular() && has_post_thumbnail() ) {
					$body_classes['has-post-thumbnail'] = ++$i;
				}

			// Is posts list?

				if ( is_archive() || is_search() ) {
					$body_classes['is-posts-list'] = ++$i;
				}

			// Sticky header enabled?

				if ( get_theme_mod( 'layout_header_sticky' ) ) {
					$body_classes['do-sticky-header'] = ++$i;
				}


		// Output

			$body_classes = array_filter( (array) apply_filters( 'wmhook_fn_firefly_body_classes_output', $body_classes ) );

			$classes = array_merge( $classes, array_flip( $body_classes ) );

			asort( $classes );

			return $classes;

	} // /firefly_body_classes

	add_filter( 'body_class', 'firefly_body_classes', 98 );





/**
 * 30) Site header
 */

	/**
	 * Header top
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_header_top() {

		// Output

			echo "\r\n\r\n" . '<header id="masthead" class="site-header" role="banner"' . firefly_schema_org( 'WPHeader' ) . '>' . "\r\n\r\n";

	} // /firefly_header_top

	add_action( 'tha_header_top', 'firefly_header_top', 100 );



	/**
	 * Header inner wrap
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_header_inner_wrap() {

		// Output

			echo "\r\n\r\n" . '<div class="site-header-inner">' . "\r\n\r\n";

	} // /firefly_header_inner_wrap

	add_action( 'tha_header_top', 'firefly_header_inner_wrap', 110 );



	/**
	 * Logo
	 */
	add_action( 'tha_header_top', 'Firefly_Theme_Framework::the_logo', 110 );



		/**
		 * Logo class
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  array $class
		 */
		function firefly_logo_class( $class ) {

			// Processing

				if ( ! get_theme_mod( 'others_logo_style_disable' ) ) {
					$class .= ' styled';
				}


			// Output

				return $class;

		} // /firefly_logo_class

		add_filter( 'wmhook_firefly_tf_get_the_logo_class', 'firefly_logo_class' );



	/**
	 * Header inner wrap closing
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_header_inner_wrap_close() {

		// Output

			echo "\r\n\r\n" . '</div>' . "\r\n\r\n";

	} // /firefly_header_inner_wrap_close

	add_action( 'tha_header_bottom', 'firefly_header_inner_wrap_close', 10 );



	/**
	 * Header bottom
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_header_bottom() {

		// Output

			echo "\r\n\r\n" . '</header>' . "\r\n\r\n";

	} // /firefly_header_bottom

	add_action( 'tha_header_bottom', 'firefly_header_bottom', 100 );
