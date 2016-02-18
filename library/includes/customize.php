<?php
/**
 * Customizer
 *
 * @package     WebMan WordPress Theme Framework (Simple)
 * @subpackage  Customize
 *
 * @since    1.0
 * @version  1.1
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

		require_once( trailingslashit( get_template_directory() ) . FIREFLY_LIBRARY_DIR . 'includes/classes/class-customize.php' );





/**
 * 10) Init
 */

	add_action( 'after_setup_theme', array( 'Firefly_Theme_Framework_Customize', 'init' ) );
