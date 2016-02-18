<?php
/**
 * Website header template
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 */





/**
 * HTML
 */

	do_action( 'tha_html_before' );

?>

<html class="no-js" <?php language_attributes(); ?>>

<head>

<?php

/**
 * HTML head
 */

	do_action( 'tha_head_top' );

	do_action( 'tha_head_bottom' );

	wp_head();

?>

</head>


<body <?php body_class(); echo firefly_schema_org( 'WebPage' ); ?>>

<?php

/**
 * Body
 */

	do_action( 'tha_body_top' );



/**
 * Header
 */

	if ( ! apply_filters( 'wmhook_firefly_disable_header', false ) ) {

		do_action( 'tha_header_before' );

		do_action( 'tha_header_top' );

		do_action( 'tha_header_bottom' );

		do_action( 'tha_header_after' );

	}



/**
 * Content
 */

	do_action( 'tha_content_before' );

	do_action( 'tha_content_top' );
