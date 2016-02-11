<?php
/**
 * Image attachment template
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 */





get_header();

	while ( have_posts() ) : the_post();

		get_template_part( 'template-parts/content', 'attachment-image' );

	endwhile;

	get_sidebar();

get_footer();
