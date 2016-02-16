<?php
/**
 * Structure: Post
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 *
 * Contents:
 *
 *  1) Helpers
 * 10) Excerpt
 * 20) Post navigation
 * 30) Other post elements
 * 40) HTML attributes
 * 50) Post media
 * 60) Pages
 */





/**
 * 1) Helpers
 */

	/**
	 * Conditional for checking if single post or page is displayed
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_is_singular() {

		// Helper variables

			$post_id = get_the_ID();


		// Output

			return ( is_page( $post_id ) || is_single( $post_id ) );

	} // /firefly_is_singular





/**
 * 10) Excerpt
 */

	add_filter( 'the_excerpt', 'Firefly_Theme_Framework::remove_shortcodes', 10 );



	/**
	 * Excerpt
	 *
	 * Displays the excerpt properly.
	 * If the post is password protected, display a message.
	 * If the post has more tag, display the content appropriately.
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  string $excerpt
	 */
	function firefly_excerpt( $excerpt ) {

		// Requirements check

			if ( post_password_required() ) {
				if ( ! is_single() ) {
					return esc_html__( 'This content is password protected.', 'firefly' ) . ' <a href="' . esc_url( get_permalink() ) . '">' . esc_html__( 'Enter the password to view it.', 'firefly' ) . '</a>';
				}
				return;
			}


		// Processing

			if (
					! is_single()
					&& Firefly_Theme_Framework::has_more_tag()
				) {

				/**
				 * Post has more tag
				 */

					// Required for <!--more--> tag to work

						global $more;

						$more = 0;

					if ( has_excerpt() ) {
						$excerpt = '<p class="entry-summary has-more-tag">' . get_the_excerpt() . '</p>';
					} else {
						$excerpt = '';
					}

					$excerpt = apply_filters( 'the_content', $excerpt . get_the_content( '' ) );

			} else {

				/**
				 * Default excerpt for posts without more tag
				 */

					$excerpt = strtr( $excerpt, apply_filters( 'wmhook_fn_firefly_excerpt_replacements', array( '<p' => '<p class="entry-summary"' ) ) );

			}

			// Adding "Continue reading" link

				if (
						! is_single()
						&& in_array( get_post_type(), apply_filters( 'wmhook_fn_firefly_excerpt_continue_reading_post_type', array( 'post', 'page' ) ) )
					) {
					$excerpt .= apply_filters( 'wmhook_fn_firefly_excerpt_continue_reading', '' );
				}


		// Output

			return $excerpt;

	} // /firefly_excerpt

	add_filter( 'the_excerpt', 'firefly_excerpt', 20 );



	/**
	 * Excerpt length
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  absint $length
	 */
	function firefly_excerpt_length( $length ) {

		// Output

			return 18;

	} // /firefly_excerpt_length

	// add_filter( 'excerpt_length', 'firefly_excerpt_length', 10 );



	/**
	 * Excerpt more
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  string $more
	 */
	function firefly_excerpt_more( $more ) {

		// Output

			return '&hellip;';

	} // /firefly_excerpt_more

	add_filter( 'excerpt_more', 'firefly_excerpt_more', 10 );



	/**
	 * Excerpt "Continue reading" text
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  string $continue
	 */
	function firefly_excerpt_continue_reading( $continue ) {

		// Output

			return '<div class="link-more"><a href="' . esc_url( get_permalink( get_the_ID() ) ) . '" class="more-link">' . sprintf(
					esc_html_x( 'Continue reading%s&hellip;', '%s: Name of current post.', 'firefly' ),
					the_title( '<span class="screen-reader-text"> &ldquo;', '&rdquo;</span>', false )
				) . '</a></div>';

	} // /firefly_excerpt_continue_reading

	add_filter( 'wmhook_fn_firefly_excerpt_continue_reading', 'firefly_excerpt_continue_reading', 10 );





