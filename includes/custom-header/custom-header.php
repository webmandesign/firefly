<?php
/**
 * Custom Header functionality
 *
 * Named as "Banner" in the theme files.
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 *
 * Contents:
 *
 * 10) Custom Header functions
 */





/**
 * 10) Custom Header functions
 */

	/**
	 * Post/page intro title disable
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_post_intro_disable( $pre ) {

		// Helper variables

			$meta_no_title = ( is_singular() ) ? ( get_post_meta( get_the_ID(), 'no_title', true ) ) : ( '' ); // Check if is_singular() to prevent issues in archives


		// Processing

			if (
					(
						is_front_page()
						&& ! is_page()
					)
					|| is_404()
					|| is_page_template( 'templates/no-title.php' )
					|| ! empty( $meta_no_title )
				) {
					return '';
			}


		// Output

			return $pre;

	} // /firefly_post_intro_disable

	add_filter( 'wmhook_fn_firefly_post_intro_pre',            'firefly_post_intro_disable' );
	add_filter( 'wmhook_fn_firefly_post_intro_background_pre', 'firefly_post_intro_disable' );



	/**
	 * Disable featured image display when post intro used
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  mixed $pre
	 */
	function firefly_disable_media_page( $pre ) {

		// Processing

			if (
					is_page( get_the_ID() )
					&& ! is_attachment()
				) {
				$pre = '';
			}


		// Output

			return $pre;

	} // /firefly_disable_media_page

	add_filter( 'wmhook_fn_firefly_post_media_pre', 'firefly_disable_media_page' );



	/**
	 * Post/page intro title
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_post_intro() {

		// Pre

			$pre = apply_filters( 'wmhook_fn_firefly_post_intro_pre', false );

			if ( false !== $pre ) {
				echo $pre;
				return;
			}


		// Helper variables

			$class = 'page-header';

			$posts_page = get_option( 'page_for_posts' );

			$title_paginated_url = ( is_home() && $posts_page ) ? ( get_permalink( $posts_page ) ) : ( get_permalink() );

			$title = ( ! Firefly_Theme_Framework::get_the_paginated_suffix() ) ? ( single_post_title( '', false ) ) : ( '<a href="' . esc_url( $title_paginated_url ) . '">' . single_post_title( '', false ) . '</a>' );
			$title = '<div class="entry-title intro-title">' . $title . '</div>';


		// Processing

			if ( is_archive() ) { // For archive pages.

				$title = '<div class="page-title intro-title">' . get_the_archive_title() . Firefly_Theme_Framework::get_the_paginated_suffix( 'small' ) . '</div>';

			} elseif ( is_search() ) { // For search results.

				$title = '<div class="page-title intro-title">' . sprintf(
						esc_html__( 'Search Results for: %s', 'firefly' ),
						'<span>' . firefly_search_results_title_staff_filter() . '</span>'
					) . Firefly_Theme_Framework::get_the_paginated_suffix( 'small' ) . '</div>';

			} else {

				$class = 'entry-header';

			}

			if ( is_singular() && has_post_thumbnail() ) {
				$class .= ' has-featured-image';
			}


		// Output

			echo '<div id="intro-container" class="' . esc_attr( $class ) . ' intro-container">';

				do_action( 'wmhook_fn_firefly_post_intro_before' );

				echo '<div id="intro" class="intro"><div class="intro-inner">';

					do_action( 'wmhook_fn_firefly_post_intro_top' );

					echo $title;

					if ( is_page() && has_excerpt() ) {
						echo '<div class="page-summary">' . get_the_excerpt() . '</div>';
					}

					do_action( 'wmhook_fn_firefly_post_intro_bottom' );

				echo '</div></div>';

				do_action( 'wmhook_fn_firefly_post_intro_after' );

			echo '</div>';

	} // /firefly_post_intro

	add_action( 'tha_content_top', 'firefly_post_intro', 10 );



	/**
	 * Intro widgets
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_intro_widgets() {

		// Output

			get_sidebar( 'intro' );

	} // /firefly_intro_widgets

	add_action( 'wmhook_fn_firefly_post_intro_after', 'firefly_intro_widgets', 10 );



	/**
	 * Post/page intro title background
	 *
	 * @uses  `wmhook_firefly_esc_css` global hook
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_post_intro_background() {

		// Pre

			$pre = apply_filters( 'wmhook_fn_firefly_post_intro_background_pre', false );

			if ( false !== $pre ) {
				return;
			}


		// Helper variables

			$output = $image_url = '';

			$image_size = 'large';


		// Processing

			// Use featured image when appropriate

				if ( is_singular() ) {

					$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), $image_size );
					$image_url = $image_url[0];

				} elseif ( wp_attachment_is_image() ) {

					$image_url = wp_get_attachment_image_src( get_the_ID(), $image_size );
					$image_url = $image_url[0];

				}

			// Custom Header image fallback
			// Also, filter image URL to allow forcing fallback header image.

				if ( ! apply_filters( 'wmhook_fn_firefly_post_intro_background_image_url', $image_url ) ) {

					$image_url = get_header_image();

					if ( empty( $image_url ) ) {
						$image_url = get_theme_support( 'custom-header', 'default-image' );
					}

				}

			// Preparing CSS output

				$output .= '.intro-container { background-image: url(\'' . esc_url_raw( $image_url ) . '\'); }' . "\r\n\r\n";


		// Output

			if ( $image_url ) {
				wp_add_inline_style( 'firefly-stylesheet', apply_filters( 'wmhook_firefly_esc_css', $output ) );
			}

	} // /firefly_post_intro_background

	add_action( 'wp_enqueue_scripts', 'firefly_post_intro_background', 120 );
