<?php
/**
 * Visual editor addons
 *
 * @package     WebMan WordPress Theme Framework (Simple)
 * @subpackage  Visual Editor
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

	// Visual Editor class

		require_once( trailingslashit( get_template_directory() ) . FIREFLY_LIBRARY_DIR . 'includes/classes/class-visual-editor.php' );





/**
 * 10) Init
 */

	add_action( 'init', array( 'Firefly_Theme_Framework_Visual_Editor', 'init' ) );
