<?php
/**
 * Structure: Loop
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 *
 * Contents:
 *
 * 10) Pagination
 * 20) Loop modifications
 */





/**
 * 10) Pagination
 */

	/**
	 * Pagination
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_pagination() {

		// Requirements check

			// Don't display pagination if Jetpack Infinite Scroll in use

				if ( class_exists( 'The_Neverending_Home_Page' ) ) {
					return;
				}


		// Helper variables

			$output = '';

			$pagination = array(
					'prev_text' => esc_html_x( '&laquo;', 'Pagination text (visible): previous.', 'firefly' ) . ' <span class="screen-reader-text">'
					               . esc_html_x( 'Previous page', 'Pagination text (hidden): previous.', 'firefly' ) . '</span>',
					'next_text' => '<span class="screen-reader-text">' . esc_html_x( 'Next page', 'Pagination text (hidden): next.', 'firefly' )
					               . ' </span>' . esc_html_x( '&raquo;', 'Pagination text (visible): next.', 'firefly' ),
				);


		// Processing

			if ( $output = paginate_links( $pagination ) ) {
				$output = '<nav class="pagination" role="navigation" aria-labelledby="pagination-label">'
				          . '<h2 class="screen-reader-text" id="pagination-label">' . esc_attr__( 'Posts Navigation', 'firefly' ) . '</h2>'
				          . $output
				          . '</nav>';
			}


		// Output

			echo $output;

	} // /firefly_pagination

	add_action( 'wmhook_firefly_postslist_after', 'firefly_pagination', 10 );





	/**
	 * Parted post navigation
	 *
	 * Shim for passing the Theme Check review.
	 * Using table of contents generator instead.
	 *
	 * @see  Firefly_Theme_Framework::add_table_of_contents()
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_link_pages_shim() {

		// Output

			wp_link_pages( array(
					'before'   => '<p class="pagination post-parts">',
					'after'    => '</p>',
					'pagelink' => '<span class="page-numbers">' . esc_html__( 'Part %', 'firefly' ) . '</span>',
				) );

	} // /firefly_link_pages_shim





/**
 * 20) Loop modifications
 */

	/**
	 * Ignore sticky posts in main loop
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  obj $query
	 */
	function firefly_posts_query_ignore_sticky_posts( $query ) {

		// Processing

			if ( $query->is_main_query() ) {
				$query->set( 'ignore_sticky_posts', 1 );
			}

	} // /firefly_posts_query_ignore_sticky_posts

	add_action( 'pre_get_posts', 'firefly_posts_query_ignore_sticky_posts' );
