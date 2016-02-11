<?php
/**
 * Customizer
 *
 * @package     WebMan WordPress Theme Framework (Simple)
 * @subpackage  Customize
 *
 * @since    1.0
 * @version  1.0.13
 *
 * Contents:
 *
 *  1) Required files
 * 10) Init
 */





/**
 * 1) Required files
 */

	// Theme options arrays

		locate_template( FIREFLY_INCLUDES_DIR . 'theme-options/theme-options.php', true );

	// Visual Editor class

		locate_template( FIREFLY_LIBRARY_DIR . 'includes/classes/class-customize.php', true );





/**
 * 10) Init
 */

	add_action( 'after_setup_theme', array( 'Firefly_Theme_Framework_Customize', 'init' ) );
