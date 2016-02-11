<?php
/**
 * Error 404 page template
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 */





get_header();

	?>

	<section id="error-404" class="error-404 not-found">

		<header class="page-header">

			<h1 class="page-title"><?php esc_html_e( 'Oops! That page can not be found.', 'firefly' ); ?></h1>

		</header>

		<div class="page-content">

			<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'firefly' ); ?></p>

			<?php get_search_form(); ?>

			<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

			<?php if ( Firefly_Theme_Framework::is_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>

			<div class="widget widget_categories">
				<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'firefly' ); ?></h2>
				<ul>
					<?php

					wp_list_categories( array(
							'orderby'    => 'count',
							'order'      => 'DESC',
							'show_count' => 1,
							'title_li'   => '',
							'number'     => 10,
						) );

					?>
				</ul>
			</div><!-- .widget -->

			<?php endif; ?>

			<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>

		</div>

	</section>

	<?php

get_footer();
