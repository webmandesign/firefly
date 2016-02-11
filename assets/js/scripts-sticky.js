/**
 * Sticky header and row
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 */





jQuery( function() {

	if (
			jQuery( 'body' ).hasClass( 'do-sticky-header' )
			&& 1200 < window.innerWidth
		) {





		/**
		 * Scrolling classes on BODY
		 */

			/**
			 * Sticky header
			 */

				var $window                                  = jQuery( window ),
				    $body                                    = jQuery( 'body' ),
				    $fireflyDidScroll              = false,
				    $fireflyLastScrollTop          = 0,
				    $fireflyHeaderHeightMultiplier = 2,
				    $fireflyHeader                 = jQuery( document.getElementById( 'masthead' ) ),
				    $fireflyHeaderHeight           = $fireflyHeader.outerHeight(),
				    $fireflyHeaderOffset           = $fireflyHeader.offset(),
				    $fireflyScrollingOffset        = $fireflyHeaderHeight * $fireflyHeaderHeightMultiplier + $fireflyHeaderOffset.top,
				    $fireflyScreenResized          = true;

			/**
			 * Create site header placeholder
			 */

				jQuery( '<div id="site-header-placeholder" class="site-header-placeholder" />' )
					.insertBefore( '#masthead' );

			/**
			 * Fire on browser window scroll
			 *
			 * Reset on browser window resize.
			 */

				$window
					.on( 'resize orientationchange', function( e ) {

						// Processing

							$fireflyDidScroll       = false;
							$fireflyLastScrollTop   = 0;
							$fireflyHeaderHeight    = $fireflyHeader.outerHeight();
							$fireflyScrollingOffset = $fireflyHeaderHeight * $fireflyHeaderHeightMultiplier + $fireflyHeaderOffset.top;
							$fireflyScreenResized   = true;

					} )
					.on( 'scroll', function( e ) {

						// Processing

							$fireflyDidScroll = true;

					} );

				setInterval( function() {

					// Processing

						if ( $fireflyDidScroll ) {

							fireflyHasScrolled();

							$fireflyDidScroll = false;

						}

				}, 250 );



			/**
			 * Actions when scrolling screen
			 */
			function fireflyHasScrolled() {

				// Requirements check

					if (
							$fireflyScreenResized
							&& 960 > window.innerWidth
						) {
						return;
					}


				// Helper variables

					var $st = $window.scrollTop();


				// Processing

					// Do nothing and remove the scrolling class when not scrolled enough

						if ( $st < $fireflyScrollingOffset ) {

							$body
								.removeClass( 'scrolling-up scrolling-down has-scrolled' );

							// Setting up global vars

								$fireflyLastScrollTop = $st;
								$fireflyScreenResized = false;

							return;

						}

					// Apply the scrolling class

						$body
							.addClass( 'has-scrolled' );

						if ( $st < $fireflyLastScrollTop ) {

							$body
								.addClass( 'scrolling-up' )
								.removeClass( 'scrolling-down' );

						} else {

							$body
								.removeClass( 'scrolling-up' )
								.addClass( 'scrolling-down' );

						}

					// Setting sticky header placeholder height

						jQuery( document.getElementById( 'site-header-placeholder' ) )
							.css( 'height', $fireflyHeaderHeight );

					// Setting up global vars

						$fireflyLastScrollTop = $st;
						$fireflyScreenResized = false;

			} // /fireflyHasScrolled



		/**
		 * Sticky row
		 */

			if ( jQuery( '.fl-row.sticky' ).length ) {

				var $page      = document.getElementById( 'page' ),
				    $sticky    = jQuery( '.fl-row.sticky' ).eq( 0 ),
				    $stickyTop = $sticky.offset().top;

				$stickyTop -= $header.outerHeight() + $adminBarHeight;

				function stickyRow() {

					// Processing

						if ( $window.scrollTop() >= $stickyTop ) {

							$sticky
								.css( 'height', $sticky.outerHeight() + 'px' )
								.addClass( 'sticky-enabled' );

						} else {

							$sticky
								.css( 'height', 'auto' )
								.removeClass( 'sticky-enabled' );

						}

				} // /stickyRow

				stickyRow();

				$window
					.scroll( stickyRow );

			}





	} // /do-sticky-header

} );
