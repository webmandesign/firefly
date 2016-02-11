<?php
/**
 * Search results template
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 */





get_header();

	?>

	<section id="search-results-listing" class="search-results-listing content-container">

		<?php if ( have_posts() ) : ?>

		<header class="page-header">

			<h1 class="page-title"><?php

				printf(
					esc_html__( 'Search Results for: %s', 'firefly' ),
					'<span>' . get_search_query() . '</span>'
				);

			?></h1>

		</header>

		<?php endif; ?>

		<?php get_template_part( 'template-parts/loop', 'search' ); ?>

	</section>

	<?php

	get_sidebar();

get_footer();
