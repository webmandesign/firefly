<?php
/**
 * Customizer CSS generator
 *
 * @uses  `wmhook_firefly_esc_css` global hook
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 */





/**
 * Output Customizer styles
 *
 * @since    1.0
 * @version  1.0
 *
 * @param  boolean $visual_editor If true, will output styles for WordPress Visual Editor only.
 */
function firefly_custom_styles( $visual_editor = false ) {

	// Pre

		$pre = apply_filters( 'wmhook_fn_firefly_custom_styles_pre', false, $visual_editor );

		if ( false !== $pre ) {
			return $pre;
		}


	// Helper variables

		$output        = '';
		$custom_styles = $helper_custom = array();

		/**
		 * @todo  Set the theme defaults here
		 */
		$helper_defaults = array(
				'layout_width_site'    => 1800,
				'layout_width_content' => 1800,
				'fonts_size_html'      => 16, // $font_size from `assets/scss/_setup.scss`
			);

		if ( is_callable( 'get_theme_mod' ) ) {
			foreach ( $helper_defaults as $key => $value ) {
				if ( get_theme_mod( $key ) ) {
					$helper_custom[ $key ] = get_theme_mod( $key );
				}
			} // /foreach
		}

		$helper = wp_parse_args( $helper_custom, $helper_defaults );
		$helper = apply_filters( 'wmhook_fn_firefly_custom_styles_helper', $helper );


	// Processing

		/**
		 * Custom styles array
		 *
		 * For advanced, conditional styles.
		 *
		 * You can hook onto `wmhook_fn_firefly_custom_styles_use_custom_array` and disable the theme
		 * default array setup. Then just hook onto `wmhook_fn_firefly_custom_styles_array` to create
		 * your own custom array.
		 *
		 * This is very dependent on $helper['fonts_size_html'] as we divide by this value.
		 * If the value is not existing, don't generate anything as we are using the theme defaults.
		 */
		if ( ! apply_filters( 'wmhook_fn_firefly_custom_styles_use_custom_array', false ) ) {

			if ( ! $visual_editor ) {
			// Normal, non-Visual Editor styles

				$custom_styles = array(





						'customizer-styles-title' => array(
								'custom' => '/* Customizer styles: calculated */'
							),





						/**
						 * Typography
						 */

							'typography' => array(
									'custom' => '/* Typography */'
								),

							'typography-media-query-open' => array(
									'custom' => "\t" . '@media only screen and (min-width: 420px) {'
								),

								'typography-font-size-html' => array(
									'selector' => 'html',
									'styles'   => array(
										'font-size' => ( $helper['fonts_size_html'] / 16 * 100 ) . '%',
									)
								),

							'typography-media-query-close' => array(
									'custom' => "\t" . '}'
								),





						/**
						 * Layout
						 */

							'layout' => array(
									'custom' => '/* Layout */'
								),

							'layout-width-site' => array(
								'selector' => '.site-layout-boxed .site',
								'styles'   => array(
									'max-width|1' => $helper['layout_width_site'] . 'px',
									'max-width|2' => ( $helper['layout_width_site'] / $helper['fonts_size_html'] ) . 'rem',
								)
							),

							'layout-width-content' => array(
								'selector' => implode( ', ', array(
										// All the selectors with `@extend %content_width;` from SASS files
										'.site-header-inner',
										'.intro-inner',
										'.content-area',
										'.breadcrumbs',
										'.site-footer-area-inner',
									) ),
								'styles'   => array(
									'width|1' => $helper['layout_width_content'] . 'px',
									'width|2' => ( $helper['layout_width_content'] / $helper['fonts_size_html'] ) . 'rem',
								)
							),

							'layout-width-beaver-builder' => array(
								'condition' => class_exists( 'FLBuilder' ),
								'selector'  => '.site ' . '.fl-row-fixed-width', // Override global width for Beaver Builder plugin
								'styles'    => array(
									'max-width|1' => $helper['layout_width_content'] . 'px',
									'max-width|2' => ( $helper['layout_width_content'] / $helper['fonts_size_html'] ) . 'rem',
								)
							),

							/**
							 * Fullwidth layout specific
							 *
							 * Content max width is $content_width px. It starts shrinking under X px screen width.
							 *
							 * X = $content_width / 88%_of_max_content_width
							 */
							'layout-fullwidth-media-query-open' => array(
									'condition' => class_exists( 'FLBuilder' ),
									'custom'    => "\t" . '@media only screen and (max-width: ' . absint( $helper['layout_width_content'] / .88 ) . 'px) {'
								),

								'layout-fullwidth-fl-row-max-width' => array(
									'condition' => class_exists( 'FLBuilder' ),
									'selector'  => '.site ' . '.fl-row-fixed-width',
									'styles'    => array(
										'max-width' => '88%',
									)
								),

							'layout-fullwidth-media-query-close' => array(
									'condition' => class_exists( 'FLBuilder' ),
									'custom'    => "\t" . '}'
								),

							/**
							 * Boxed layout specific
							 *
							 * Content max width is $content_width px. It starts shrinking under X px screen width.
							 *
							 * X = $content_width / 88%_of_max_content_width / ( 100 - BODY_padding-left - BODY_padding-right )%
							 */
							'layout-boxed-media-query-open' => array(
									'condition' => class_exists( 'FLBuilder' ),
									'custom'    => "\t" . '@media only screen and (max-width: ' . absint( $helper['layout_width_content'] / .88 / .96 ) . 'px) {'
								),

								'layout-boxed-fl-row-max-width' => array(
									'condition' => class_exists( 'FLBuilder' ),
									'selector'  => '.site-layout-boxed ' . '.fl-row-fixed-width',
									'styles'    => array(
										'max-width' => '88%',
									)
								),

							'layout-boxed-media-query-close' => array(
									'condition' => class_exists( 'FLBuilder' ),
									'custom' => "\t" . '}'
								),





					); // /$custom_styles

			} else {
			// Visual Editor styles

				$custom_styles = array(





						've-' . 'customizer-styles-title' => array(
								'custom' => '/* Customizer styles: calculated */'
							),





						/**
						 * Typography
						 */

							've-' . 'typography' => array(
									'custom' => '/* Typography */'
								),

							've-' . 'typography-font-size-html' => array(
								'selector' => 'html',
								'styles'   => array(
									'font-size' => '100%', // First, we have to reset the initial font size
								)
							),

							've-' . 'typography-media-query-open' => array(
									'custom' => "\t" . '@media only screen and (min-width: 420px) {'
								),

								've-' . 'typography-font-size-body' => array(
									'selector' => '.mce-content-body',
									'styles'   => array(
										'font-size' => ( $helper['fonts_size_html'] / 16 * 100 ) . '%',
									)
								),

							've-' . 'typography-media-query-close' => array(
									'custom' => "\t" . '}'
								),





						/**
						 * Layout
						 */

							've-' . 'layout' => array(
									'custom' => '/* Layout */'
								),

							've-' . 'layout-width-body' => array(
								'selector' => '.mce-content-body',
								'styles'   => array(
									'max-width' => ( absint( $helper['layout_width_content'] * .62 * ( 1 - .38 * .62 ) ) + 40 ) . 'px', // Post content width (optimized for max 75 chars per line)
								)
							),
							've-' . 'layout-width-body-page' => array(
								'selector' => '.mce-content-body.post-type-page',
								'styles'   => array(
									'max-width' => ( $helper['layout_width_content'] + 40 ) . 'px', // Page content width (fullwidth, no sidebar)
								)
							),





					); // /$custom_styles

			}

		} // /wmhook_fn_firefly_custom_styles_use_custom_array

			// Filter the $custom_styles array

				$custom_styles = apply_filters( 'wmhook_fn_firefly_custom_styles_array', $custom_styles, $helper );

			// Process the $custom_styles array

				if ( ! empty( $custom_styles ) ) {
					foreach ( $custom_styles as $selector ) {

						// Check condition first, if set

							if (
									isset( $selector['condition'] )
									&& ! trim( $selector['condition'] )
								) {
								continue;
							}

						// Processing the array

							if (
									isset( $selector['selector'] )
									&& $selector['selector']
									&& isset( $selector['styles'] )
									&& is_array( $selector['styles'] )
									&& ! empty( $selector['styles'] )
								) {

								// When CSS selector and styles set up

									$selector_styles = $prepend = '';

									$prepend = ( ! isset( $selector['prepend'] ) ) ? ( "\t\t" ) : ( $selector['prepend'] );

									if ( is_array( $selector['selector'] ) ) {

										// Replace placeholders in selector string
										// array( 'selector string with {p}', 'placeholder' )

											$selector['selector'] = str_replace( '{p}', $selector['selector'][1], $selector['selector'][0] );

									}

									$selector['selector'] = str_replace( ', ', ",\r\n" . $prepend, $selector['selector'] );

									foreach ( $selector['styles'] as $property => $style ) {
										if ( trim( $style ) ) {

											// This is for multiple overriden properties

												if ( strpos( $property, '|' ) ) {
													$property = explode( '|', $property );
													$property = $property[0];
												}

											// RTL languages property swap

												if ( is_rtl() ) {
													$replacements_rtl = (array) apply_filters( 'wmhook_fn_firefly_custom_styles_replacements_rtl', array(
															'left'  => 'right',
															'right' => 'left',
														) );
													$property = strtr( $property, $replacements_rtl );
												}

											$selector_styles .= $prepend . "\t" . $property . ': ' . trim( $style ) . ';' . "\r\n";

										}
									} // /foreach

									if ( $selector_styles ) {
										$output .= $prepend . $selector['selector'] . ' {';
										$output .= "\r\n" . $selector_styles;
										$output .= $prepend . '}' . "\r\n\r\n";
									}

							} elseif (
									isset( $selector['custom'] )
									&& $selector['custom']
								) {

								// Custom texts

									$output .= "\r\n\t" . $selector['custom'] . "\r\n\r\n";

							}

					} // /foreach
				}



		/**
		 * Custom CSS variables stylesheet
		 *
		 * For permanent simple styles (default value must be set).
		 */
		if ( is_callable( 'Firefly_Theme_Framework::custom_styles' ) ) {

			if ( ! $visual_editor ) {

				ob_start();
				locate_template( 'assets/css/custom-styles.css', true ); // Can be overridden via child theme
				locate_template( 'assets/css/custom-styles-addon.css', true ); // Use these to override custom-styles.css via child theme instead of redefining the whole file again if not needed
				$output .= "\r\n\r\n" . Firefly_Theme_Framework::custom_styles( ob_get_clean() );

			} else {

				ob_start();
				locate_template( 'assets/css/custom-styles-ve.css', true ); // Can be overridden via child theme
				locate_template( 'assets/css/custom-styles-addon-ve.css', true ); // Use these to override custom-styles.css via child theme instead of redefining the whole file again if not needed
				$output .= "\r\n\r\n" . Firefly_Theme_Framework::custom_styles( ob_get_clean() );

			}

		}

		// CSS generator info comments

			date_default_timezone_set( 'UTC' );

			$theme = Firefly_Theme_Framework::get_theme_slug();

			$output .= "\r\n\r\n\r\n" . '/* Using ' . wp_get_theme( $theme )->get( 'Name' ) . ' theme by WebMan - Oliver Juhas (' . esc_url( wp_get_theme( $theme )->get( 'AuthorURI' ) ) . '), version ' . wp_get_theme( $theme )->get( 'Version' ) . '. CSS generated on ' . date( 'Y/m/d H:i, e' ) . '. */';

		// Filter the output

			$output = apply_filters( 'wmhook_fn_firefly_custom_styles_output', $output );


	// Output

		return apply_filters( 'wmhook_firefly_esc_css', $output );

} // /firefly_custom_styles
