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

							<a href="<?php echo esc_url( 'http://www.webmandesign.eu/manual/firefly/' ); ?>" class="button button-primary button-hero" target="_blank"><?php esc_html_e( 'User Manual', 'firefly' ); ?></a>

							<a href="<?php echo esc_url( 'http://support.webmandesign.eu' ); ?>" class="button button-hero" target="_blank"><?php esc_html_e( 'Support Center', 'firefly' ); ?></a>

						</p>

				<!-- Content -->

					<div class="changelog">

					<!-- Quickstart steps -->

						<hr />

						<h2 class="screen-reader-text"><?php esc_html_e( 'Quickstart Guide', 'firefly' ); ?></h2>

						<div class="feature-section three-col">

							<div class="first-feature col">

								<span class="dropcap">1</span>

								<h3><?php esc_html_e( 'WebMan Amplifier', 'firefly' ); ?></h3>

								<p>
									<?php printf( esc_html_x( 'To make the theme highly flexible, open and future-proof, it uses the %s plugin.', '%s: plugin name.', 'firefly' ), '<strong>WebMan Amplifier</strong>' ); ?>
									<?php esc_html_e( 'Please, install and activate this plugin to provide the additional functionality.', 'firefly' ); ?>
								</p>

								<a href="<?php echo esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ); ?>" class="button button-hero"><?php printf( esc_html_x( 'Install %s &raquo;', '%s: plugin name.', 'firefly' ), '<strong>WebMan Amplifier</strong>' ); ?></a>

							</div>

							<div class="feature col">

								<span class="dropcap">2</span>

								<h3><?php esc_html_e( 'The WordPress settings', 'firefly' ); ?></h3>

								<p>
									<?php esc_html_e( 'Do not forget to set up your WordPress in "Settings" section of the main WordPress admin menu. Please go through all the subsections and options.', 'firefly' ); ?>
								</p>

								<a class="button button-hero" href="<?php echo esc_url( admin_url( 'options-general.php' ) ); ?>"><?php esc_html_e( 'Set up WordPress &raquo;', 'firefly' ); ?></a>

							</div>

							<div class="last-feature col">

								<span class="dropcap">3</span>

								<h3><?php esc_html_e( 'Customize the theme', 'firefly' ); ?></h3>

								<p>
									<?php esc_html_e( 'You can customize the theme using live-preview editor. Apply a design changes with no fear of them affecting your website front-end - nothing is going live until you save the changes!', 'firefly' ); ?>
								</p>

								<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary button-hero"><?php esc_html_e( 'Customize the Theme &raquo;', 'firefly' ); ?></a>

							</div>

						</div>

					<!-- Filesystem notice -->

						<hr />

						<h3>
							<em>
								<strong>
									<?php esc_html_e( 'Important:', 'firefly' ); ?>
								</strong>
							</em>
						</h3>

						<p>
							<em>
								<?php esc_html_e( 'For the best performance, the theme generates a single CSS stylesheet file using WordPress native filesystem API. The file is being generated after saving theme customizer settings.', 'firefly' ); ?>
								<?php esc_html_e( 'If you notice an error message in WordPress dashboard after leaving the theme customizer, please check whether you should set up the FTP credentials in your "wp-config.php" file.', 'firefly' ); ?>
								<a href="http://codex.wordpress.org/Editing_wp-config.php#WordPress_Upgrade_Constants" target="_blank"><?php esc_html_e( 'Please read the instructions.', 'firefly' ); ?></a>
							</em>
						</p>

					<!-- Special note -->

						<div class="wm-notes special">

							<h2 class="mt0"><strong><?php esc_html_e( 'Installing the theme demo content', 'firefly' ); ?></strong></h2>

							<p>
								<?php esc_html_e( 'You can obtain the most recent theme demo content file in the theme on-line user manual. Please click the button below to obtain the file and read the short instructions on how to install the demo content.', 'firefly' ); ?>
							</p>

							<p>
								<em>
									<?php esc_html_e( 'Please, pay attention to section on what additional plugins should be installed beforehand.', 'firefly' ); ?>
								</em>
							</p>

							<a href="<?php echo esc_url( 'http://www.webmandesign.eu/manual/firefly/#demo-content' ); ?>" class="button button-hero"><strong><?php printf( esc_html_x( 'Install demo content &raquo;', '%s: plugin name.', 'firefly' ), '<strong>WebMan Amplifier</strong>' ); ?></strong></a>

						</div>

					</div>

				<!-- Footer note -->

					<p><small><em><?php esc_html_e( 'You can disable this page in Appearance &raquo; Customize &raquo; Theme &raquo; Others.', 'firefly' ); ?></em></small></p>

			</div>

			<?php

	} // /firefly_about_screen
