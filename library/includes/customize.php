<?php
/**
 * Customizer
 *
 * @package     WebMan WordPress Theme Framework (Simple)
 * @subpackage  Customize
 *
 * @since    1.0
 * @version  1.0.16
 *
 * Contents:
 *
 *  1) Required files
 * 10) Init
 */





/**
 * 1) Required files
 */

	// Customizer class

		locate_template( FIREFLY_LIBRARY_DIR . 'includes/classes/class-customize.php', true );





/**
 * 10) Init
 */

	add_action( 'after_setup_theme', array( 'Firefly_Theme_Framework_Customize', 'init' ) );
