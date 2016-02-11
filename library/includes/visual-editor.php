<?php
/**
 * Visual editor addons
 *
 * @package     WebMan WordPress Theme Framework (Simple)
 * @subpackage  Visual Editor
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

	// Visual Editor class

		locate_template( FIREFLY_LIBRARY_DIR . 'includes/classes/class-visual-editor.php', true );





/**
 * 10) Init
 */

	add_action( 'init', array( 'Firefly_Theme_Framework_Visual_Editor', 'init' ) );
