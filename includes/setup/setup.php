<?php
/**
 * Theme setup
 *
 * @uses  `wmhook_firefly_esc_css` global hook
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 *
 * Contents:
 *
 *  10) Globals
 *  20) Theme setup
 *  30) Front end
 *  40) Features
 *  50) Visual editor
 * 999) Plugins integration
 */





/**
 * 10) Globals
 */

	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet
	 *
	 * Priority -100 to make it available to lower priority callbacks.
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @global  int $content_width
	 */
	function firefly_content_width() {

		// Processing

			$GLOBALS['content_width'] = absint( get_theme_mod( 'layout_width_content' ) );
			$site_width               = absint( get_theme_mod( 'layout_width_site' ) );

			// Make content width max 88% of site width

				if ( $GLOBALS['content_width'] > absint( $site_width * .88 ) ) {
					$GLOBALS['content_width'] = absint( $site_width * .88 );
				}

			// Set default value if content width is still empty

				if ( empty( $GLOBALS['content_width'] ) ) {
					$GLOBALS['content_width'] = 1200;
				}

	} // /firefly_content_width

	add_action( 'after_setup_theme', 'firefly_content_width', -100 );




	/**
	 * Theme helper variables
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  string $variable Helper variables array key to return
	 * @param  string $key      Additional key if the variable is array
	 */
	function firefly_helper_var( $variable, $key = '' ) {

		// Pre

			$pre = apply_filters( 'wmhook_fn_firefly_helper_var_pre', false, $variable, $key );

			if ( false !== $pre ) {
				return $pre;
			}


		// Helper variables

			$output = array();

			// Google Fonts

				// Left Google Fonts setup for a plugin such as https://wordpress.org/plugins/easy-google-fonts/ - not everyone uses Google Fonts, actually...

			// Widget areas

				$output['widget-areas'] = array(
						'sidebar' => array(
							'name'        => esc_html__( 'Sidebar', 'firefly' ),
							'description' => '',
						),
						'footer'  => array(
							'name'        => esc_html__( 'Footer Widgets', 'firefly' ),
							'description' => '',
						),
					);


		// Output

			$output = apply_filters( 'wmhook_fn_firefly_helper_var_output', $output );

			if ( isset( $output[ $variable ] ) ) {

				$output = $output[ $variable ];

				if ( isset( $output[ $key ] ) ) {
					$output = $output[ $key ];
				}

			} else {

				$output = '';

			}

			return $output;

	} // /firefly_helper_var





