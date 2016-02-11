<?php
/**
 * Page template
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 */





get_header();

	while ( have_posts() ) : the_post();

		get_template_part( 'template-parts/content', 'page' );

	endwhile;

get_footer();