/**
 * 20) Post navigation
 */

	/**
	 * Get previous and next post links
	 *
	 * Since WordPress 4.1 you can use the_post_navigation() and/or get_the_post_navigation().
	 *
	 * Here, we modify the markup by applying custom classes, adding `.meta-nav` labels and
	 * improving accessibility.
	 *
	 * Do not use `_navigation_markup()` as it uses `sanitize_html_class()`, so, we can't
	 * pass multiple classes there.
	 *
	 * @link  https://developer.wordpress.org/reference/functions/_navigation_markup/
	 *
	 * @todo  Transfer to WordPress 4.1+ core functionality.
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_get_the_post_nav() {

		// Pre

			$pre = apply_filters( 'wmhook_fn_firefly_get_the_post_nav_pre', false );

			if ( false !== $pre ) {
				return $pre;
			}


		// Requirements check

			if ( ! is_singular() || is_page() ) {
				return;
			}


		// Helper variables

			$output = $prev_class = $next_class = '';

			$previous = ( is_attachment() ) ? ( get_post( get_post()->post_parent ) ) : ( get_adjacent_post( false, '', true ) );
			$next     = get_adjacent_post( false, '', false );

			// Requirements check

				if (
						( ! $next && ! $previous )
						|| ( is_attachment() && 'attachment' == $previous->post_type )
					) {
					return;
				}

				$links_count = absint( (bool) $next ) + absint( (bool) $previous );


		// Processing

			if ( $previous && has_post_thumbnail( $previous->ID ) ) {
				$prev_class = ' has-post-thumbnail';
			}
			if ( $next && has_post_thumbnail( $next->ID ) ) {
				$next_class = ' has-post-thumbnail';
			}

			if ( is_attachment() ) {

				$output .= get_previous_post_link(
						'<div class="nav-previous nav-link' . esc_attr( $prev_class ) . '">%link</div>',
						wp_kses(
							__( '<span class="meta-nav">Published In</span> <span class="post-title">%title</span>', 'firefly' ),
							array( 'span' => array( 'class' => array() ) )
						)
					);

			} else {

				$output .= get_previous_post_link(
						'<div class="nav-previous nav-link' . esc_attr( $prev_class ) . '">%link</div>',
						wp_kses(
							__( '<span class="meta-nav">Previous</span> <span class="post-title">%title</span>', 'firefly' ),
							array( 'span' => array( 'class' => array() ) )
						)
					);
				$output .= get_next_post_link(
						'<div class="nav-next nav-link' . esc_attr( $next_class ) . '">%link</div>',
						wp_kses(
							__( '<span class="meta-nav">Next</span> <span class="post-title">%title</span>', 'firefly' ),
							array( 'span' => array( 'class' => array() ) )
						)
					);

			}

			if ( $output ) {
				$output = '<nav class="navigation post-navigation links-count-' . esc_attr( $links_count ) . '" role="navigation" aria-labelledby="post-navigation-label"><h2 class="screen-reader-text" id="post-navigation-label">' . esc_html__( 'Post navigation', 'firefly' ) . '</h2><div class="nav-links">' . $output . '</div></nav>';
			}


		// Output

			return $output;

	} // /firefly_get_the_post_nav



		/**
		 * Display previous and next post links
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		function firefly_the_post_nav() {

			// Helper variables

				$output = firefly_get_the_post_nav();


			// Output

				if ( $output ) {
					echo $output;
				}

		} // /firefly_the_post_nav





/**
 * 30) Other post elements
 */

	/**
	 * Single post title paged
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  string $title
	 * @param  object $post
	 */
	function firefly_single_post_title( $title, $post ) {

		// Helper variables

			$suffix = Firefly_Theme_Framework::get_the_paginated_suffix();

			// Strip tags when using in `wp_head`

				if ( doing_action( 'wp_head' ) ) {
					$suffix = strip_tags( $suffix );
				}


		// Output

			return $title . $suffix;

	} // /firefly_single_post_title

	add_filter( 'single_post_title', 'firefly_single_post_title', 10, 2 );



	/**
	 * Post/page heading (title)
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  array $args Heading setup arguments
	 */
	function firefly_post_title( $args = array() ) {

		// Pre

			$pre = apply_filters( 'wmhook_fn_firefly_post_title_pre', false, $args );

			if ( false !== $pre ) {
				return $pre;
			}


		// Requirements check

			if ( ! ( $title = get_the_title() ) ) {
				return;
			}


		// Helper variables

			$output = '';

			$args = wp_parse_args( $args, apply_filters( 'wmhook_fn_firefly_post_title_defaults', array(
					'addon'           => '',
					'class'           => 'entry-title',
					'class_container' => 'entry-header',
					'link'            => esc_url( get_permalink() ),
					'output'          => '<header class="{class_container}"><{tag} class="{class}"' . firefly_schema_org( 'name' ) . '>{title}</{tag}>{addon}</header>',
					'tag'             => ( firefly_is_singular() ) ? ( 'h1' ) : ( 'h2' ),
					'title'           => '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $title . '</a>',
				) ) );

			// Screen reader enabled title only

				$screen_reader_only = array( 'link', 'quote', 'status' );

				if (
						! is_single()
						&& has_excerpt()
					) {
					$screen_reader_only[] = 'image';
				}

				if (
						in_array( get_post_format(), $screen_reader_only )
						|| is_page( get_the_ID() )
						|| is_singular( 'wm_staff' )
					) {
					$args['class_container'] .= ' screen-reader-text';
				}

			// Singular title (no link applied)

				if (
						is_single()
						|| ( is_page() && 'page' === get_post_type() ) // Do not display stuff below on posts list on static front page
					) {

					if ( $suffix = Firefly_Theme_Framework::get_the_paginated_suffix( 'small' ) ) {
						$args['title'] .= $suffix;
					} else {
						$args['title'] = $title;
					}

				}

			// Addon

				// Post date in post header on single post page

					if ( is_singular( 'post' ) ) {

						$time_html = '<span class="{class}"{attributes}>{description}'
						             . '<time datetime="' . esc_attr( get_the_date( 'c' ) ) . '" class="published" title="' . esc_attr( get_the_date() ) . ' | ' . esc_attr( get_the_time( '' ) ) . '"' . firefly_schema_org( '   datePublished' ) . '>'
						             . '<span class="day">' . esc_html( get_the_date( 'd' ) ) . '</span> '
						             . '<span class="month">' . esc_html( get_the_date( 'M' ) ) . '</span> '
						             . '<span class="year">' . esc_html( get_the_date( 'Y' ) ) . '</span>'
						             . '</time>'
						             . '</span>';

						$args['addon'] = Firefly_Theme_Framework::get_the_post_meta_info( array(
								'container'   => 'div',
								'meta'        => array( 'date' ),
								'html_custom' => array( 'date' => $time_html ),
							) );

					}

			// Filter processed $args

				$args = apply_filters( 'wmhook_fn_firefly_post_title_args', $args );


		// Processing

			$replacements = (array) apply_filters( 'wmhook_fn_firefly_post_title_replacements', array(
					'{addon}'           => $args['addon'],
					'{class}'           => esc_attr( $args['class'] ),
					'{class_container}' => esc_attr( $args['class_container'] ),
					'{tag}'             => tag_escape( $args['tag'] ),
					'{title}'           => do_shortcode( $args['title'] ),
				), $args );


		// Output

			echo strtr( $args['output'], $replacements );

	} // /firefly_post_title

	add_action( 'tha_entry_top', 'firefly_post_title', 20 );



	/**
	 * Post meta bottom
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_post_meta_bottom() {

		// Helper variables

			$time_html = '<span class="{class}"{attributes}>{description}'
			             . '<time datetime="' . esc_attr( get_the_date( 'c' ) ) . '" class="published" title="' . esc_attr( get_the_date() ) . ' | ' . esc_attr( get_the_time( '' ) ) . '"' . firefly_schema_org( '   datePublished' ) . '>'
			             . '<span class="day">' . esc_html( get_the_date( 'd' ) ) . '</span> '
			             . '<span class="month">' . esc_html( get_the_date( 'M' ) ) . '</span> '
			             . '<span class="year">' . esc_html( get_the_date( 'Y' ) ) . '</span>'
			             . '</time>'
			             . '</span>';


		// Output

			if ( in_array( get_post_type(), (array) apply_filters( 'wmhook_fn_firefly_post_meta_bottom_post_type', array( 'post' ) ) ) ) {

				if ( is_single() ) {

					$args = array(
							'container' => 'footer',
							'meta'      => array( 'category', 'author', 'comments', 'likes' ),
						);

					Firefly_Theme_Framework::the_post_meta_info( apply_filters( 'wmhook_fn_firefly_post_meta_top_args', $args ) );

					echo '<div class="clear"></div>'; // Required to clear floats for special blog post layout

				} else {

					Firefly_Theme_Framework::the_post_meta_info( apply_filters( 'wmhook_fn_firefly_post_meta_bottom_args', array(
							'container'   => 'footer',
							'meta'        => array( 'date', 'comments', 'likes' ),
							'html_custom' => array( 'date' => $time_html ),
						) ) );

				}

			}

	} // /firefly_post_meta_bottom

	add_action( 'tha_entry_bottom', 'firefly_post_meta_bottom', 10 );



	/**
	 * Post comments
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_post_comments() {

		// Output

			comments_template( '', true );

	} // /firefly_post_comments

	add_action( 'tha_entry_bottom', 'firefly_post_comments', 20 );



	/**
	 * Post navigation
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_post_navigation() {

		// Output

			if ( in_array( get_post_type(), apply_filters( 'wmhook_fn_firefly_post_navigation_post_type', array( 'post' ) ) ) ) {

				firefly_the_post_nav();

			}

	} // /firefly_post_navigation

	add_action( 'tha_entry_bottom', 'firefly_post_navigation', 30 );



	/**
	 * Skip links: Entry bottom
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_skip_links_entry_bottom() {

		// Processing

			$output = Firefly_Theme_Framework::link_skip_to( 'site-navigation', __( 'Skip back to navigation', 'firefly' ), 'focus-position-static' );


		// Output

			echo $output;

	} // /firefly_skip_links_entry_bottom

	add_action( 'tha_entry_bottom', 'firefly_skip_links_entry_bottom', 999 );





/**
 * 40) HTML attributes
 */

	/**
	 * Post classes
	 *
	 * Compatible with NS Featured Posts plugin.
	 * @link  https://wordpress.org/plugins/ns-featured-posts/
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  array $classes
	 */
	function firefly_post_classes( $classes ) {

		// Processing

			// Sticky post

				/**
				 * On paginated posts list the sticky class is not
				 * being applied, so, we need to compensate.
				 */
				if ( is_sticky() ) {
					$classes[] = 'is-sticky';
				}

			// Featured post

				if (
						class_exists( 'NS_Featured_Posts' )
						&& get_post_meta( get_the_ID(), '_is_ns_featured_post', true )
					) {
					$classes[] = 'is-featured';
				}


		// Output

			return $classes;

	} // /firefly_post_classes

	add_filter( 'post_class', 'firefly_post_classes', 98 );



	/**
	 * Schema.org function wrapper
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  string  $element
	 * @param  boolean $output_meta_tag
	 */
	function firefly_schema_org( $element = '', $output_meta_tag = false ) {

		// Pre

			$pre = apply_filters( 'wmhook_fn_firefly_schema_org_pre', false, $element, $output_meta_tag );

			if ( false !== $pre ) {
				return $pre;
			}


		// Requirements check

			if ( empty( $element ) ) {
				return;
			}


		// Helper variables

			$output = '';

			$base    = esc_attr( apply_filters( 'wmhook_firefly_schema_org_base', 'http://schema.org/', $element, $output_meta_tag ) );
			$post_id = ( is_home() ) ? ( get_option( 'page_for_posts' ) ) : ( null );
			$type    = get_post_meta( $post_id, 'schemaorg_type', true );

			// Add custom post types that describe a single item to this array

				$creative_work_array = (array) apply_filters( 'wmhook_firefly_schema_org_creative_work_array', array( 'jetpack-portfolio' ), $element, $output_meta_tag );


		// Processing

			switch ( $element ) {

				case 'author':
						$output = 'itemprop="author"';
					break;

				case 'BreadcrumbList':
						$output = 'itemscope itemtype="' . $base . 'BreadcrumbList"';
					break;

				case 'datePublished':
						$output = 'itemprop="datePublished"';
					break;

				case 'entry':
						$output = 'itemscope ';

						if ( is_page() ) {
							$output .= 'itemtype="' . $base . 'WebPage"';

						} elseif ( is_singular( $creative_work_array ) ) {
							$output .= 'itemprop="workExample" itemtype="' . $base . 'CreativeWork"';

						} elseif ( 'audio' === get_post_format() ) {
							$output .= 'itemtype="' . $base . 'AudioObject"';

						} elseif ( 'gallery' === get_post_format() ) {
							$output .= 'itemprop="ImageGallery" itemtype="' . $base . 'ImageGallery"';

						} elseif ( 'video' === get_post_format() ) {
							$output .= 'itemprop="video" itemtype="' . $base . 'VideoObject"';

						} else {
							$output .= 'itemprop="blogPost" itemtype="' . $base . 'BlogPosting"';

						}
					break;

				case 'entry_body':
						if ( ! is_single() ) {
							$output = 'itemprop="description"';

						} elseif ( is_page() ) {
							$output = 'itemprop="mainContentOfPage"';

						} else {
							$output = 'itemprop="articleBody"';

						}
					break;

				case 'image':
						$output = 'itemprop="image"';
					break;

				case 'ItemList':
						$output = 'itemscope itemtype="' . $base . 'ItemList"';
					break;

				case 'keywords':
						$output = 'itemprop="keywords"';
					break;

				case 'name':
						$output = 'itemprop="name"';
					break;

				case 'Person':
						$output = 'itemscope itemtype="' . $base . 'Person"';
					break;

				case 'SiteNavigationElement':
						$output = 'itemscope itemtype="' . $base . 'SiteNavigationElement"';
					break;

				case 'url':
						$output = 'itemprop="url"';
					break;

				case 'WebPage':
						$output .= 'itemscope itemtype="' . $base . 'WebPage"';
					break;

				case 'WPFooter':
						$output = 'itemscope itemtype="' . $base . 'WPFooter"';
					break;

				case 'WPSideBar':
						$output = 'itemscope itemtype="' . $base . 'WPSideBar"';
					break;

				case 'WPHeader':
						$output = 'itemscope itemtype="' . $base . 'WPHeader"';
					break;

				default:
						$output = $element;
					break;

			} // /switch

			$output = ' ' . $output;

			// Output in <meta> tag

				if ( $output_meta_tag ) {
					if ( false === strpos( $output, 'content=' ) ) {
						$output .= ' content="true"';
					}
					$output = '<meta ' . trim( $output ) . ' />';
				}


		// Output

			return $output;

	} // /firefly_schema_org



	/**
	 * Entry container attributes
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_entry_container_atts() {

		// Output

			return (string) firefly_schema_org( 'entry' );

	} // /firefly_entry_container_atts

	add_filter( 'wmhook_firefly_entry_container_atts', 'firefly_entry_container_atts', 10 );





/**
 * 50) Post media
 */

	/**
	 * Post thumbnail (featured image) display size
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  string $image_size
	 */
	function firefly_post_thumbnail_size( $image_size ) {

		// Output

			return 'thumbnail';

	} // /firefly_post_thumbnail_size

	add_filter( 'wmhook_firefly_post_media_image_size', 'firefly_post_thumbnail_size', 10 );



	/**
	 * Post formats media
	 */

		/**
		 * Featured image
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		function firefly_post_media() {

			// Pre

				$pre = apply_filters( 'wmhook_fn_firefly_post_media_pre', false );

				if ( false !== $pre ) {
					echo $pre;
					return;
				}


			// Requirements check

				if ( Firefly_Theme_Framework::get_the_paginated_suffix( 'small', 'post' ) ) {
					return;
				}


			// Helper variables

				$output = '';
				$class  = 'entry-media';

				$image_size = apply_filters( 'wmhook_fn_firefly_post_media_image_size', 'thumbnail' );


			// Processing

				if ( ! is_single() ) {

					switch ( get_post_format() ) {

						case 'audio':
							$output .= firefly_post_audio( $image_size );
							break;

						case 'gallery':
							$output .= firefly_post_gallery( $image_size );
							break;

						case 'video':
							$output .= firefly_post_video( $image_size );
							break;

						default:
							$output .= firefly_post_image_featured( $image_size );
							break;

					}

				} else {

					$output .= firefly_post_image_featured( $image_size );

				}


			// Output

				if ( $output ) {
					echo '<div class="' . esc_attr( $class ) . '">' . $output . '</div>';
				}

		} // /firefly_post_thumbnail_size

		add_action( 'tha_entry_top', 'firefly_post_media', 10 );



		/**
		 * Featured image
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  string $image_size
		 */
		function firefly_post_image_featured( $image_size ) {

			// Pre

				$pre = apply_filters( 'wmhook_fn_firefly_post_image_featured_pre', false, $image_size );

				if ( false !== $pre ) {
					return $pre;
				}


			// Helper variables

				$output = '';

				$image_id = ( is_attachment() ) ? ( get_the_ID() ) : ( get_post_thumbnail_id() );


			// Processing

				if (
						has_post_thumbnail()
						|| is_attachment()
					) {

					$image_link = ( is_single() || is_attachment() ) ? ( wp_get_attachment_image_src( $image_id, 'full' ) ) : ( array( esc_url( get_permalink() ) ) );
					$image_link = array_filter( (array) apply_filters( 'wmhook_fn_firefly_post_image_featured_link', $image_link ) );

					$output .= '<figure class="post-thumbnail"' . firefly_schema_org( 'image' ) . '>';

						if ( ! empty( $image_link ) ) {
							$output .= '<a href="' . esc_url( $image_link[0] ) . '">';
						}

						if ( is_attachment() ) {

							$output .= wp_get_attachment_image(
									$image_id,
									(string) $image_size
								);

						} else {

							$output .= get_the_post_thumbnail(
									null,
									(string) $image_size
								);

						}

						if ( ! empty( $image_link ) ) {
							$output .= '</a>';
						}

					$output .= '</figure>';

				}


			// Output

				return $output;

		} // /firefly_post_image_featured



		/**
		 * Gallery
		 *
		 * Displays images from gallery first.
		 * If no gallery exists, displays featured image.
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  string $image_size
		 */
		function firefly_post_gallery( $image_size ) {

			// Pre

				$pre = apply_filters( 'wmhook_fn_firefly_post_gallery_pre', false, $image_size );

				if ( false !== $pre ) {
					return $pre;
				}


			// Helper variables

				$output = '';

				$post_media = array_filter( array_slice( explode( ',', (string) Firefly_Post_Formats::get() ), 0, 3 ) ); // Get only 3 images from gallery


			// Processing

				if (
						is_array( $post_media )
						&& ! empty( $post_media )
					) {

					$output .= '<div class="image-count-' . absint( count( $post_media ) ) . '">';
					$output .= '<a href="' . esc_url( get_permalink() ) . '">';

					foreach( $post_media as $image_id ) {
						$output .= wp_get_attachment_image( absint( $image_id ), $image_size );
					}

					$output .= '</a>';
					$output .= '</div>';

				} else {

					$output .= firefly_post_image_featured( $image_size );

				}


			// Output

				return $output;

		} // /firefly_post_gallery



		/**
		 * Audio
		 *
		 * Displays featured image only if it's a shortcode
		 * and it's not a playlist shortcode.
		 * After the image it displays audio player.
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  string $image_size
		 */
		function firefly_post_audio( $image_size ) {

			// Pre

				$pre = apply_filters( 'wmhook_fn_firefly_post_audio_pre', false, $image_size );

				if ( false !== $pre ) {
					return $pre;
				}


			// Helper variables

				$output = '';

				$post_media = (string) Firefly_Post_Formats::get();

				$is_shortcode = ( 0 === strpos( $post_media, '[' ) );


			// Processing

				if (
						false === strpos( $post_media, '[playlist' )
						|| ! $is_shortcode
					) {

					$output .= firefly_post_image_featured( $image_size );

				}

				if ( $post_media ) {

					if ( $is_shortcode ) {

						$post_media = do_shortcode( $post_media );

					} else {

						$post_media = wp_oembed_get( $post_media );

					}

					$output .= $post_media;

				}


			// Output

				return $output;

		} // /firefly_post_audio



		/**
		 * Video
		 *
		 * @since    1.0
		 * @version  1.0
		 *
		 * @param  string $image_size
		 */
		function firefly_post_video( $image_size ) {

			// Pre

				$pre = apply_filters( 'wmhook_fn_firefly_post_video_pre', false, $image_size );

				if ( false !== $pre ) {
					return $pre;
				}


			// Helper variables

				$output = '';

				$post_media = (string) Firefly_Post_Formats::get();


			// Processing

				if ( $post_media ) {

					if ( 0 === strpos( $post_media, '[' ) ) {

						$post_media = do_shortcode( $post_media );

					} else {

						/**
						 * Filter the oEmbed HTML
						 *
						 * This is to provide compatibility with Jetpack Responsive Videos.
						 *
						 * By default there is no filter hook in `wp_oembed_get()` that Jetpack
						 * Responsive Videos hooks onto, that's why we need to add it here.
						 *
						 * @param  mixed  $html    The HTML output.
						 * @param  string $url     The attempted embed URL (the $post_media variable).
						 * @param  array  $attr    An array of shortcode attributes.
						 * @param  int    $post_id Post ID.
						 */
						$post_media = apply_filters( 'embed_oembed_html', wp_oembed_get( $post_media ), $post_media, array(), get_the_ID() );

					}

					$output .= $post_media;

				} else {

					$output .= firefly_post_image_featured( $image_size );

				}


			// Output

				return $output;

		} // /firefly_post_video





