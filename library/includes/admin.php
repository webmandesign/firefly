<?php
/**
 * Admin functions
 *
 * @package     WebMan WordPress Theme Framework
 * @subpackage  Admin
 *
 * @since    1.2
 * @version  1.2
 *
 * Contents:
 *
 *  0) Requirements check
 *  1) Required files
 * 10) Init
 */





/**
 * 0) Requirements check
 */

	if ( ! is_admin() ) {
		return;
	}





/**
 * 1) Required files
 */

	// Load the theme About page if it exists

		locate_template( FIREFLY_INCLUDES_DIR . 'admin/about-page/about-page.php', true );

	// Admin class

		require_once( trailingslashit( get_template_directory() ) . FIREFLY_LIBRARY_DIR . 'includes/classes/class-admin.php' );





/**
 * 10) Init
 */

	add_action( 'admin_init', array( 'Firefly_Theme_Framework_Admin', 'init' ) );
