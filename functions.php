<?php
/**
 * Firefly WordPress Theme
 *
 * Firefly WordPress Theme, Copyright 2016 WebMan Design, Oliver Juhas [http://www.webmandesign.eu/]
 * Firefly is distributed under the terms of the GNU GPL
 *
 * Theme options with `__` prefix (`get_theme_mod( '__option_id' )`) are theme
 * setup related options and can not be edited via customizer. Using this method
 * not to create non-sense multiple options in a database.
 *
 * Custom hooks naming convention:
 * - `wmhook_firefly_` - global (and other, such as plugins related) hooks
 * - `wmhook_fn_firefly_` - theme function specific hooks
 * - For more @see  library/init.php, includes/post-formats/class-post-formats.php
 *
 * Used global hooks:
 * @uses  `wmhook_firefly_theme_options`
 * @uses  `wmhook_firefly_generate_css_replacements`
 * @uses  `wmhook_firefly_esc_css`
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 * @license    GPL-3.0, http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @since    1.0
 * @version  1.0
 *
 * @link  http://www.webmandesign.eu
 *
 * Contents:
 *
 * 1) Required files
 */





/**
 * 1) Required files
 */

	// Global functions

		locate_template( 'library/init.php', true );

	// Theme setup

		locate_template( 'includes/setup/setup.php', true );
