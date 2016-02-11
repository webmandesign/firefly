<?php
/**
 * Plugin integration
 *
 * WebMan Amplifier
 *
 * @link  https://wordpress.org/plugins/webman-amplifier/
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

	if ( ! class_exists( 'WM_Amplifier' ) ) {
		return;
	}





/**
 * 10) Plugin integration
 */

	// Metaboxes

		add_filter( 'wmhook_metabox_visual_wrapper_toggle', '__return_true' );



	/**
	 * Plugin setup
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_amplifier_setup() {

		// Processing

			// Plugin features

				add_theme_support( 'webman-amplifier', array(
						'cp-modules',
						'cp-staff',
						'cp-testimonials',
						'widget-contact',
						'widget-subnav',
						'disable-isotope-notice',
						'disable-visual-composer-support'
					) );

			// Post types support

				add_post_type_support(
						'wm_staff',
						array(
							'excerpt',
							'custom-fields',
						)
					);

	} // /firefly_amplifier_setup

	add_action( 'after_setup_theme', 'firefly_amplifier_setup' );





	/**
	 * CUSTOM POSTS
	 */

		/**
		 * Custom posts types redirects
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		function firefly_amplifier_redirects() {

			// Helper variables

				$get_post_type = get_post_type( get_the_ID() );

				$link = get_page_by_path( wma_meta_option( 'link-page', get_the_ID() ) );

				if ( is_object( $link ) && is_callable( array( $link, 'ID' ) ) ) {
					$link = get_permalink( $link->ID );
				} else {
					$link = wma_meta_option( 'link', get_the_ID() );
				}

				$redirects = array(
						'wm_logos'        => esc_url( home_url( '/' ) ),
						'wm_modules'      => ( $link ) ? ( esc_url( $link ) ) : ( esc_url( home_url( '/' ) ) ),
						'wm_testimonials' => esc_url( home_url( '/' ) ),
					);


			// Processing

				if ( in_array( $get_post_type, array_keys( $redirects ) ) ) {
					wp_redirect( $redirects[ $get_post_type ], 301 );
					exit;
				}

		} // /firefly_amplifier_redirects

		add_action( 'template_redirect', 'firefly_amplifier_redirects' );



		/**
		 * STAFF
		 */

			/**
			 * Custom posts type setup: Staff
			 *
			 * @since    1.0
			 * @version  1.0
			 */
			function firefly_amplifier_wm_staff_args( $args ) {

				// Processing

					$args['exclude_from_search'] = false;
					$args['show_in_nav_menus']   = true;
					// $args['taxonomies']          = array( 'post_tag' );


				// Output

					return $args;

			} // /firefly_amplifier_wm_staff_args

			add_action( 'wmhook_wmamp_cp_register_wm_staff', 'firefly_amplifier_wm_staff_args' );



			/**
			 * Custom posts type content: Staff
			 *
			 * @since    1.0
			 * @version  1.0
			 */
			function firefly_amplifier_wm_staff_content( $type ) {

				// Processing

					if ( 'wm_staff' == get_post_type( get_the_ID() ) ) {
						return 'staff';
					}


				// Output

					return $type;

			} // /firefly_amplifier_wm_staff_content

			add_action( 'wmhook_firefly_loop_content_type', 'firefly_amplifier_wm_staff_content' );



			/**
			 * Entry container attributes
			 *
			 * @since    1.0
			 * @version  1.0
			 *
			 * @param  string $atts  Already set container HTML atts.
			 */
			function firefly_amplifier_entry_container_atts( $atts ) {

				// Processing

					if ( 'wm_staff' == get_post_type( get_the_ID() ) ) {
						$atts = firefly_schema_org( 'Person' );
					}


				// Output

					return (string) $atts;

			} // /firefly_amplifier_entry_container_atts

			add_filter( 'wmhook_firefly_entry_container_atts', 'firefly_amplifier_entry_container_atts', 20 );





	/**
	 * SHORTCODES
	 */

		/**
		 * Supported shortcodes version
		 *
		 * Use this to declare the plugin version that your theme supports.
		 * It is possible that in future versions of the plugin there will be more
		 * shortcodes added and your theme might not suppot them out of the box.
		 * Setting this version number will make sure only the shortcodes included
		 * with the specific plugin version will be available to your theme users.
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		function firefly_amplifier_supported_shortcode_until_version() {

			// Output

				return '1.1';

		} // /firefly_amplifier_supported_shortcode_until_version

		add_filter( 'wmhook_shortcode_supported_version', 'firefly_amplifier_supported_shortcode_until_version' );



		/**
		 * Modifying shortcodes globals
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		function firefly_amplifier_shortcodes_globals( $array ) {

			// Processing

				// Color names

					$array['colors'] = array(

							// Adding empty value for default settings

								'' => '',

							// Global predefined colors

								'success' => esc_html_x( 'Success', 'Generalized, abstract color name.', 'firefly' ),
								'info'    => esc_html_x( 'Info', 'Generalized, abstract color name.', 'firefly' ),
								'warning' => esc_html_x( 'Warning', 'Generalized, abstract color name.', 'firefly' ),
								'error'   => esc_html_x( 'Error', 'Generalized, abstract color name.', 'firefly' ),
								'neutral' => esc_html_x( 'Neutral', 'Generalized, abstract color name.', 'firefly' ),

						);

				// Sizes (adding empty size for default value)

					array_unshift( $array['sizes']['options'], '' );


			// Output

				return $array;

		} // /firefly_amplifier_shortcodes_globals

		add_filter( 'wmhook_shortcode_codes_globals', 'firefly_amplifier_shortcodes_globals' );



		/**
		 * Prefix custom modules names
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  array  $output
		 * @param  string $shortcode
		 */
		function firefly_amplifier_module_name_prefix( $output, $shortcode ) {

			// Processing

				if ( '-' !== $output['name'] ) {
					$output['name'] = 'WM ' . $output['name'];
				}


			// Output

				return $output;

		} // /firefly_amplifier_module_name_prefix

		add_filter( 'wmhook_shortcode_wma_bb_shortcode_def_output', 'firefly_amplifier_module_name_prefix', 10, 2 );



		/**
		 * Modifying shortcodes definitions and removing obsolete shortcodes
		 *
		 * @uses  unset() - no need to check for isset()
		 * @link  http://php.net/manual/en/function.unset.php#72389
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  array $definitions
		 */
		function firefly_amplifier_shortcodes_definitions( $definitions ) {

			// Processing

				// Removing obsolete shortcodes

					// WebMan Amplifier native

						unset( $definitions['audio'] );
						unset( $definitions['column'] );
						unset( $definitions['countdown_timer'] );
						unset( $definitions['dropcap'] );
						unset( $definitions['icon'] );
						unset( $definitions['list'] );
						unset( $definitions['pre'] );
						unset( $definitions['price'] );
						unset( $definitions['pricing_table'] );
						unset( $definitions['progress'] );
						unset( $definitions['row'] );
						unset( $definitions['search_form'] );
						unset( $definitions['separator_heading'] );
						unset( $definitions['slideshow'] );
						unset( $definitions['video'] );
						unset( $definitions['widget_area'] );

					// Visual Composer related

						unset( $definitions['image'] );
						unset( $definitions['text_block'] );
						unset( $definitions['vc_row'] );
						unset( $definitions['vc_row_inner'] );
						unset( $definitions['vc_column'] );
						unset( $definitions['vc_column_inner'] );

					// Others

						unset( $definitions['soliloquy'] );
						unset( $definitions['masterslider'] );

				// Modifying definitions

					// Content Module

						unset( $definitions['content_module']['bb_plugin']['form']['general']['sections']['multiple']['fields']['pagination'] );
						unset( $definitions['content_module']['bb_plugin']['form']['description'] );
						unset( $definitions['content_module']['bb_plugin']['form']['others']['sections']['general']['fields']['layout'] );

					// Posts

						unset( $definitions['posts']['bb_plugin']['form']['others']['sections']['general']['fields']['related'] );
						unset( $definitions['posts']['bb_plugin']['form']['others']['sections']['general']['fields']['filter_layout'] );
						unset( $definitions['posts']['bb_plugin']['form']['description'] );

					// Table

						unset( $definitions['table']['bb_plugin']['form']['general']['sections']['general']['fields']['appearance'] );

					// Testimonials

						unset( $definitions['testimonials']['bb_plugin']['form']['description'] );
						unset( $definitions['testimonials']['bb_plugin']['form']['others']['sections']['general']['fields']['no_margin'] );


			// Output

				return $definitions;

		} // /firefly_amplifier_shortcodes_definitions

		add_filter( 'wmhook_shortcode_definitions', 'firefly_amplifier_shortcodes_definitions' );



		/**
		 * Shortcodes atts: forced
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  array  $atts
		 * @param  string $shortcode
		 */
		function firefly_amplifier_shortcodes_atts( $atts, $shortcode ) {

			// Processing

				switch ( $shortcode ) {
					case 'call_to_action':

						// Call to action button class

							$atts['button_class'] = 'button';

					break;

					case 'content_module':

						// Isotope - force masonry layout (default is `fitRows`)

							$atts['filter_layout'] = 'masonry';

					break;

					case 'posts':

						// Isotope - force masonry layout (default is `fitRows`)

							$atts['filter_layout'] = 'masonry';

						// Staff image size

							if (
									isset( $atts['post_type'] )
									&& 'wm_staff' === $atts['post_type']
								) {
								$atts['image_size'] = 'firefly-square';
							}

					break;

					default:
					break;
				}


			// Output

				return $atts;

		} // /firefly_amplifier_shortcodes_atts

		add_filter( 'wmhook_shortcode__attributes', 'firefly_amplifier_shortcodes_atts', 10, 2 );



		/**
		 * Button class
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  string $classes
		 */
		function firefly_amplifier_button_class( $classes ) {

			// Output

				return $classes . ' button';

		} // /firefly_amplifier_button_class

		add_filter( 'wmhook_shortcode_button_classes', 'firefly_amplifier_button_class' );



		/**
		 * Content Module default layout
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  string $layouts
		 */
		function firefly_amplifier_content_module_layout( $layouts ) {

			// Output

				return array(
						'wm_modules' => array( 'image', 'title', 'content' ), // Removing default "more link"
					);

		} // /firefly_amplifier_content_module_layout

		add_filter( 'wmhook_shortcode_content_module_layouts', 'firefly_amplifier_content_module_layout' );



		/**
		 * Posts class
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  string $classes
		 */
		function firefly_amplifier_posts_class( $classes ) {

			// Output

				return $classes . ' posts';

		} // /firefly_amplifier_posts_class

		add_filter( 'wmhook_shortcode_posts_classes', 'firefly_amplifier_posts_class' );



		/**
		 * Posts shortcode default image size
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		function firefly_amplifier_posts_image_size() {

			// Output

				return 'thumbnail'; // default is 'medium'

		} // /firefly_amplifier_posts_image_size

		add_filter( 'wmhook_shortcode_posts_image_size', 'firefly_amplifier_posts_image_size' );



		/**
		 * Posts shortcode item class and link
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  array  $helper
		 * @param  absint $post_id
		 */
		function firefly_amplifier_posts_item_class( $helper, $post_id ) {

			// Processing

				// Class

					if (
							isset( $helper['item_class'] )
							&& has_post_thumbnail( $post_id )
						) {
						$helper['item_class'] .= ' has-thumbnail';
					}

				// Link

					if ( isset( $helper['link'] ) ) {
						$helper['link'] = str_replace( 'data-target="modal"', 'rel="lightbox"', $helper['link'] );
					}


			// Output

				return $helper;

		} // /firefly_amplifier_posts_item_class

		add_filter( 'wmhook_shortcode_posts_helper', 'firefly_amplifier_posts_item_class', 10, 2 );



		/**
		 * Testimonials shortcode default image size
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		function firefly_amplifier_testimonials_image_size() {

			// Output

				return 'firefly-square'; // default is 'thumbnail'

		} // /firefly_amplifier_testimonials_image_size

		add_filter( 'wmhook_shortcode_testimonials_image_size', 'firefly_amplifier_testimonials_image_size' );



		/**
		 * Testimonials shortcode item class
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  string $classes
		 * @param  absint $post_id
		 */
		function firefly_amplifier_testimonials_item_class( $classes, $post_id ) {

			// Processing

				if ( has_post_thumbnail( $post_id ) ) {
					$classes .= ' has-thumbnail';
				}


			// Output

				return $classes;

		} // /firefly_amplifier_testimonials_item_class

		add_filter( 'wmhook_shortcode_testimonials_item_class', 'firefly_amplifier_testimonials_item_class', 10, 2 );



		/**
		 * Content Module shortcode
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  array  $layout_elements
		 * @param  absint $post_id
		 * @param  array  $helpers
		 * @param  array  $atts
		 */
		function firefly_amplifier_content_module_layout_elements( $layout_elements, $post_id, $helpers, $atts  ) {

			// Helper variables

				$layout_element_last = '';


			// Processing

				// Icon + image

					$image_class = ( has_post_thumbnail( $post_id ) ) ? ( ' has-thumbnail' ) : ( ' has-not-thumbnail' );

					$icon  = array(
							'font'             => wma_meta_option( 'icon-font', $post_id ),
							'color'            => wma_meta_option( 'icon-color', $post_id ),
							'color-background' => wma_meta_option( 'icon-color-background', $post_id ),
						);

					$image_size = ( $atts['image_size'] ) ? ( $atts['image_size'] ) : ( 'medium' );

					if ( $icon['font'] ) {
						$image_size = 'firefly-square';
					}

					$image = get_the_post_thumbnail(
							$post_id,
							$image_size,
							array( 'title' => esc_attr( get_the_title( get_post_thumbnail_id( $post_id ) ) ) )
						);

					$style_icon = $style_container = '';

					if ( $icon['font'] && $icon['color'] ) {
						$style_icon   = ' style="color: ' . $icon['color'] . '"';
						$image_class .= ' color-text';
					}

					if ( $icon['font'] && $icon['color-background'] ) {
						$style_container = ' style="background-color: ' . $icon['color-background'] . '"';
						$image_class    .= ' color-background';

						if ( $image ) {
							$image .= '<span class="overlay"></span>';
						}
					}

					if ( $icon['font'] ) {
						if (
								$image
								&& ! empty( $atts['layout'] )
								&& is_array( $atts['layout'] )
							) {
							end( $atts['layout'] );
							$layout_element_last = key( $atts['layout'] );
						}

						$image       .= '<i class="' . $icon['font'] . '"' . $style_icon . '></i>';
						$image_class .= ' has-icon';
					}

					if ( $image && $helpers['link'] ) {
						$image = '<a' .  $helpers['link'] . '>' . $image . '</a>';
					}

					if ( $image ) {
						$layout_elements['image'] = '<div class="wm-content-module-element wm-html-element image image-container' . $image_class . '"' . $style_container . '>' . $image . '</div>';

						if ( $layout_element_last ) {
							$layout_elements['image'] .= '<div class="wm-content-module-elements-wrapper"><div class="wm-content-module-elements-wrapper-inner">';
							$layout_elements[ $layout_element_last ] .= '</div></div><!-- /wm-content-module-elements-wrapper -->';
						}
					}


			// Output

				return $layout_elements;

		} // /firefly_amplifier_content_module_layout_elements

		add_filter( 'wmhook_shortcode_content_module_layout_elements', 'firefly_amplifier_content_module_layout_elements', 10, 4 );





	/**
	 * METABOXES
	 */

		/**
		 * Content Modules metabox
		 */

			/**
			 * Content Modules fields alteration
			 *
			 * @since    1.0
			 * @version  1.0
			 *
			 * @param  array $fields
			 */
			function firefly_amplifier_content_modules_metafields( $fields = array() ) {

				//Processing

					unset( $fields[1060] ); // removes 'icon-box' option

					// Change labels and set additinal conditionals

						$fields[1240]['label'] = __( 'Icon', 'firefly' );
						$fields[1260]['label'] = __( 'Icon color', 'firefly' );

						$fields[1280]['conditional'] = $fields[1260]['conditional'];

					// Move icon color before the icon selection

						$fields[1200] = $fields[1260]; // also removes icon setup wrapper opening
						$fields[1220] = $fields[1280]; // also removes featured image setup notice
						unset( $fields[1260] ); // remove original icon color setup position
						unset( $fields[1280] ); // remove original icon background color setup position

					unset( $fields[1480] ); // removes icon setup wrapper closing


				// Output

					return $fields;

			} // /firefly_amplifier_content_modules_metafields

			add_filter( 'wmhook_wmamp_cp_metafields_wm_modules', 'firefly_amplifier_content_modules_metafields' );





	/**
	 * ICON FONT
	 */

		/**
		 * Default icon font CSS file URL
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		function firefly_amplifier_iconfont_css_url() {

			// Output

				return Firefly_Theme_Framework::get_stylesheet_directory_uri( 'assets/fonts/fontello/fontello.css' );

		} // /firefly_amplifier_iconfont_css_url

		add_filter( 'wmhook_icons_default_iconfont_css_url', 'firefly_amplifier_iconfont_css_url' );



		/**
		 * Default icons config array file path
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		function firefly_amplifier_iconfont_config_path() {

			// Output

				return Firefly_Theme_Framework::get_stylesheet_directory( 'assets/fonts/fontello/config.php' );

		} // /firefly_amplifier_iconfont_config_path

		add_filter( 'wmhook_icons_default_iconfont_config_path', 'firefly_amplifier_iconfont_config_path' );





	/**
	 * FUNCTIONS MODIFICATIONS
	 */

		/**
		 * Adding `pagination` CSS class
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  string $output
		 */
		function firefly_amplifier_pagination( $output ) {

			// Output

				return str_replace( 'wm-pagination', 'wm-pagination pagination', $output );

		} // /firefly_amplifier_pagination

		add_filter( 'wmhook_wmamp_wma_pagination_output', 'firefly_amplifier_pagination' );
