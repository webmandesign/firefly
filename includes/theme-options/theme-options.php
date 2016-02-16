<?php
/**
 * Theme options
 *
 * @uses  `wmhook_firefly_theme_options` global hook
 * @uses  `wmhook_firefly_generate_css_replacements` global hook
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 *
 * Contents:
 *
 * 10) Options functions
 */





/**
 * 10) Options functions
 */

	/**
	 * Set theme options array
	 *
	 * @uses  `wmhook_firefly_theme_options` global hook
	 * @uses  `wmhook_firefly_generate_css_replacements` global hook
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  array $options
	 */
	function firefly_theme_options_array( $options = array() ) {

		// Helper variables

			global $content_width;

			$theme = Firefly_Theme_Framework::get_theme_slug();

			/**
			 * @todo  Set the theme defaults here
			 */
			$width_site    = 1760; // Default max boxed site width
			$width_content = 1180; // Default content width

			// Helper CSS selectors for `preview_js` (the "@" will be replaced with `selector_replace`)

				$h_tags  =   '@h1, @.h1';
				$h_tags .= ', @h2, @.h2';
				$h_tags .= ', @h3, @.h3';
				$h_tags .= ', @h4, @.h4';
				$h_tags .= ', @h5, @.h5';
				$h_tags .= ', @h6, @.h6';


		// Processing

			/**
			 * Theme customizer options array
			 */

				$options = array(

					/**
					 * Theme credits
					 */
					'001' . 'placeholder' => array(
						'id'                   => 'placeholder',
						'type'                 => 'section',
						'create_section'       => '',
						'in_panel'             => esc_html_x( 'Theme', 'Customizer panel title.', 'firefly' ),
						'in_panel-description' => '<h3>' . esc_html__( 'Theme Credits', 'firefly' ) . '</h3>'
							. '<p class="description">'
							. sprintf(
								esc_html_x( '%1$s is a WordPress theme developed by %2$s.', '1: linked theme name, 2: theme author name.', 'firefly' ),
								'<a href="' . esc_url( wp_get_theme( $theme )->get( 'ThemeURI' ) ) . '" target="_blank"><strong>' . esc_html( wp_get_theme( $theme )->get( 'Name' ) ) . '</strong></a>',
								'<strong>' . esc_html( wp_get_theme( $theme )->get( 'Author' ) ) . '</strong>'
							)
							. '</p>'
							. '<p class="description">'
							. sprintf(
								esc_html_x( 'You can obtain other professional WordPress themes at %s.', '%s: theme author link.', 'firefly' ),
								'<strong><a href="' . esc_url( wp_get_theme( $theme )->get( 'AuthorURI' ) ) . '" target="_blank">' . esc_html( str_replace( 'http://', '', untrailingslashit( wp_get_theme( $theme )->get( 'AuthorURI' ) ) ) ) . '</a></strong>'
							)
							. '</p>'
							. '<p class="description">'
							. esc_html__( 'Thank you for using this awesome theme!', 'firefly' )
							. '</p>',
					),



					/**
					 * Colors: Accents and predefined colors
					 *
					 * Don't use `preview_js` here as these colors affect too many elements.
					 */
					100 . 'colors' . 10 => array(
						'id'             => 'colors-accents',
						'type'           => 'section',
						'create_section' => sprintf( esc_html_x( 'Colors: %s', '%s = section name. Customizer section title.', 'firefly' ), esc_html_x( 'Accents', 'Customizer color section title', 'firefly' ) ),
						'in_panel'       => esc_html_x( 'Theme', 'Customizer panel title.', 'firefly' ),
					),



						/**
						 * Accent colors
						 */
						100 . 'colors' . 10 . 100 => array(
							'type'    => 'html',
							'content' => '<h3>' . esc_html__( 'Accent color', 'firefly' ) . '</h3>',
						),

							100 . 'colors' . 10 . 105 => array(
								'type'        => 'color',
								'id'          => 'color_accent',
								'label'       => esc_html__( 'Accent color', 'firefly' ),
								'description' => esc_html__( 'This color affects links and other elements, such as buttons', 'firefly' ),
								'default'     => '#0aac8e',
							),
							100 . 'colors' . 10 . 110 => array(
								'type'        => 'color',
								'id'          => 'color_accent_text',
								'label'       => esc_html__( 'Accent text color', 'firefly' ),
								'description' => esc_html__( 'Color of text on accent color background', 'firefly' ),
								'default'     => '#ffffff',
							),



						/**
						 * Predefined colors
						 */

							100 . 'colors' . 10 . 200 => array(
								'type'    => 'html',
								'content' => '<h3>' . esc_html__( '"Error" color', 'firefly' ) . '</h3>',
							),

								100 . 'colors' . 10 . 201 => array(
									'type'    => 'color',
									'id'      => 'color_error_background',
									'label'   => esc_html__( 'Background color', 'firefly' ),
									'default' => '#c72d05',
								),
								100 . 'colors' . 10 . 202 => array(
									'type'    => 'color',
									'id'      => 'color_error_text',
									'label'   => esc_html__( 'Text color', 'firefly' ),
									'default' => '#ffffff',
								),

							100 . 'colors' . 10 . 210 => array(
								'type'    => 'html',
								'content' => '<h3>' . esc_html__( '"Info" color', 'firefly' ) . '</h3>',
							),

								100 . 'colors' . 10 . 211 => array(
									'type'    => 'color',
									'id'      => 'color_info_background',
									'label'   => esc_html__( 'Background color', 'firefly' ),
									'default' => '#003a5c',
								),
								100 . 'colors' . 10 . 212 => array(
									'type'    => 'color',
									'id'      => 'color_info_text',
									'label'   => esc_html__( 'Text color', 'firefly' ),
									'default' => '#ffffff',
								),

							100 . 'colors' . 10 . 220 => array(
								'type'    => 'html',
								'content' => '<h3>' . esc_html__( '"Neutral" color', 'firefly' ) . '</h3>',
							),

								100 . 'colors' . 10 . 221 => array(
									'type'    => 'color',
									'id'      => 'color_neutral_background',
									'label'   => esc_html__( 'Background color', 'firefly' ),
									'default' => '#dadcde',
								),
								100 . 'colors' . 10 . 222 => array(
									'type'    => 'color',
									'id'      => 'color_neutral_text',
									'label'   => esc_html__( 'Text color', 'firefly' ),
									'default' => '#3a3c3e',
								),

							100 . 'colors' . 10 . 230 => array(
								'type'    => 'html',
								'content' => '<h3>' . esc_html__( '"Success" color', 'firefly' ) . '</h3>',
							),

								100 . 'colors' . 10 . 231 => array(
									'type'    => 'color',
									'id'      => 'color_success_background',
									'label'   => esc_html__( 'Background color', 'firefly' ),
									'default' => '#037d38',
								),
								100 . 'colors' . 10 . 232 => array(
									'type'    => 'color',
									'id'      => 'color_success_text',
									'label'   => esc_html__( 'Text color', 'firefly' ),
									'default' => '#ffffff',
								),

							100 . 'colors' . 10 . 240 => array(
								'type'    => 'html',
								'content' => '<h3>' . esc_html__( '"Warning" color', 'firefly' ) . '</h3>',
							),

								100 . 'colors' . 10 . 241 => array(
									'type'    => 'color',
									'id'      => 'color_warning_background',
									'label'   => esc_html__( 'Background color', 'firefly' ),
									'default' => '#ffbb44',
								),
								100 . 'colors' . 10 . 242 => array(
									'type'    => 'color',
									'id'      => 'color_warning_text',
									'label'   => esc_html__( 'Text color', 'firefly' ),
									'default' => '#603b0b',
								),



					/**
					 * Colors: Header
					 */
					100 . 'colors' . 20 => array(
						'id'             => 'colors-header',
						'type'           => 'section',
						'create_section' => sprintf( esc_html_x( 'Colors: %s', '%s = section name. Customizer section title.', 'firefly' ), esc_html_x( 'Header', 'Customizer color section title', 'firefly' ) ),
						'in_panel'       => esc_html_x( 'Theme', 'Customizer panel title.', 'firefly' ),
					),



						/**
						 * Header colors
						 */

							100 . 'colors' . 20 . 100 => array(
								'type'    => 'html',
								'content' => '<h3>' . esc_html__( 'Header', 'firefly' ) . '</h3>',
							),

								100 . 'colors' . 20 . 105 => array(
									'type'       => 'color',
									'id'         => 'color_header_background',
									'label'      => esc_html__( 'Background color', 'firefly' ),
									'default'    => '#ffffff',
									'preview_js' => array(
											'css' => array(
													'.site-header, .set-colors-header' => array(
															'background-color'
														),
												),
										),
								),
								100 . 'colors' . 20 . 110 => array(
									'type'       => 'color',
									'id'         => 'color_header_text',
									'label'      => esc_html__( 'Text color', 'firefly' ),
									'default'    => '#6a6c6e',
									'preview_js' => array(
											'css' => array(
													'.site-header, .set-colors-header' => array(
															'color'
														),
												),
										),
								),



						/**
						 * Navigation colors
						 *
						 * Don't use `preview_js` here as this affect too many elements, even in media queries.
						 */

							100 . 'colors' . 20 . 200 => array(
								'type'    => 'html',
								'content' => '<h3>' . esc_html__( 'Navigation', 'firefly' ) . '</h3>'
								             . '<p class="description">' . esc_html__( 'The navigation colors will also affect other theme elements, such as Custom Menu and Submenu widget.', 'firefly' ) . '</p>',
							),

								100 . 'colors' . 20 . 205 => array(
									'type'        => 'color',
									'id'          => 'color_navigation_background',
									'label'       => esc_html__( 'Background color', 'firefly' ),
									'description' => esc_html__( 'Sets the background of submenus and active top level menu items', 'firefly' ),
									'default'     => '#003a5c',
								),
								100 . 'colors' . 20 . 210 => array(
									'type'        => 'color',
									'id'          => 'color_navigation_text',
									'label'       => esc_html__( 'Text color', 'firefly' ),
									'description' => esc_html__( 'Top level menu items text color is affected by header text color', 'firefly' ),
									'default'     => '#ffffff',
								),
								100 . 'colors' . 20 . 215 => array(
									'type'        => 'color',
									'id'          => 'color_navigation_border',
									'label'       => esc_html__( 'Borders color', 'firefly' ),
									'description' => esc_html__( 'This color will also be used as submenu item mouse hover color', 'firefly' ),
									'default'     => '#0074b7',
								),



					/**
					 * Colors: Content
					 */
					100 . 'colors' . 30 => array(
						'id'             => 'colors-content',
						'type'           => 'section',
						'create_section' => sprintf( esc_html_x( 'Colors: %s', '%s = section name. Customizer section title.', 'firefly' ), esc_html_x( 'Content', 'Customizer color section title', 'firefly' ) ),
						'in_panel'       => esc_html_x( 'Theme', 'Customizer panel title.', 'firefly' ),
					),



						/**
						 * Content colors
						 */

							100 . 'colors' . 30 . 100 => array(
								'type'    => 'html',
								'content' => '<h3>' . esc_html__( 'Content', 'firefly' ) . '</h3>'
								             . '<p class="description">' . esc_html__( 'The content colors will also affect other theme elements, such as standard posts and Staff posts list items.', 'firefly' ) . '</p>',
							),

								100 . 'colors' . 30 . 105 => array(
									'type'       => 'color',
									'id'         => 'color_content_background',
									'label'      => esc_html__( 'Background color', 'firefly' ),
									'default'    => '#ffffff',
									'preview_js' => array(
											'css' => array(
													'.site, .site-content, .set-colors-content' => array(
															'background-color'
														),
												),
										),
								),
								100 . 'colors' . 30 . 110 => array(
									'type'       => 'color',
									'id'         => 'color_content_text',
									'label'      => esc_html__( 'Text color', 'firefly' ),
									'default'    => '#6a6c6e',
									'preview_js' => array(
											'css' => array(
													'.site, .site-content, .set-colors-content' => array(
															'color'
														),
												),
										),
								),
								100 . 'colors' . 30 . 115 => array(
									'type'       => 'color',
									'id'         => 'color_content_headings',
									'label'      => esc_html__( 'Headings color', 'firefly' ),
									'default'    => '#3a3c3e',
									'preview_js' => array(
											'css' => array(
													$h_tags . ', .post-navigation, .wm-iconbox-module .image' => array(
															'selector_replace' => '',
															'color'
														),
												),
										),
								),
								100 . 'colors' . 30 . 120 => array(
									'type'       => 'color',
									'id'         => 'color_content_border',
									'label'      => esc_html__( 'Borders color', 'firefly' ),
									'default'    => '#caccce',
									'preview_js' => array(
											'css' => array(
													'.site, .site-content, .set-colors-content' => array(
															'border-color'
														),
												),
										),
								),



						/**
						 * Sidebar colors
						 */

							100 . 'colors' . 30 . 200 => array(
								'type'    => 'html',
								'content' => '<h3>' . esc_html__( 'Sidebar', 'firefly' ) . '</h3>',
							),

								100 . 'colors' . 30 . 205 => array(
									'type'        => 'color',
									'id'          => 'color_sidebar_background',
									'label'       => esc_html__( 'Sidebar background color', 'firefly' ),
									'description' => esc_html__( 'Set this to slightly different color than the content background', 'firefly' ),
									'description' => esc_html__( 'Set this to slightly different color than the content background. This color will also be applied on default layout of Content Modules and breadcrumbs navigation.', 'firefly' ),
									'default'     => '#f1f3f5',
									'preview_js'  => array(
											'css' => array(
													'.sidebar, .set-colors-sidebar' => array(
															'background-color'
														),
												),
										),
								),



					/**
					 * Colors: Footer
					 */
					100 . 'colors' . 40 => array(
						'id'             => 'colors-footer',
						'type'           => 'section',
						'create_section' => sprintf( esc_html_x( 'Colors: %s', '%s = section name. Customizer section title.', 'firefly' ), esc_html_x( 'Footer', 'Customizer color section title', 'firefly' ) ),
						'in_panel'       => esc_html_x( 'Theme', 'Customizer panel title.', 'firefly' ),
					),



						/**
						 * Footer colors
						 */

							100 . 'colors' . 40 . 100 => array(
								'type'    => 'html',
								'content' => '<h3>' . esc_html__( 'Footer', 'firefly' ) . '</h3>',
							),

								100 . 'colors' . 40 . 105 => array(
									'type'       => 'color',
									'id'         => 'color_footer_background',
									'label'      => esc_html__( 'Background color', 'firefly' ),
									'default'    => '#2a2c2e',
									'preview_js' => array(
											'css' => array(
													'.site-footer, .set-colors-footer' => array(
															'background-color'
														),
												),
										),
								),
								100 . 'colors' . 40 . 110 => array(
									'type'       => 'color',
									'id'         => 'color_footer_text',
									'label'      => esc_html__( 'Text color', 'firefly' ),
									'default'    => '#aaacae',
									'preview_js' => array(
											'css' => array(
													'.site-footer, .set-colors-footer' => array(
															'color'
														),
												),
										),
								),
								100 . 'colors' . 40 . 115 => array(
									'type'       => 'color',
									'id'         => 'color_footer_headings',
									'label'      => esc_html__( 'Headings color', 'firefly' ),
									'default'    => '#eaecfe',
									'preview_js' => array(
											'css' => array(
													$h_tags => array(
															'selector_replace' => '.site-footer ',
															'color'
														),
												),
										),
								),
								100 . 'colors' . 40 . 120 => array(
									'type'       => 'color',
									'id'         => 'color_footer_border',
									'label'      => esc_html__( 'Borders color', 'firefly' ),
									'default'    => '#4a4c4e',
									'preview_js' => array(
											'css' => array(
													'.site-footer, .set-colors-footer' => array(
															'border-color'
														),
												),
										),
								),
								100 . 'colors' . 40 . 125 => array(
									'type'        => 'color',
									'id'          => 'color_footer_accent',
									'label'       => esc_html__( 'Accent color', 'firefly' ),
									'description' => esc_html__( 'This color affects links and other elements', 'firefly' ),
									'default'     => '#fafcfe',
									// Don't use `preview_js` here as this affect too many elements.
								),
								100 . 'colors' . 40 . 130 => array(
									'type'        => 'color',
									'id'          => 'color_footer_accent_text',
									'label'       => esc_html__( 'Accent text color', 'firefly' ),
									'description' => esc_html__( 'Color of text on accent color background', 'firefly' ),
									'default'     => '#3a3c3e',
									// Don't use `preview_js` here as this affect too many elements.
								),



						/**
						 * Footer info widgets colors
						 */

							100 . 'colors' . 40 . 200 => array(
								'type'    => 'html',
								'content' => '<h3>' . esc_html__( 'Info widgets', 'firefly' ) . '</h3>',
							),

								100 . 'colors' . 40 . 205 => array(
									'type'       => 'color',
									'id'         => 'color_footer_info_background',
									'label'      => esc_html__( 'Background color', 'firefly' ),
									'default'    => '#07599b',
									'preview_js' => array(
											'css' => array(
													'.footer-info-widgets, .set-colors-footer-info-widgets' => array(
															'background-color'
														),
												),
										),
								),
								100 . 'colors' . 40 . 210 => array(
									'type'       => 'color',
									'id'         => 'color_footer_info_text',
									'label'      => esc_html__( 'Text color', 'firefly' ),
									'default'    => '#fafcfe',
									'preview_js' => array(
											'css' => array(
													'.footer-info-widgets, .set-colors-footer-info-widgets' => array(
															'color'
														),
												),
										),
								),



						/**
						 * Site info colors
						 */

							100 . 'colors' . 40 . 300 => array(
								'type'    => 'html',
								'content' => '<h3>' . esc_html__( 'Credits area', 'firefly' ) . '</h3>',
							),

								100 . 'colors' . 40 . 305 => array(
									'type'       => 'color',
									'id'         => 'color_site_info_background',
									'label'      => esc_html__( 'Background color', 'firefly' ),
									'default'    => '#07599b',
									'preview_js' => array(
											'css' => array(
													'.site-info-inner, .set-colors-credits' => array(
															'background-color'
														),
												),
										),
								),
								100 . 'colors' . 40 . 310 => array(
									'type'       => 'color',
									'id'         => 'color_site_info_text',
									'label'      => esc_html__( 'Text color', 'firefly' ),
									'default'    => '#fafcfe',
									'preview_js' => array(
											'css' => array(
													'.site-info-inner, .set-colors-credits' => array(
															'color'
														),
												),
										),
								),



					/**
					 * Colors: Site background
					 */
					100 . 'colors' . 50 => array(
						'id'             => 'colors', // Leave as `colors` only as the WordPress core "Background color" option is placed in there
						'type'           => 'section',
						'create_section' => sprintf( esc_html_x( 'Colors: %s', '%s = section name. Customizer section title.', 'firefly' ), esc_html_x( 'Site background', 'Customizer color section title', 'firefly' ) ),
						'in_panel'       => esc_html_x( 'Theme', 'Customizer panel title.', 'firefly' ),
					),

						// Leave empty. The WordPress core "Background color" option will display here.



					/**
					 * Layout
					 */
					200 . 'layout' => array(
						'id'             => 'layout',
						'type'           => 'section',
						'create_section' => esc_html_x( 'Layout', 'Customizer section title.', 'firefly' ),
						'in_panel'       => esc_html_x( 'Theme', 'Customizer panel title.', 'firefly' ),
					),

							200 . 'layout' . 100 => array(
								'type'    => 'html',
								'content' => '<h3>' . esc_html_x( 'Container', 'A website container.', 'firefly' ) . '</h3>',
							),

								200 . 'layout' . 110 => array(
									'type'    => 'radio',
									'id'      => 'layout_site',
									'label'   => esc_html__( 'Website layout', 'firefly' ),
									'default' => 'fullwidth',
									'options' => array(
											'boxed'     => esc_html__( 'Boxed', 'firefly' ),
											'fullwidth' => esc_html__( 'Fullwidth', 'firefly' ),
										),
									// No need for `preview_js` here as it won't trigger the `active_callback` below.
								),

								200 . 'layout' . 120 => array(
									'type'        => 'range',
									'id'          => 'layout_width_site',
									'label'       => esc_html__( 'Website max width', 'firefly' ),
									'description' => esc_html__( 'For boxed website layout.', 'firefly' ) . '<br />' . sprintf( esc_html__( 'Default value: %s', 'firefly' ), number_format_i18n( $width_site ) ),
									'default'     => $width_site,
									'min'         => 1000,
									'max'         => 1840, // cca 1920 x 96%
									'step'        => 20,
									'preview_js'  => array(
											'css' => array(
													'.site-layout-boxed .site' => array(
															array( 'max-width', 'px' )
														),
												),
										),
									'active_callback' => 'firefly_active_callback_layout_width_site',
								),
								200 . 'layout' . 130 => array(
									'type'        => 'range',
									'id'          => 'layout_width_content',
									'label'       => esc_html__( 'Content width', 'firefly' ),
									'description' => sprintf( esc_html__( 'Default value: %s', 'firefly' ), number_format_i18n( $width_content ) ),
									'default'     => $width_content,
									'min'         => 880,
									'max'         => 1620, // cca ( 1920 x 96% ) x 88%
									'step'        => 20,
									'preview_js'  => array(
											'css' => array(
													'.site-header-inner, .intro-inner, .content-area, .breadcrumbs, .site-footer-area-inner' => array(
															array( 'width', 'px' )
														),
													'.site .fl-row-fixed-width' => array(
															array( 'max-width', 'px' )
														),
												),
										),
								),

							200 . 'layout' . 200 => array(
								'type'    => 'html',
								'content' => '<h3>' . esc_html__( 'Header', 'firefly' ) . '</h3>',
							),

								200 . 'layout' . 210 => array(
									'type'    => 'checkbox',
									'id'      => 'layout_header_sticky',
									'label'   => esc_html__( 'Sticky header', 'firefly' ),
									'default' => false,
									// No need for `preview_js` here as we also need to load the scripts.
								),

							200 . 'layout' . 300 => array(
								'type'    => 'html',
								'content' => '<h3>' . esc_html__( 'Footer', 'firefly' ) . '</h3>',
							),

								200 . 'layout' . 310 => array(
									'type'       => 'range',
									'id'         => 'layout_footer_columns',
									'label'      => esc_html__( 'Number of columns', 'firefly' ),
									'default'    => 3,
									'min'        => 2,
									'max'        => 5,
									'step'       => 1,
									'preview_js' => array(
											'custom' => "jQuery( '#footer-widgets' ).removeClass( 'columns-2 columns-3 columns-4 columns-5' ).addClass( 'columns-' + to );",
										),
								),



					/**
					 * Texts
					 *
					 * Don't use `preview_js` here as it outputs escaped HTML.
					 */
					800 . 'texts' => array(
						'id'             => 'texts',
						'type'           => 'section',
						'create_section' => esc_html_x( 'Texts', 'Customizer section title.', 'firefly' ),
						'in_panel'       => esc_html_x( 'Theme', 'Customizer panel title.', 'firefly' ),
					),

						800 . 'texts' . 900 => array(
							'type'        => 'textarea',
							'id'          => 'texts_credits',
							'label'       => esc_html__( 'Footer credits (copyright)', 'firefly' ),
							'description' => sprintf( esc_html__( 'Set %s to disable the this area.', 'firefly' ), '<code>-</code>' ),
							'default'     => '',
							'validate'    => 'wp_filter_post_kses',
						),



					/**
					 * Fonts
					 */
					900 . 'fonts' => array(
						'id'             => 'fonts',
						'type'           => 'section',
						'create_section' => esc_html_x( 'Fonts', 'Customizer section title.', 'firefly' ),
						'in_panel'       => esc_html_x( 'Theme', 'Customizer panel title.', 'firefly' ),
					),

						900 . 'fonts' . 100 => array(
							'type'          => 'range',
							'id'            => 'fonts_size_html',
							'label'         => esc_html__( 'Basic font size in px', 'firefly' ),
							'description'   => esc_html__( 'All other font sizes are calculated automatically from this basic font size', 'firefly' ),
							'default'       => 16,
							'min'           => 12,
							'max'           => 24,
							'step'          => 1,
							'validate'      => 'absint',
							'preview_js' => array(
									'css' => array(
											'html' => array(
													array( 'font-size', 'px' )
												),
										),
								),
						),

						900 . 'fonts' . 110 => array(
							'type'        => 'checkbox',
							'id'          => 'fonts_disable',
							'label'       => esc_html__( 'Disable theme fonts loading', 'firefly' ),
							'description' => esc_html__( 'If you are using a custom fonts plugin you should disable the default theme fonts loading scripts.', 'firefly' ),
							'default'     => false,
						),

						900 . 'fonts' . 900 => array(
							'type'    => 'html',
							'content' => '<hr /><p class="description">' . sprintf(
									esc_html_x( 'This theme does not restrict you to a predefined set of fonts. Please use any font service (such as %s) plugin you want and set the plugin according to the information below.', '%s: linked examples of web fonts libraries such as Google Fonts or Adobe Typekit.', 'firefly' ),
									'<a href="http://www.google.com/fonts" target="_blank"><strong>Google Fonts</strong></a>, <a href="https://typekit.com/fonts" target="_blank"><strong>Adobe Typekit</strong></a>'
								) . '</p>'
								. '<p>' . esc_html__( 'List of CSS selectors for predefined theme font sets:', 'firefly' ) . '</p>'
								. '<ol>'

								. '<li><strong>' . esc_html_x( 'Texts:', 'CSS selector group name.', 'firefly' ) . '</strong><br />'
									. '<code>html</code>'
									. '<br><small>' . sprintf(
											esc_html__( 'Default font used: %s', 'firefly' ),
											'<a href="http://www.google.com/fonts/specimen/Ubuntu" target="_blank">Ubuntu</a>'
										) . '</small>'
								. '</li>'

								. '<li><strong>' . esc_html_x( 'Headings:', 'CSS selector group name.', 'firefly' ) . '</strong><br />'
									. '<code>h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6</code>'
									. '<br><small>' . sprintf(
											esc_html__( 'Default font used: %s', 'firefly' ),
											'<a href="http://www.google.com/fonts/specimen/Ubuntu" target="_blank">Ubuntu</a>'
										) . '</small>'
								. '</li>'

								. '<li><strong>' . esc_html_x( 'Logo:', 'CSS selector group name.', 'firefly' ) . '</strong><br />'
									. '<code>.site-title, .logo-font</code>'
									. '<br><small>' . sprintf(
											esc_html__( 'Default font used: %s', 'firefly' ),
											'<a href="http://www.google.com/fonts/specimen/Ubuntu" target="_blank">Ubuntu</a>'
										) . '</small>'
								. '</li>'

								. '</ol>',
						),



					/**
					 * Others
					 */
					950 . 'others' => array(
						'id'             => 'others',
						'type'           => 'section',
						'create_section' => esc_html_x( 'Others', 'Customizer section title.', 'firefly' ),
						'in_panel'       => esc_html_x( 'Theme', 'Customizer panel title.', 'firefly' ),
					),

						950 . 'others' . 100 => array(
							'type'        => 'checkbox',
							'id'          => 'others_logo_style_disable',
							'label'       => esc_html__( 'Disable logo styling', 'firefly' ),
							'description' => esc_html__( 'Removes the theme text logo styling.', 'firefly' ),
							'default'     => false,
							'preview_js'  => array(
									'custom' => "jQuery( '.site-title.type-text' ).toggleClass( 'styled' );",
								),
						),

						950 . 'others' . 110 => array(
							'type'        => 'checkbox',
							'id'          => 'others_about_disable',
							'label'       => esc_html__( 'Disable "About" page', 'firefly' ),
							'description' => esc_html__( 'Removes the theme "About" page from "Appearance" menu of your WordPress dashboard.', 'firefly' ),
							'default'     => false,
							'preview_js'  => false, // This is to prevent customizer preview reload
						),



				);



				/**
				 * Beaver Builder
				 */
				if ( class_exists( 'FLBuilder' ) ) {

					$options = array_merge( $options, array(

							950 . 'others' . 900 => array(
								'type'        => 'checkbox',
								'id'          => 'others_beaver_builder_all_modules',
								'label'       => esc_html__( 'Beaver Builder - all modules', 'firefly' ),
								'description' => esc_html__( 'If you are using Beaver Builder Pro version, and you would like to use preset templates, please enable all the plugin native modules here.', 'firefly' ),
								'default'     => false,
								'preview_js'  => false, // This is to prevent customizer preview reload
							),

						) );

				}



				/**
				 * Sort the options array
				 */

					ksort( $options );


		// Output

			return apply_filters( 'wmhook_fn_firefly_theme_options_array_output', $options );

	} // /firefly_theme_options_array

	add_filter( 'wmhook_firefly_theme_options', 'firefly_theme_options_array', 10 );



	/**
	 * Show layout width conditionally
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  array $control
	 */
	function firefly_active_callback_layout_width_site( $control ) {

		// Helper variables

			$layout = $control->manager->get_setting( 'layout_site' );


		// Output

			return ( 'fullwidth' != $layout->value() );

	} // /firefly_active_callback_layout_width_site



	/**
	 * CSS generator replacements
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  array $replacements
	 */
	function firefly_generate_css_replacements( $replacements = array() ) {

		// Processing

			$replacements = array(
					'/* End of file */'               => "\r\n\r\n",
					'/*[*/'                           => '/** ', // Open a comment
					'/*]*/'                           => ' **/', // Close a comment
					'/*//'                            => '', // Remove a comment opening
					'//*/'                            => '', // Remove a comment closing
					'___get_template_directory'       => untrailingslashit( get_template_directory() ),
					'___get_stylesheet_directory'     => untrailingslashit( get_stylesheet_directory() ),
					'___get_template_directory_uri'   => str_replace( array( 'http:', 'https:' ), '', untrailingslashit( get_template_directory_uri() ) ),
					'___get_stylesheet_directory_uri' => str_replace( array( 'http:', 'https:' ), '', untrailingslashit( get_stylesheet_directory_uri() ) ),
				);


		// Output

			return $replacements;

	} // /firefly_generate_css_replacements

	add_filter( 'wmhook_firefly_generate_css_replacements', 'firefly_generate_css_replacements', 10 );