/**
 * 20) Theme setup
 */

	/**
	 * Theme installation, setup and upgrade
	 */

		/**
		 * Theme setup
		 *
		 * Note that this function is hooked into the after_setup_theme hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		function firefly_theme_setup() {

			// Helper variables

				$theme = Firefly_Theme_Framework::get_theme_slug();

				$image_sizes = array_filter( apply_filters( 'wmhook_fn_firefly_theme_setup_image_sizes', array() ) );

				// WordPress visual editor CSS stylesheets

					$wp_upload_dir     = wp_upload_dir();
					$theme_upload_dir  = trailingslashit( $wp_upload_dir['basedir'] . get_theme_mod( '__path_theme_generated_files' ) );
					$dev_suffix        = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? ( '.dev' ) : ( '' );
					$visual_editor_css = array();

					// Enqueue Google Fonts stylesheet

						$visual_editor_css[] = str_replace( ',', '%2C', firefly_google_fonts_url() );

					// Enqueue custom generated Visual Editor stylesheet if exists, or load fallback

						if ( ! file_exists( $theme_upload_dir . 'global-ve.css' ) ) {

							// Fallback stylesheet

								$visual_editor_css[] = esc_url( add_query_arg( array(
										'ver' => wp_get_theme( $theme )->get( 'Version' ) ),
										Firefly_Theme_Framework::get_stylesheet_directory_uri( 'assets/css/editor-style.css' )
									) );

						} else {

							// The actual custom generated stylesheet

								$visual_editor_css[] = str_replace(
										array( 'http:', 'https:', '.css' ),
										array( '', '', $dev_suffix . '.css' ),
										get_theme_mod( '__url_css-ve' )
									);

						}

					// Allow filtering the Visual Composer stylesheets

						$visual_editor_css = array_filter( (array) apply_filters( 'wmhook_fn_firefly_theme_setup_visual_editor_css', $visual_editor_css ) );


			// Processing

				// Localization

					/**
					 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
					 */

					// wp-content/languages/themes/theme-folder-name/en_GB.mo

						load_theme_textdomain( 'firefly', trailingslashit( WP_LANG_DIR ) . 'themes/' . get_template() );

					// wp-content/themes/child-theme-folder-name/languages/en_GB.mo

						load_theme_textdomain( 'firefly', get_stylesheet_directory() . '/languages' );

					// wp-content/themes/theme-folder-name/languages/en_GB.mo

						load_theme_textdomain( 'firefly', get_template_directory() . '/languages' );

				// Custom menus

					register_nav_menus( array(
							'primary' => esc_html__( 'Primary Menu', 'firefly' ),
							'social'  => esc_html__( 'Social Links Menu', 'firefly' ),
							'mobile'  => esc_html__( 'Mobile Bar (max 4 links)', 'firefly' ),
						) );

				// Visual editor styles

					add_editor_style( $visual_editor_css );

				// Post types supports

					add_post_type_support( 'page', 'excerpt' );

					add_post_type_support( 'attachment:audio', 'thumbnail' );
					add_post_type_support( 'attachment:video', 'thumbnail' );
					add_post_type_support( 'attachment', 'custom-fields' );

				// Title tag

					/**
					 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
					 */
					add_theme_support( 'title-tag' );

				// Feed links

					/**
					 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Feed_Links
					 */
					add_theme_support( 'automatic-feed-links' );

				// Enable HTML5 markup

					/**
					 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
					 */
					add_theme_support( 'html5', array(
							'comment-list',
							'comment-form',
							'search-form',
							'gallery',
							'caption',
						) );

				// Custom header

					/**
					 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Custom_Header
					 */
					add_theme_support( 'custom-header', apply_filters( 'wmhook_fn_firefly_theme_setup_custom_header_args', array(
							'default-image' => Firefly_Theme_Framework::get_stylesheet_directory_uri( 'assets/images/header.jpg' ),
							'header-text'   => false,
							'width'         => ( isset( $image_sizes['firefly-banner'] ) ) ? ( $image_sizes['firefly-banner'][0] ) : ( 1500 ),
							'height'        => ( isset( $image_sizes['firefly-banner'] ) ) ? ( $image_sizes['firefly-banner'][1] ) : ( 500 ),
							'flex-height'   => true,
							'flex-width'    => true,
						) ) );

				// Custom background

					/**
					 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Custom_Background
					 */
					add_theme_support( 'custom-background', apply_filters( 'wmhook_fn_firefly_theme_setup_custom_background_args', array(
							'default-color' => 'fafcfe',
							// 'wp-head-callback' => '__return_null', // This has to be set to callable function name (not just '') to prevent PHP warning! Also, you can still set the `default-color`.
						) ) );

				// Post formats

					/**
					 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Formats
					 */
					add_theme_support( 'post-formats', array(
							'audio',
							'gallery',
							'image',
							'link',
							'quote',
							'status',
							'video',
						) );

				// Thumbnails support

					/**
					 * @link  https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
					 */
					add_theme_support( 'post-thumbnails', array( 'attachment:audio', 'attachment:video' ) );
					add_theme_support( 'post-thumbnails' );

					// Image sizes (x, y, crop)

						if ( ! empty( $image_sizes ) ) {

							foreach ( $image_sizes as $size => $setup ) {

								if (
										in_array( $size, array( 'thumbnail', 'medium', 'large' ) )
										&& ! get_theme_mod( '__image_size_' . $size )
									) {

									/**
									 * Force the default image sizes on theme installation only.
									 * This allows users to set their own sizes later, but a notification is displayed.
									 */

									$original_image_width = get_option( $size . '_size_w' );

										if ( $image_sizes[ $size ][0] != $original_image_width ) {
											update_option( $size . '_size_w', $image_sizes[ $size ][0] );
										}

									$original_image_height = get_option( $size . '_size_h' );

										if ( $image_sizes[ $size ][1] != $original_image_height ) {
											update_option( $size . '_size_h', $image_sizes[ $size ][1] );
										}

									$original_image_crop = get_option( $size . '_crop' );

										if ( $image_sizes[ $size ][2] != $original_image_crop ) {
											update_option( $size . '_crop', $image_sizes[ $size ][2] );
										}

									set_theme_mod(
											'__image_size_' . $size,
											array(
												$original_image_width,
												$original_image_height,
												$original_image_crop
											)
										);

								} else {

									add_image_size(
											$size,
											$image_sizes[ $size ][0],
											$image_sizes[ $size ][1],
											$image_sizes[ $size ][2]
										);

								}

							} // /foreach

						}

		} // /firefly_theme_setup

		add_action( 'after_setup_theme', 'firefly_theme_setup', 10 );



		/**
		 * Theme installation process
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		function firefly_theme_installation() {

			// Helper variables

				$theme = Firefly_Theme_Framework::get_theme_slug();

				$installed = get_theme_mod( '__theme_installed' );


			// Requirements check

				if ( $installed ) {
					return;
				}


			// Processing

				// Generate the custom stylesheet

					// Firefly_Theme_Framework::generate_all_css();

				// Display admin notice for "About" page

					if ( ! get_theme_mod( 'others_about_disable' ) ) {

						set_transient(
								'firefly_admin_notice',
								array(
									'<strong>' . sprintf( esc_html__( 'Thank you for installing the %s theme!', 'firefly' ), wp_get_theme( $theme )->get( 'Name' ) ) . ' <a href="' . esc_url( admin_url( 'themes.php?page=' . FIREFLY_THEME_SLUG . '-about' ) ) . '">' . esc_html__( 'Please read the information about the theme.', 'firefly' ) . '</a></strong>',
									'',
									'switch_themes',
									3
								),
								( 60 * 60 * 48 )
							);

					}

				// Set Beaver Builder post types on theme's first activation
				// This is required here as the Beaver Builder plugin might not be active yet

					update_option( '_fl_builder_post_types', array( 'post', 'page' ) );

				// Other theme installation actions

					do_action( 'wmhook_fn_firefly_theme_installation' );

		} // /firefly_theme_installation

		add_action( 'after_setup_theme', 'firefly_theme_installation', 1 );



		/**
		 * Theme upgrade
		 */
		// add_action( 'wmhook_firefly_tf_theme_upgrade', 'Firefly_Theme_Framework::generate_all_css' );



	/**
	 * Setup images
	 */

		/**
		 * Image sizes
		 *
		 * @example
		 *
		 *   $image_sizes = array(
		 *     'image_size_id' => array(
		 *       absint( width ),
		 *       absint( height ),
		 *       (bool) cropped?,
		 *       (string) optional_theme_usage_explanation_text
		 *     )
		 *   );
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  array $image_sizes
		 */
		function firefly_image_sizes( $image_sizes ) {

			// Helper variables

				global $content_width;

				$body_classes = (array) apply_filters( 'body_class', array() );

				// Banner image size

					if ( in_array( 'site-layout-boxed', $body_classes ) ) {

						$banner_width = absint( get_theme_mod( 'layout_width_site' ) );

						if ( 1000 > $banner_width ) {
							$banner_width = 1760;
						}

					} else {

						$banner_width = 1920;

					}

					$banner_height = 9999;


			// Processing

				$image_sizes = array(

						'thumbnail' => array(
								480,
								640,
								true,
								esc_html__( 'In posts list.', 'firefly' )
							),

						'medium' => array(
								absint( $content_width * .62 ),
								9999,
								false,
								esc_html__( 'In single staff post page.', 'firefly' )
							),

						'large' => array(
								absint( $content_width ),
								9999,
								false,
								esc_html__( 'In single post page.', 'firefly' )
							),

						'firefly-banner' => array(
								$banner_width,
								$banner_height,
								true,
								esc_html__( 'As intro heading background.', 'firefly' )
							),

					);


			// Output

				return $image_sizes;

		} // /firefly_image_sizes

		add_filter( 'wmhook_fn_firefly_theme_setup_image_sizes', 'firefly_image_sizes' );



		/**
		 * Reset predefined image sizes to their original values
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		function firefly_image_sizes_reset() {

			// Helper variables

				$image_sizes = array( 'thumbnail', 'medium', 'large' );
				$theme_old   = get_option( 'theme_switched' );
				$theme_mods  = get_option( 'theme_mods_' . $theme_old );

				$update_theme_mods = false;


			// Processing

				foreach ( $image_sizes as $size ) {

					$values = (array) ( isset( $theme_mods[ '__image_size_' . $size ] ) ) ? ( $theme_mods[ '__image_size_' . $size ] ) : ( array() );

					// Skip processing if we do not have the image height and crop value

						if ( ! isset( $values[1] ) || ! isset( $values[2] ) ) {
							continue;
						}

					// Old image width

						if ( $values[0] ) {
							update_option( $size . '_size_w', $values[0] );
						}

					// Old image height

						if ( $values[1] ) {
							update_option( $size . '_size_h', $values[1] );
						}

					// Old image crop

						if ( $values[2] ) {
							update_option( $size . '_crop', $values[2] );
						}

					// Remove the image settings from theme mods for future reset

						unset( $theme_mods[ '__image_size_' . $size ] );

						$update_theme_mods = true;

				} // /foreach

				if ( $update_theme_mods ) {
					update_option( 'theme_mods_' . $theme_old, $theme_mods );
				}

		} // /firefly_image_sizes_reset

		add_action( 'switch_theme', 'firefly_image_sizes_reset' );



		/**
		 * Register recommended image sizes notice
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		function firefly_image_sizes_notice() {

			// Processing

				add_settings_field(
						// $id
						'recommended-image-sizes',
						// $title
						'',
						// $callback
						'firefly_image_sizes_notice_html',
						// $page
						'media',
						// $section
						'default',
						// $args
						array()
					);

				register_setting(
						// $option_group
						'media',
						// $option_name
						'recommended-image-sizes',
						// $sanitize_callback
						'esc_attr'
					);

		} // /firefly_image_sizes_notice

		add_action( 'admin_init', 'firefly_image_sizes_notice' );



		/**
		 * Display recommended image sizes notice
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		function firefly_image_sizes_notice_html() {

			// Helper variables

				$default_image_size_names = array(
						'thumbnail' => esc_html_x( 'Thumbnail size', 'WordPress predefined image size name.', 'firefly' ),
						'medium'    => esc_html_x( 'Medium size', 'WordPress predefined image size name.', 'firefly' ),
						'large'     => esc_html_x( 'Large size', 'WordPress predefined image size name.', 'firefly' ),
					);

				$image_sizes = array_filter( apply_filters( 'wmhook_fn_firefly_theme_setup_image_sizes', array() ) );


			// Requirements check

				if ( empty( $image_sizes ) ) {
					return;
				}


			// Output

				// Section styles

					echo '<style type="text/css" media="screen">'
						. '.recommended-image-sizes { display: inline-block; padding: 1.62em; border: 2px solid #dadcde; }'
						. '.recommended-image-sizes h3:first-child { margin-top: 0; }'
						. '.recommended-image-sizes table { margin-top: 1em; }'
						. '.recommended-image-sizes th, .recommended-image-sizes td { width: auto; padding: .19em 1em; border-bottom: 2px dotted #dadcde; vertical-align: top; }'
						. '.recommended-image-sizes thead th { padding: .62em 1em; border-bottom-style: solid; }'
						. '.recommended-image-sizes tr[title] { cursor: help; }'
						. '.recommended-image-sizes .small, .recommended-image-sizes tr[title] th, .recommended-image-sizes tr[title] td { font-size: .81em; }'
						. '</style>';

				// Section HTML

					echo '<div class="recommended-image-sizes">';

						do_action( 'wmhook_fn_firefly_image_sizes_notice_html_top' );

						echo '<h3>' . esc_html__( 'Recommended image sizes', 'firefly' ) . '</h3>'
							. '<p>' . esc_html__( 'For the theme to work correctly, please, set these recommended image sizes:', 'firefly' ) . '</p>';

						echo '<table>';

							echo '<thead>'
								. '<tr>'
								. '<th>' . esc_html__( 'Size name', 'firefly' ) . '</th>'
								. '<th>' . esc_html__( 'Size parameters', 'firefly' ) . '</th>'
								. '<th>' . esc_html__( 'Theme usage', 'firefly' ) . '</th>'
								. '</tr>'
								. '</thead>';

							echo '<tbody>';

								foreach ( $image_sizes as $size => $setup ) {

									$crop = ( $setup[2] ) ? ( esc_html__( 'cropped', 'firefly' ) ) : ( esc_html__( 'scaled', 'firefly' ) );

									if ( isset( $default_image_size_names[ $size ] ) ) {

										echo '<tr><th>' . esc_html( $default_image_size_names[ $size ] ) . ':</th>';

									} else {

										echo '<tr title="' . esc_attr__( 'Additional image size added by the theme. Can not be changed on this page.', 'firefly' ) . '"><th><code>' . esc_html( $size ) . '</code>:</th>';

									}

									echo '<td>' . sprintf(
											esc_html_x( '%1$d &times; %2$d, %3$s', '1: image width, 2: image height, 3: cropped or scaled?', 'firefly' ),
											absint( $setup[0] ),
											absint( $setup[1] ),
											$crop
										) . '</td>'
										. '<td class="small">' . ( ( isset( $setup[3] ) ) ? ( $setup[3] ) : ( '&mdash;' ) ) . '</td>'
										. '</tr>';

								} // /foreach

							echo '</tbody>';

						echo '</table>';

						do_action( 'wmhook_fn_firefly_image_sizes_notice_html_bottom' );

					echo '</div>';

		} // /firefly_image_sizes_notice_html



	/**
	 * Setup typography
	 */

		/**
		 * Google Fonts
		 *
		 * Custom fonts setup left for plugins.
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  array $fonts_setup
		 */
		function firefly_google_fonts( $fonts_setup ) {

			// Requirements check

				if ( get_theme_mod( 'fonts_disable' ) ) {
					return array();
				}


			// Helper variables

				$fonts_setup = array(
						'Roboto Condensed:700',
						'Roboto:700,400,300',
					);


			// Output

				return $fonts_setup;

		} // /firefly_google_fonts

		add_filter( 'wmhook_fn_firefly_google_fonts_url_fonts_setup', 'firefly_google_fonts' );



		/**
		 * Get Google Fonts link
		 *
		 * Returns a string such as:
		 * //fonts.googleapis.com/css?family=Alegreya+Sans:300,400|Exo+2:400,700|Allan&subset=latin,latin-ext
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  array $fonts Fallback fonts.
		 */
		function firefly_google_fonts_url( $fonts = array() ) {

			// Pre

				$pre = apply_filters( 'wmhook_fn_firefly_google_fonts_url_pre', false, $fonts );

				if ( false !== $pre ) {
					return $pre;
				}


			// Helper variables

				$output = '';
				$family = array();
				$subset = ( 'sk_SK' !== get_locale() ) ? ( array( 'latin' ) ) : ( array( 'latin', 'latin-ext' ) );
				$subset = (array) apply_filters( 'wmhook_fn_firefly_google_fonts_url_subset', $subset );

				$fonts_setup = array_filter( (array) apply_filters( 'wmhook_fn_firefly_google_fonts_url_fonts_setup', array() ) );

				if ( empty( $fonts_setup ) && ! empty( $fonts ) ) {
					$fonts_setup = (array) $fonts;
				}


			// Requirements check

				if ( empty( $fonts_setup ) ) {
					return $output;
				}


			// Processing

				foreach ( $fonts_setup as $section ) {

					$font = trim( $section );

					if ( $font ) {
						$family[] = str_replace( ' ', '+', $font );
					}

				} // /foreach

				if ( ! empty( $family ) ) {

					$output = esc_url_raw( add_query_arg( array( // Use `esc_url_raw()` for HTTP requests.
							'family' => implode( '|', (array) array_unique( $family ) ),
							'subset' => implode( ',', (array) $subset ), // Subset can be array if multiselect Customizer input field used
						), '//fonts.googleapis.com/css' ) );

				}


			// Output

				return $output;

		} // /firefly_google_fonts_url



	/**
	 * Setup widgets
	 */

		/**
		 * Register predefined widget areas (sidebars)
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		function firefly_register_widget_areas() {

			// Processing

				foreach( firefly_helper_var( 'widget-areas' ) as $id => $area ) {

					register_sidebar( array(
							'id'            => esc_attr( $id ),
							'name'          => $area['name'],
							'description'   => isset( $area['description'] ) ? ( $area['description'] ) : ( '' ),
							'before_widget' => '<section id="%1$s" class="widget %2$s">',
							'after_widget'  => '</section>',
							'before_title'  => '<h3 class="widget-title">',
							'after_title'   => '</h3>'
						) );

				} // /foreach

		} // /firefly_register_widget_areas

		add_action( 'widgets_init', 'firefly_register_widget_areas', 1 );



	/**
	 * Setup Visual Editor
	 */

		/**
		 * Include Visual Editor (TinyMCE) addons
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		function firefly_visual_editor() {

			// Processing

				if (
						is_admin()
						|| isset( $_GET['fl_builder'] )
					) {

					locate_template( FIREFLY_LIBRARY_DIR . 'includes/visual-editor.php', true );

				}

		} // /firefly_visual_editor

		add_action( 'after_setup_theme', 'firefly_visual_editor' );





/**
 * 30) Front end
 */

	// Theme Hook Alliance

		locate_template( 'includes/front/tha.php', true );

	// Header

		locate_template( 'includes/front/header.php', true );

	// Menu

		locate_template( 'includes/front/menu.php', true );

	// Content

		locate_template( 'includes/front/content.php', true );

	// Loop

		locate_template( 'includes/front/loop.php', true );

	// Post

		locate_template( 'includes/front/post.php', true );

	// Footer

		locate_template( 'includes/front/footer.php', true );





