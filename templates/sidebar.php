<?php
/**
 * Custom page template
 *
 * Template Name: With sidebar
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 */

/* translators: Custom page template name. */
__( 'With sidebar', 'firefly' );





get_header();

	while ( have_posts() ) : the_post();

		get_template_part( 'template-parts/content', 'page' );

	endwhile;

	get_sidebar();

get_footer();
