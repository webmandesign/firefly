<?php
/**
 * Plugin integration
 *
 * Beaver Builder
 *
 * @link  https://www.wpbeaverbuilder.com/
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

	if ( ! class_exists( 'FLBuilder' ) ) {
		return;
	}





/**
 * 10) Plugin integration
 */

	// Make sure to load layout styles after the theme stylesheet

		remove_action( 'wp_enqueue_scripts', 'FLBuilder::enqueue_layout_styles_scripts' );
		remove_action( 'wp_enqueue_scripts', 'FLBuilder::enqueue_ui_styles_scripts' );
		add_action( 'wp_enqueue_scripts', 'FLBuilder::enqueue_layout_styles_scripts', 198 );
		add_action( 'wp_enqueue_scripts', 'FLBuilder::enqueue_ui_styles_scripts', 198 );



	/**
	 * Is page builder used on the post?
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_bb_is_active() {

		// Requirements check

			if ( ! class_exists( 'FLBuilderModel' ) ) {
				return false;
			}


		// Processing

			if ( firefly_is_singular() ) {
				return ( FLBuilderModel::is_builder_active() || get_post_meta( get_the_ID(), '_fl_builder_enabled', true ) );
			}


		// Output

			return false;

	} // /firefly_bb_is_active



	/**
	 * Disable title when builder used
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  mixed $pre
	 */
	function firefly_bb_disable_post_title( $pre ) {

		// Helper variables

			$meta_no_title = get_post_meta( get_the_ID(), 'no_title', true );


		// Processing

			if (
					(
						is_page_template( 'templates/no-title.php' )
						|| ! empty( $meta_no_title )
					)
					&& firefly_bb_is_active()
				) {
				return '';
			}


		// Output

			return $pre;

	} // /firefly_bb_disable_post_title

	add_filter( 'wmhook_fn_firefly_post_title_pre', 'firefly_bb_disable_post_title', 10 );



	/**
	 * Upgrade link URL
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  string $url
	 */
	function firefly_bb_upgrade_url( $url ) {

		// Output

			return esc_url( add_query_arg( 'fla', '67', $url ) );

	} // /firefly_bb_upgrade_url

	add_filter( 'fl_builder_upgrade_url', 'firefly_bb_upgrade_url' );



	/**
	 * Styles and scripts
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_bb_assets() {

		// Helper variables

			$theme = Firefly_Theme_Framework::get_theme_slug();


		// Processing

			/**
			 * Styles
			 */

				if ( class_exists( 'FLBuilderModel' ) && FLBuilderModel::is_builder_active() ) {

					wp_enqueue_style(
							'firefly-bb-addon',
							Firefly_Theme_Framework::get_stylesheet_directory_uri( 'assets/css/beaver-builder-editor.css' ),
							false,
							esc_attr( trim( wp_get_theme( $theme )->get( 'Version' ) ) ),
							'screen'
						);

				}

	} // /firefly_bb_assets

	add_action( 'wp_enqueue_scripts', 'firefly_bb_assets' );



	/**
	 * Global settings
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  array  $defaults
	 * @param  string $form_type
	 */
	function firefly_bb_global_settings( $defaults, $form_type ) {

		// Processing

			if ( 'global' === $form_type ) {

				// "Default Page Heading" section

					$defaults->show_default_heading     = 1;
					$defaults->default_heading_selector = '.intro-container';

				// "Rows" section

					$defaults->row_padding       = 0;
					$defaults->row_width         = $GLOBALS['content_width']; // This will get overriden via custom CSS
					$defaults->row_width_default = 'full';

				// "Modules" section

					$defaults->module_margins = 0;

				// "Responsive Layout" section

					$defaults->medium_breakpoint     = 960;
					$defaults->responsive_breakpoint = 680;

			}


		// Output

			return $defaults;

	} // /firefly_bb_global_settings

	add_filter( 'fl_builder_settings_form_defaults', 'firefly_bb_global_settings', 10, 2 );



	/**
	 * Theme color scheme to color presets
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  array  $defaults
	 * @param  string $form_type
	 *
	 * @todo  See @link https://www.wpbeaverbuilder.com/support/q/beta-test-version-1-6-4-of-the-beaver-builder-plugin/page/2/#post-44892
	 */
	function firefly_bb_color_presets() {

		// Helper variables

			$option_name = '_fl_builder_color_presets';

			$color_presets = get_option( $option_name );

			$theme_defaults = array(
					'accent'                => '008768',
					'error_background'      => 'e10000',
					'info_background'       => '0577b9',
					'neutral_background'    => 'dadcde',
					'success_background'    => '008768',
					'warning_background'    => 'ff924f',
					'navigation_background' => '0577b9',
					'navigation_border'     => '5799db',
				);

			$theme_custom = array();

			foreach ( $theme_defaults as $option => $value ) {
				if ( $custom_color = get_theme_mod( 'color_' . $option ) ) {
					$theme_custom[ $option ] = $custom_color;
				}
			} // /foreach

			$color_presets_theme = wp_parse_args( $theme_custom, $theme_defaults );


		// Processing

			if ( empty( $color_presets ) ) {

				update_option(
					$option_name,
					(array) $color_presets_theme
				);

			} else {

				update_option(
					$option_name,
					array_filter(
						array_unique(
							array_values(
								array_merge(
									(array) $color_presets,
									(array) $color_presets_theme
								)
							)
						)
					)
				);

			}

	} // /firefly_bb_color_presets

	// add_action( 'wmhook_firefly_tf_generate_main_css', 'firefly_bb_color_presets' );



	/**
	 * Deregister / disable modules
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  bool   $enabled
	 * @param  object $instance
	 */
	function firefly_bb_deregister_modules( $enabled, $instance ) {

		// Requirements check

			if ( get_theme_mod( 'others_beaver_builder_all_modules' ) ) {
				return $enabled;
			}


		// Helper variables

			$deregister = array(

					// Replaced with WebMan Amplifier shortcodes

						'accordion',
						// 'button',
						'callout',
						'cta',
						'content-slider',
						'post-grid',
						'post-carousel',
						'separator',
						// 'subscribe-form', // this has to be deregistered as it uses the native Button module
						'tabs',
						'testimonials',

					// Obsolete

						'gallery',
						// 'pricing-table',
						'slideshow',
						'social-buttons',

				);


		// Processing

			// Move custom modules into Advanced group (hook onto WebMan Amplifier plugin)

				// add_filter( 'wmhook_shortcode_wma_bb_shortcode_def_category_advanced', '__return_true' );


		// Output

			if ( in_array( $instance->slug, $deregister ) ) {
				return false;
			}

			return $enabled;

	} // /firefly_bb_deregister_modules

	add_filter( 'fl_builder_register_module', 'firefly_bb_deregister_modules', 10, 2 );



	/**
	 * Modify row class
	 *
	 * Requires Beaver Builder 1.5.1+
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  string $class
	 * @param  object $row
	 */
	function firefly_bb_row_class( $class, $row ) {

		// Processing

			// Row layout

				$class .= ' row-layout-' . $row->settings->width . '-' . $row->settings->content_width;

			// Custom background class

				if (
						! empty( $row->settings->bg_color )
						|| ! empty( $row->settings->bg_image )
						|| stripos( ' ' . $row->settings->class, 'set-colors-' ) // Search for custom colors special class
					) {

					$class .= ' custom-row-background';

				}


		// Output

			return $class;

	} // /firefly_bb_row_class

	add_filter( 'fl_builder_row_custom_class', 'firefly_bb_row_class', 10, 2 );



	/**
	 * Modify column class
	 *
	 * Requires Beaver Builder 1.5.1+
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  string $class
	 * @param  object $col
	 */
	function firefly_bb_column_class( $class, $col ) {

		// Processing

			// Custom background class

				if (
						! empty( $col->settings->bg_color )
						|| ! empty( $col->settings->bg_image )
						|| stripos( ' ' . $col->settings->class, 'set-colors-' ) // Search for custom colors special class
					) {

					$class .= ' custom-column-background';

				}

			// Column width

				switch ( $col->settings->size ) {

					case '100':
						$class .= ' fl-col-width-1-1';

						if (
								'0' === $col->settings->padding_top
								&& '0' === $col->settings->padding_bottom
								&& '0' === $col->settings->padding_left
								&& '0' === $col->settings->padding_right
							) {
							$class .= ' no-padding';
						}
					break;

					case '50':
						$class .= ' fl-col-width-1-2';
					break;

					case '33.33':
					case '33.34':
						$class .= ' fl-col-width-1-3';
					break;

					case '66.66':
					case '66.67':
						$class .= ' fl-col-width-2-3';
					break;

					// Adding golden ratio support

						case '38':
						case '38.20':
							$class .= ' fl-col-width-1-3 fl-col-width-golden-minor';
						break;

						case '61.80':
						case '62':
							$class .= ' fl-col-width-2-3 fl-col-width-golden-major';
						break;

					case '25':
						$class .= ' fl-col-width-1-4';
					break;

					case '75':
						$class .= ' fl-col-width-3-4';
					break;

					case '20':
						$class .= ' fl-col-width-1-5';
					break;

					case '16.65':
					case '16.66':
					case '16.67':
					case '16.68':
					case '16.75':
						$class .= ' fl-col-width-1-6';
					break;

					default:
						$class .= ' fl-col-width-custom';
					break;

				}


		// Output

			return $class;

	} // /firefly_bb_column_class

	add_filter( 'fl_builder_column_custom_class', 'firefly_bb_column_class', 10, 2 );



	/**
	 * Modify module class
	 *
	 * Requires Beaver Builder 1.5.1+
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  string $class
	 * @param  object $col
	 */
	function firefly_bb_module_class( $class, $module ) {

		// Processing

			if (
					'wm_divider' == $module->settings->type
					&& ! (
							is_numeric( $module->settings->margin_top )
							|| is_numeric( $module->settings->margin_bottom )
						)
				) {

				$class .= ' default-margin';

			}


		// Output

			return $class;

	} // /firefly_bb_module_class

	add_filter( 'fl_builder_module_custom_class', 'firefly_bb_module_class', 10, 2 );



	/**
	 * Add predefined classes helper dropdown
	 *
	 * Requires Beaver Builder 1.6.5+
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  array $field
	 * @param  name  $name
	 */
	function firefly_bb_predefined_classes_dropdown( $field, $name ) {

		// Processing

			if ( 'class' == $name ) {

				$field['options'] = array(

						'' => esc_html__( '- Choose from predefined classes -', 'firefly' ),

						// Posts list classes

							'optgroup-posts' => array(
								'label'   => esc_html__( 'Posts list classes:', 'firefly' ),
								'options' => array(

									'masonry'      => esc_html__( 'Masonry items layout', 'firefly' ),
									'bordered'     => esc_html__( 'Border around items', 'firefly' ),

									'hide-media'   => esc_html__( 'Posts: Hide media (featured images, video and audio players)', 'firefly' ),

									'hide-excerpt' => esc_html__( 'Staff: Hide excerpt', 'firefly' ),

									'inline'       => esc_html__( 'Content Module: Inline icon box layout', 'firefly' ),
									'hide-title'   => esc_html__( 'Content Module: Hide title', 'firefly' ),

								),
							),

						// Layout classes

							'optgroup-layout' => array(
								'label'   => esc_html__( 'Layout classes:', 'firefly' ),
								'options' => array(

									'text-center'       => esc_html__( 'Text center', 'firefly' ),
									'text-right'        => esc_html__( 'Text right', 'firefly' ),

									'fullwidth'         => esc_html__( 'Make elements fullwidth', 'firefly' ),

									'center-vertically' => esc_html__( 'Center row or column content vertically', 'firefly' ),

									'last'              => esc_html__( 'Force column as last', 'firefly' ),
									'first'             => esc_html__( 'Force column as first', 'firefly' ),

									'sidebar'           => esc_html__( 'Apply sidebar layout', 'firefly' ),

								),
							),

						// Color classes

							'optgroup-color' => array(
								'label'   => esc_html__( 'Color classes:', 'firefly' ),
								'options' => array(

									'set-colors-error'               => esc_html__( 'Set error colors', 'firefly' ),
									'set-colors-info'                => esc_html__( 'Set info colors', 'firefly' ),
									'set-colors-neutral'             => esc_html__( 'Set neutral colors', 'firefly' ),
									'set-colors-success'             => esc_html__( 'Set success colors', 'firefly' ),
									'set-colors-warning'             => esc_html__( 'Set warning colors', 'firefly' ),

									'set-colors-accent'              => esc_html__( 'Set accent colors', 'firefly' ),
									'set-colors-header'              => esc_html__( 'Set header colors', 'firefly' ),
									'set-colors-navigation'          => esc_html__( 'Set navigation colors', 'firefly' ),
									'set-colors-header-info-widgets' => esc_html__( 'Set header info widgets colors', 'firefly' ),
									'set-colors-content'             => esc_html__( 'Set content colors', 'firefly' ),
									'set-colors-sidebar'             => esc_html__( 'Set sidebar colors', 'firefly' ),
									'set-colors-footer'              => esc_html__( 'Set footer colors', 'firefly' ),
									'set-colors-footer-info-widgets' => esc_html__( 'Set footer info widgets colors', 'firefly' ),
									'set-colors-credits'             => esc_html__( 'Set footer credits colors', 'firefly' ),

									'hover-color-error'              => esc_html__( 'Hover error', 'firefly' ),
									'hover-color-info'               => esc_html__( 'Hover info', 'firefly' ),
									'hover-color-neutral'            => esc_html__( 'Hover neutral', 'firefly' ),
									'hover-color-success'            => esc_html__( 'Hover success', 'firefly' ),
									'hover-color-warning'            => esc_html__( 'Hover warning', 'firefly' ),

								),
							),

						// Button classes

							'optgroup-button' => array(
								'label'   => esc_html__( 'Button classes:', 'firefly' ),
								'options' => array(

									'simple'             => esc_html__( 'Simple button, inherit text color', 'firefly' ),
									'simple dark'        => esc_html__( 'Simple button, dark', 'firefly' ),
									'simple light'       => esc_html__( 'Simple button, light', 'firefly' ),
									'form-button-simple' => esc_html__( 'Force simple submit button in form', 'firefly' ),

								),
							),

						// Widget classes

							'optgroup-widget' => array(
								'label'   => esc_html__( 'Widget classes:', 'firefly' ),
								'options' => array(

									'hide-widget-title'            => esc_html__( 'Hide widget title', 'firefly' ),
									'hide-widget-title-accessible' => esc_html__( 'Hide widget title accessibly', 'firefly' ),

								),
							),

					);

			}


		// Output

			return $field;

	} // /firefly_bb_predefined_classes_dropdown

	add_filter( 'fl_builder_render_settings_field', 'firefly_bb_predefined_classes_dropdown', 10, 2 );



	/**
	 * Layout stylesheet modifications
	 */

		/**
		 * Layout stylesheet media
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		function firefly_bb_stylesheet_layout_media() {

			// Output

				return 'screen';

		} // /firefly_bb_stylesheet_layout_media

		add_filter( 'fl_builder_layout_style_media', 'firefly_bb_stylesheet_layout_media' );



		/**
		 * Layout stylesheet media
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  string $css
		 * @param  array  $nodes
		 * @param  object $global_settings
		 */
		function firefly_bb_stylesheet_layout( $css, $nodes, $global_settings ) {

			// Processing

				$css .= ' /* Theme modifications: start */ ';

				// Columns

					foreach( $nodes['columns'] as $col ) {

						// Background

							// Color

								if ( $col->settings->bg_type == 'color' && ! empty( $col->settings->bg_color ) ) {
									$css .= "\r\n" . '.fl-node-' . $col->node . ' {';
									$css .= '  background-color: #' . $col->settings->bg_color . ';';
									$css .= '  background-color: rgba(' . implode( ',', FLBuilderColor::hex_to_rgb( $col->settings->bg_color ) ) . ', ' . ( $col->settings->bg_opacity / 100 ) . ');';
									$css .= '}';
								}

							// Image

								if ( $col->settings->bg_type == 'photo' && ! empty( $col->settings->bg_image ) ) {
									$css .= "\r\n" . '.fl-node-' . $col->node . ' {';
									$css .= '  background-image: url(' . $col->settings->bg_image_src . ');';
									$css .= '  background-repeat: ' . $col->settings->bg_repeat . ';';
									$css .= '  background-position: ' . $col->settings->bg_position . ';';
									$css .= '  background-attachment: ' . $col->settings->bg_attachment . ';';
									$css .= '  background-size: ' . $col->settings->bg_size . ';';
									$css .= '}';
								}

							// Border

								if ( ! empty( $col->settings->border_type ) ) {
									$css .= "\r\n" . '.fl-node-' . $col->node . ' {';
									$css .= '  border-style: ' . $col->settings->border_type . ';';
									$css .= '  border-color: #' . $col->settings->border_color . ';';
									$css .= '  border-color: rgba(' . implode( ',', FLBuilderColor::hex_to_rgb( $col->settings->border_color ) ) . ', ' . ( $col->settings->border_opacity / 100 ) . ');';
									$css .= '  border-top-width: ' . ( is_numeric( $col->settings->border_top ) ? ( $col->settings->border_top ) : ( '0' ) ) . 'px;';
									$css .= '  border-bottom-width: ' . ( is_numeric( $col->settings->border_bottom ) ? ( $col->settings->border_bottom ) : ( '0' ) ) . 'px;';
									$css .= '  border-left-width: ' . ( is_numeric( $col->settings->border_left ) ? ( $col->settings->border_left ) : ( '0' ) ) . 'px;';
									$css .= '  border-right-width: ' . ( is_numeric( $col->settings->border_right ) ? ( $col->settings->border_right ) : ( '0' ) ) . 'px;';
									$css .= '}';
								}

							// Margins

								$margins = '';

								if ( is_numeric( $col->settings->margin_top ) ) {
									$margins .= ' margin-top: ' . intval( $col->settings->margin_top ) . 'px;';
								}
								if ( is_numeric( $col->settings->margin_bottom ) ) {
									$margins .= ' margin-bottom: ' . intval( $col->settings->margin_bottom ) . 'px;';
								}
								if ( is_numeric( $col->settings->margin_left ) ) {
									$margins .= ' margin-left: ' . intval( $col->settings->margin_left ) . 'px;';
								}
								if ( is_numeric( $col->settings->margin_right ) ) {
									$margins .= ' margin-right: ' . intval( $col->settings->margin_right ) . 'px;';
								}
								if ( ! empty( $margins ) ) {
									$css .= '.fl-node-' . $col->node . ' {' . $margins . ' }';
								}

					} // /foreach

					// Applying global resets
					// Need to do it here as it is dependent on the above, while the filter was added in Beaver Builder v1.6.4.

					$css .= ' .fl-row .fl-col-group .fl-col-content { background: none; margin: 0; border: 0; border-color: inherit; }';

				$css .= ' /* Theme modifications: end */ ';


			// Output

				return $css;

		} // /firefly_bb_stylesheet_layout

		add_filter( 'fl_builder_render_css', 'firefly_bb_stylesheet_layout', 10, 3 );
