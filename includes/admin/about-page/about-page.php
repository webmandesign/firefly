<?php
/**
 * About Page
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
 * 20) Render
 */





/**
 * 10) Assets
 */

	/**
	 * About theme page styles
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_about_css() {

		// Helper variables

			$theme = Firefly_Theme_Framework::get_theme_slug();


		// Processing

			/**
			 * Styles
			 */

				wp_enqueue_style(
						'firefly-about-custom',
						Firefly_Theme_Framework::get_stylesheet_directory_uri( 'assets/css/about-custom.css' ),
						array( 'firefly-about' ),
						esc_attr( trim( wp_get_theme( $theme )->get( 'Version' ) ) ),
						'screen'
					);

	} // /firefly_about_css





/**
 * 30) Render
 */

	/**
	 * Add "About" screen to WordPress menu
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_add_about_screen() {

		// Requirements check

			if ( get_theme_mod( 'others_about_disable' ) ) {
				return;
			}


		// Helper variables

			$wp_upload_dir = wp_upload_dir();

			$theme = Firefly_Theme_Framework::get_theme_slug();

			$page_title = sprintf(
					esc_html_x( 'About %s', '%s: theme name.', 'firefly' ),
					wp_get_theme( $theme )->get( 'Name' )
				);


		// Processing

			$screen = add_theme_page(
					// $page_title
					$page_title,
					// $menu_title
					$page_title,
					// $capability
					'switch_themes',
					// $menu_slug
					'firefly-about',
					// $function
					'firefly_about_screen'
				);

			// Add page styles

				add_action( 'admin_print_styles-' . $screen, 'firefly_about_css' );

	} // /firefly_add_about_screen

	add_action( 'admin_menu', 'firefly_add_about_screen' );



	/**
	 * Render the "About" screen content
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_about_screen() {

		// Helper variables

			$theme = Firefly_Theme_Framework::get_theme_slug();


		// Output

			?>

			<div class="wrap about-wrap">

				<!-- Header -->

					<h1>
						<?php

						printf(
							esc_html_x( 'Welcome to %1$s %2$s', '1: theme name, 2: theme version number.', 'firefly' ),
							'<strong>' . wp_get_theme( $theme )->get( 'Name' ) . '</strong>',
							'<small>' . wp_get_theme( $theme )->get( 'Version' ) . '</small>'
						);

						?>
					</h1>

					<div class="about-text">
						<?php

						printf(
							esc_html_x( 'Thank you for using %1$s WordPress theme by %2$s!', '1: theme name, 2: theme developer link.', 'firefly' ),
							'<strong>' . wp_get_theme( $theme )->get( 'Name' ) . '</strong>',
							'<a href="' . esc_url( wp_get_theme( $theme )->get( 'AuthorURI' ) ) . '" target="_blank">WebMan Design</a>'
						);

						?>
						<br />
						<?php esc_html_e( 'Please take time to read the steps below to set your website up.', 'firefly' ); ?>
					</div>

					<!-- Action links / buttons -->

						<p class="wm-actions">

							<a href="<?php echo esc_url( 'http://www.webmandesign.eu/manual/firefly/' ); ?>" class="button button-primary button-hero" target="_blank"><?php esc_html_e( 'Theme Documentation', 'firefly' ); ?></a>

							<a href="<?php echo esc_url( 'https://wordpress.org/support/theme/firefly/' ); ?>" class="button button-hero" target="_blank"><?php esc_html_e( 'Support Center', 'firefly' ); ?></a>

						</p>

				<!-- Content -->

					<div class="changelog">

					<!-- Quickstart steps -->

						<h2 class="screen-reader-text"><?php esc_html_e( 'Quickstart Guide', 'firefly' ); ?></h2>

						<div class="feature-section three-col">

							<div class="last-feature col">

								<h3><?php esc_html_e( 'Responsive, high resolution', 'firefly' ); ?></h3>

								<p>
									<?php esc_html_e( 'Your website will look stunning on any screen and any device with this theme.', 'firefly' ); ?>
								</p>

								<p>
									<?php esc_html_e( 'Mobile first approach assures your website visitors will have a great experience browsing your website on their phones too.', 'firefly' ); ?>
								</p>

							</div>

							<div class="first-feature col">

								<img src="<?php echo esc_url( Firefly_Theme_Framework::get_stylesheet_directory_uri( 'assets/images/nested-pages-child-pages.gif' ) ); ?>" alt="<?php esc_html_e( 'Toggling child pages with Nested Pages plugin', 'firefly' ); ?>" title="<?php esc_html_e( 'Toggling child pages with Nested Pages plugin', 'firefly' ); ?>" />

								<h3><?php esc_html_e( 'List of subpages', 'firefly' ); ?></h3>

								<p>
									<?php esc_html_e( 'If you set some child pages for a particular page, it will display a list of these subpages.', 'firefly' ); ?> <a href="https://codex.wordpress.org/Pages#To_create_a_subpage" target="_blank"><em><?php esc_html_e( '(How to create a child page?)', 'firefly' ); ?></em></a>
								</p>

								<p>
									<?php esc_html_e( 'You can use "more tag", or more conveniently set a page excerpt for your child pages.', 'firefly' ); ?>
									<?php printf( esc_html_x( 'Try using the %s plugin for better experience setting the excerpts.', '%s: plugin name with link to plugin page.', 'firefly' ), '<a href="https://wordpress.org/plugins/rich-text-excerpts/" target="_blank"><strong>' . esc_html_x( 'Rich Text Excerpts', 'Plugin name.', 'firefly' ) . '</strong></a>' ); ?>
								</p>

							</div>

							<div class="feature col">

								<img src="<?php echo esc_url( Firefly_Theme_Framework::get_stylesheet_directory_uri( 'assets/images/page-options.jpg' ) ); ?>" alt="<?php esc_html_e( 'Page options metabox displayed by Advanced Custom Fields plugin', 'firefly' ); ?>" title="<?php esc_html_e( 'Page options metabox displayed by Advanced Custom Fields plugin', 'firefly' ); ?>" />

								<h3><?php esc_html_e( 'Page options', 'firefly' ); ?></h3>

								<p>
									<?php esc_html_e( 'There is a handful of useful page options available, too.', 'firefly' ); ?>
									<?php printf( esc_html_x( 'Install and activate the %s plugin to enable better page options management, or refer to theme documentation for more info.', '%s: plugin name with link to plugin page.', 'firefly' ), '<a href="https://wordpress.org/plugins/advanced-custom-fields/" target="_blank"><strong>' . esc_html_x( 'Advanced Custom Fields', 'Plugin name.', 'firefly' ) . '</strong></a>' ); ?>
								</p>

								<p>
									<?php printf( esc_html_x( 'For easier management of your website pages you can use a great %s plugin.', '%s: plugin name with link to plugin page.', 'firefly' ), '<a href="https://wordpress.org/plugins/wp-nested-pages/" target="_blank"><strong>' . esc_html_x( 'Nested Pages', 'Plugin name.', 'firefly' ) . '</strong></a>' ); ?>
								</p>

							</div>

						</div>

						<div class="feature-section three-col">

							<div class="last-feature col">

								<img src="<?php echo esc_url( Firefly_Theme_Framework::get_stylesheet_directory_uri( 'assets/images/beaver-builder.jpg' ) ); ?>" alt="<?php esc_html_e( 'Using Beaver Builder page builder', 'firefly' ); ?>" title="<?php esc_html_e( 'Using Beaver Builder page builder', 'firefly' ); ?>" />

								<h3><?php esc_html_e( 'Page builder', 'firefly' ); ?></h3>

								<p>
									<?php esc_html_e( 'Simple page layout is not for you?', 'firefly' ); ?>
									<?php printf( esc_html_x( 'Well, for this case the theme fully supports the amazing front-end page builder plugin, the %s.', '%s: plugin name with link to plugin page.', 'firefly' ), '<a href="https://wordpress.org/plugins/beaver-builder-lite-version/" target="_blank"><strong>' . esc_html_x( 'Beaver Builder', 'Plugin name.', 'firefly' ) . '</strong></a>' ); ?>
								</p>

								<p>
									<?php esc_html_e( 'Word of warning: this page builder plugin is very addicting, and you might fall in love with it very quickly!', 'firefly' ); ?>
								</p>

							</div>

							<div class="first-feature col">

								<img src="<?php echo esc_url( Firefly_Theme_Framework::get_stylesheet_directory_uri( 'assets/images/intro-widgets.jpg' ) ); ?>" alt="<?php esc_html_e( 'Page intro widgets area', 'firefly' ); ?>" title="<?php esc_html_e( 'Page intro widgets area', 'firefly' ); ?>" />

								<h3><?php esc_html_e( 'Intro widgets', 'firefly' ); ?></h3>

								<p>
									<?php esc_html_e( 'In your page title area you can conveniently display a special Intro Widgets area when using a dedicated "With intro widgets" page template (or a special page option).', 'firefly' ); ?>
								</p>

								<p>
									<?php printf( esc_html_x( 'For easy overriding of what should be displayed in this widgets try using the %s plugin.', '%s: plugin name with link to plugin page.', 'firefly' ), '<a href="https://wordpress.org/plugins/woosidebars/" target="_blank"><strong>' . esc_html_x( 'WooSidebars', 'Plugin name.', 'firefly' ) . '</strong></a>' ); ?>
								</p>

							</div>

							<div class="feature col">

								<img src="<?php echo esc_url( Firefly_Theme_Framework::get_stylesheet_directory_uri( 'assets/images/customizer.jpg' ) ); ?>" alt="<?php esc_html_e( 'Using theme customizer', 'firefly' ); ?>" title="<?php esc_html_e( 'Using theme customizer', 'firefly' ); ?>" />

								<h3><?php esc_html_e( 'Customize the theme', 'firefly' ); ?></h3>

								<p>
									<?php esc_html_e( 'You can find all theme options integrated directly into WordPress theme customizer.', 'firefly' ); ?>
									<?php esc_html_e( 'Edit your website appearance with immediate preview of your changes before you actually apply them live.', 'firefly' ); ?>
								</p>

								<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary button-hero"><?php esc_html_e( 'Customize the Theme &raquo;', 'firefly' ); ?></a>

							</div>

						</div>

					<!-- Special note -->

						<div class="wm-notes special">

							<h2 class="mt0"><strong><?php esc_html_e( 'Installing the theme demo content', 'firefly' ); ?></strong></h2>

							<p>
								<?php esc_html_e( '', 'firefly' ); ?>
							</p>

							<p>
								<em>
									<?php esc_html_e( 'Please, pay attention to section on what additional plugins should be installed beforehand.', 'firefly' ); ?>
								</em>
							</p>

							<a href="<?php echo esc_url( 'http://www.webmandesign.eu/manual/firefly/#demo-content' ); ?>" class="button button-hero"><strong><?php printf( esc_html_x( 'Install demo content &raquo;', '%s: plugin name.', 'firefly' ), '<strong>WebMan Amplifier</strong>' ); ?></strong></a>

						</div>

					</div>

			</div>

			<?php

	} // /firefly_about_screen