/**
 * 60) Pages
 */

	/**
	 * Subpages as features
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_page_children( $image_size ) {

		// Requirements check

			if ( ! is_page() ) {
				return;
			}


		// Helper variables

			$output = '';

			$child_pages = array_filter( (array) get_pages( array(
					'nopaging'     => true,
					'sort_column'  => 'menu_order',
					'hierarchical' => false,
					'parent'       => get_the_ID(),
				) ) );


		// Processing

			if ( ! empty( $child_pages ) ) {

				$output .= '<section class="list-features-container">';
				$output .= '<div class="list-features">';

				foreach ( $child_pages as $child ) {

					$child_id = absint( $child->ID );

					$output .= '<article role="article" id="post-' . esc_attr( $child_id ) . '" class="feature post-<' . esc_attr( $child_id ) . '">';

					// Featured image

						if ( has_post_thumbnail( $child_id ) ) {

							$output .= '<div class="feature-image">' . wp_get_attachment_image(
									get_post_thumbnail_id( $child_id ),
									(string) apply_filters( 'wmhook_fn_firefly_page_children_image_size', 'thumbnail' )
								) . '</div>';

						}

					// Title

						$output .= '<h2 class="feature-title">' . get_the_title( $child_id ) . '</h2>';

					// Content

						$output .= '<div class="feature-content">' . apply_filters( 'the_content', $child->post_content ) . '</div>';

					$output .= '</article>';

				} // /foreach

				$output .= '</div>';
				$output .= '</section>';

			}


		// Output

			echo $output;

	} // /firefly_page_children

	add_action( 'tha_content_top', 'firefly_page_children', 20 );