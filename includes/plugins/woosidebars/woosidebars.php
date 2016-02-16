<?php
/**
 * Plugin integration
 *
 * WooSidebars
 *
 * @link  https://wordpress.org/plugins/woosidebars/
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

	if ( ! class_exists( 'Woo_Sidebars' ) ) {
		return;
	}





/**
 * 10) Plugin integration
 */

	/**
	 * Altering default sidebar args
	 *
	 * Hooking onto 'dynamic_sidebar_params' filter to alter the default
	 * WordPress args for registered sidebars. This way we can make the
	 * default wrapper around the sidebar widget a DIV for example
	 * and change the widget heading tag.
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  string $params
	 */
	function firefly_ws_default_sidebar_params( $params ) {

		// Processing

			if (
					! isset( $params[0]['after_widget'] )
					|| '</li>' === trim( $params[0]['after_widget'] )
				) {
				global $wp_registered_widgets;

				// Substitute HTML id and class attributes into before_widget

					$id         = $params[0]['widget_id'];
					$classname_ = '';

					foreach ( (array) $wp_registered_widgets[ $id ]['classname'] as $cn ) {
						if ( is_string( $cn ) ) {
							$classname_ .= '_' . $cn;
						} elseif ( is_object( $cn ) ) {
							$classname_ .= '_' . get_class( $cn );
						}
					}

					$classname_ = ltrim( $classname_, '_' );

				$params[0]['before_widget'] = sprintf( '<section id="%1$s" class="widget %2$s">', $id, $classname_ );
				$params[0]['after_widget']  = '</section>';
				$params[0]['before_title']  = '<h3 class="widget-title">MUFTY';
				$params[0]['after_title']   = '</h3>';
			}


		// Output

			return $params;

	} // /firefly_ws_default_sidebar_params

	add_filter( 'dynamic_sidebar_params', 'firefly_ws_default_sidebar_params', 10 );
