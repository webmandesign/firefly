<?php
/**
 * Plugins suggestions
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 *
 * Contents:
 *
 * 10) Funcions
 */





/**
 * 10) Funcions
 */

	/**
	 * Register the required plugins for the theme
	 *
	 * @link  https://github.com/thomasgriffin/TGM-Plugin-Activation/blob/master/example.php
	 */
	function firefly_plugins_suggestions() {

		/**
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = apply_filters( 'wmhook_fn_firefly_plugins_suggestions_plugins', array(

				/**
				 * WordPress Repository plugins
				 */

					// Recommended

						'webman-amplifier' => array(
							'name'     => '1) ' . esc_html__( 'WebMan Amplifier (theme features)', 'firefly' ),
							'slug'     => 'webman-amplifier',
							'required' => false,
							'version'  => '1.3.2',
						),

			) );

			/**
			 * Recommend Beaver Builder Lite Version only if Pro version not active
			 */
			if ( ! class_exists( 'FLBuilder' ) ) {

				$plugins['beaver-builder'] = array(
						'name'     => '2) ' . esc_html__( 'Beaver Builder (page builder)', 'firefly' ),
						'slug'     => 'beaver-builder-lite-version',
						'required' => false,
						'version'  => '1.7.1',
					);

			}



		/**
		 * Array of configuration settings. Amend each line as needed.
		 * If you want the default strings to be available under your own theme domain, leave the strings uncommented.
		 * Some of the strings are added into a sprintf, so see the comments at the end of each line for what each argument will be.
		 */
		$config = apply_filters( 'wmhook_fn_firefly_plugins_suggestions_config', array() );



		/**
		 * Actual action...
		 */
		tgmpa( $plugins, $config );

	} // /firefly_plugins_suggestions

	add_action( 'tgmpa_register', 'firefly_plugins_suggestions' );
