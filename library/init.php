<?php
/**
 * WebMan WordPress Theme Framework (Simple)
 *
 * Textdomain used in the framework: firefly
 *
 * Theme options with `__` prefix (`get_theme_mod( '__option_id' )`) are theme
 * setup related options and can not be edited via customizer. This way we prevent
 * creating non-sense multiple options in a database.
 *
 * Custom hooks naming convention:
 * - `wmhook_firefly_` - global (and other, such as plugins related) hooks
 * - `wmhook_firefly_tf_` - theme framework specific hooks (core specific)
 * - `wmhook_firefly_tf_admin_` - class method specific hooks
 * - `wmhook_firefly_tf_customize_` - class method specific hooks
 * - `wmhook_firefly_tf_editor_` - class method specific hooks
 * - `tha_` - Theme Hook Alliance specific hooks
 *
 * Used global hooks:
 * @uses  `wmhook_firefly_theme_options`
 * @uses  `wmhook_firefly_esc_css`
 * @uses  `wmhook_firefly_custom_styles`
 *
 * Used development prefixes:
 * - theme_slug
 * - prefix_constant
 * - prefix_var
 * - prefix_class
 * - prefix_fn
 * - prefix_hook
 * - text_domain
 *
 * @copyright  2016 WebMan Design, Oliver Juhas
 * @license    GPL-3.0, http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @link  https://github.com/webmandesign/webman-theme-framework
 * @link  http://www.webmandesign.eu
 *
 * @package     WebMan WordPress Theme Framework (Simple)
 * @subpackage  Core
 *
 * @version  1.1
 *
 * Contents:
 *
 *  0) Constants
 *  1) Required files
 * 10) Init
 */





/**
 * 0) Constants
 */

	// Dir constants

		if ( ! defined( 'FIREFLY_LIBRARY_DIR' ) ) define( 'FIREFLY_LIBRARY_DIR', trailingslashit( 'library' ) );
		if ( ! defined( 'FIREFLY_INCLUDES_DIR' ) ) define( 'FIREFLY_INCLUDES_DIR', trailingslashit( 'includes' ) );





/**
 * 1) Required files
 */

	// Customize (has to be frontend accessible, otherwise it hides theme settings)

		require_once( trailingslashit( get_template_directory() ) . FIREFLY_LIBRARY_DIR . 'includes/customize.php' );

	// Core class

		require_once( trailingslashit( get_template_directory() ) . FIREFLY_LIBRARY_DIR . 'includes/classes/class-core.php' );





/**
 * 10) Init
 */

	add_action( 'after_setup_theme', array( 'Firefly_Theme_Framework', 'init' ), -100 );