/**
 * 40) Features
 */

	// Theme options arrays

		locate_template( 'includes/theme-options/theme-options.php', true );

	// Custom Header (Banner)

		locate_template( 'includes/custom-header/custom-header.php', true );

	// Post formats support

		locate_template( 'includes/post-formats/class-post-formats.php', true );





/**
 * 50) Visual editor
 */

	/**
	 * TinyMCE "Formats" dropdown alteration
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  array $formats
	 */
	function firefly_custom_mce_format( $formats ) {

		// Processing

			// Adding font weight classes

				$font_weights = array(

						// Font weight names from https://developer.mozilla.org/en/docs/Web/CSS/font-weight

						100 => esc_html__( 'Thin (hairline) text', 'firefly' ),
						200 => esc_html__( 'Extra light text', 'firefly' ),
						300 => esc_html__( 'Light text', 'firefly' ),
						400 => esc_html__( 'Normal weight text', 'firefly' ),
						500 => esc_html__( 'Medium text', 'firefly' ),
						600 => esc_html__( 'Semi bold text', 'firefly' ),
						700 => esc_html__( 'Bold text', 'firefly' ),
						800 => esc_html__( 'Extra bold text', 'firefly' ),
						900 => esc_html__( 'Heavy text', 'firefly' ),

					);

				$formats[ 250 . 'text_weights' ] = array(
						'title' => esc_html__( 'Text weights', 'firefly' ),
						'items' => array(),
					);

				foreach ( $font_weights as $weight => $name ) {

					$formats[ 250 . 'text_weights' ]['items'][ 250 . 'text_weights' . $weight ] = array(
							'title'    => $name . ' (' . $weight . ')',
							'selector' => 'h1, h2, h3, h4, h5, h6, p',
							'classes'  => 'weight-' . $weight,
						);

				} // /foreach


		// Output

			return $formats;

	} // /firefly_custom_mce_format

	add_action( 'wmhook_firefly_tf_editor_custom_mce_format', 'firefly_custom_mce_format' );





/**
 * 999) Plugins integration
 */

	// WebMan Amplifier integration

		locate_template( 'includes/plugins/webman-amplifier/webman-amplifier.php', true );

	// Advanced Custom Fields integration

		locate_template( 'includes/plugins/advanced-custom-fields/advanced-custom-fields.php', true );

	// Beaver Builder integration

		locate_template( 'includes/plugins/beaver-builder/beaver-builder.php', true );

	// Breadcrumb NavXT integration

		locate_template( 'includes/plugins/breadcrumb-navxt/breadcrumb-navxt.php', true );

	// Jetpack integration

		locate_template( 'includes/plugins/jetpack/jetpack.php', true );

	// Smart Slider 3 integration

		locate_template( 'includes/plugins/smart-slider/smart-slider.php', true );

	// Subtitles integration

		locate_template( 'includes/plugins/subtitles/subtitles.php', true );

	// WooSidebars integration

		locate_template( 'includes/plugins/woosidebars/woosidebars.php', true );
