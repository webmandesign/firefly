/**
 * Masonry layouts
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 */





jQuery( function() {

	if ( jQuery().masonry ) {





		/**
		 * Masonry posts
		 *
		 * @see  http://masonry.desandro.com/options.html#columnwidth
		 */

			var $fireflyPostsContainers = jQuery( '.posts' ),
			    $fireflyMasonryColWidth = '.hentry:nth-child(2)';

			if ( ! $fireflyPostsContainers.find( $fireflyMasonryColWidth ).length ) {
				$fireflyMasonryColWidth = '.hentry:first-child';
			}

			$fireflyPostsContainers
				.imagesLoaded( function() {

					// Processing

						$fireflyPostsContainers
							.masonry( {
								itemSelector : '.hentry',
								columnWidth  : $fireflyMasonryColWidth
							} );

				} );



			/**
			 * Jetpack Infinite Scroll posts loading
			 */

				jQuery( document.body )
					.on( 'post-load', function() {

						// Processing

							$fireflyPostsContainers
								.imagesLoaded( function() {

									// Processing

										$fireflyPostsContainers
											.masonry( 'reload' );

								} );

					} );



		/**
		 * Masonry footer
		 */

			var $fireflyFooterWidgets = jQuery( document.getElementById( 'footer-widgets' ) );

			if ( $fireflyFooterWidgets.length ) {

				var $fireflyFooterWidgetsColumns = $fireflyFooterWidgets.data( 'columns' );

				if (
						1 < $fireflyFooterWidgetsColumns
						&& $fireflyFooterWidgetsColumns < $fireflyFooterWidgets.data( 'widgets-count' )
					) {

					var $fireflyFooterWidgets = jQuery( document.getElementById( 'footer-widgets-container' ) );

					$fireflyFooterWidgets
						.imagesLoaded( function() {

							// Processing

								$fireflyFooterWidgets
									.masonry( {
										itemSelector : '.widget'
									} );

						} );



					/**
					 * Jetpack Infinite Scroll posts loading
					 */

						jQuery( document.body )
							.on( 'post-load', function() {

								// Processing

									setTimeout( function() {

										// Processing

											$fireflyFooterWidgets
												.masonry( 'reload' );

									}, 100 );

							} );

				}

			} // /if footer widgets displayed





	} // /masonry

} );
