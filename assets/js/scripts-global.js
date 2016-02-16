/**
 * Theme frontend scripts
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 *
 * Contents:
 *
 *  10) Basics
 *  20) Content
 * 100) Others
 */





jQuery( function() {





	/**
	 * 10) Basics
	 */

		/**
		 * Tell CSS that JS is enabled...
		 */

			jQuery( '.no-js' )
				.removeClass( 'no-js' );



		/**
		 * Fixing Recent Comments widget multiple appearances
		 */

			jQuery( '.widget_recent_comments ul' )
				.attr( 'id', '' );



		/**
		 * Back to top buttons
		 */

			if ( 960 < window.innerWidth ) {

				jQuery( '.back-to-top' )
					.on( 'click', function( e ) {

						// Processing

							e.preventDefault();

							jQuery( 'html, body' )
								.animate( {
									scrollTop : 0
								}, 400 );

					} );

			}



		/**
		 * Responsive videos
		 */

			if ( jQuery().fitVids ) {

				jQuery( document.getElementById( 'content' ) )
					.fitVids();

			} // /fitVids





	/**
	 * 20) Content
	 */

		/**
		 * Comment form improvements
		 *
		 * Set input fields placeholders from field labels.
		 * Set textarea rows.
		 */

			jQuery( document.getElementById( 'commentform' ) )
				.find( 'input[type="text"], input[type="email"], input[type="url"], textarea' )
					.each( function( index, el ) {

						// Helper variables

							var $this = jQuery( el );


						// Processing

							$this
								.attr( 'placeholder', $this.prev( 'label' ).text() )
								.prev( 'label' )
									.addClass( 'screen-reader-text' );

					} )
				.end()
				.find( 'textarea' )
					.attr( 'rows', 4 );





	/**
	 * 100) Others
	 */

		/**
		 * On-page anchor smooth scrolling
		 */

			jQuery( 'body' )
				.on( 'click', 'a[href^="#"]', function( e ) {

					// Requirements check

						// Do nothing when editing page with Beaver Builder

							if ( jQuery( 'html' ).hasClass( 'fl-builder-edit' ) ) {
								e.preventDefault();
								return;
							}


					// Helper variables

						var $this         = jQuery( this ),
						    $anchor       = $this.not( '.add-comment-link, .search-toggle, .back-to-top, .skip-link' ).attr( 'href' ),
						    $scrollObject = jQuery( 'html, body' ),
						    $scrollSpeed  = ( 960 >= window.innerWidth ) ? ( 0 ) : ( 600 );


					// Processing

						if (
								$anchor
								&& '#' !== $anchor
								&& ! $this.parent().parent().hasClass( 'wm-tab-links' )
								&& ! $this.hasClass( 'no-smooth-scroll' )
							) {

							e.preventDefault();

							var $scrollOffset = jQuery( '.do-sticky-header #masthead' ).outerHeight() - 1;

							if ( jQuery( '#wpadminbar' ).length ) {
								$scrollOffset += jQuery( '#wpadminbar' ).outerHeight();
							}
							if ( jQuery( '.fl-row.sticky' ).length ) {
								$scrollOffset += jQuery( '.fl-row.sticky' ).eq( 0 ).outerHeight();
							}

							$scrollObject
								.stop()
								.animate( {
									scrollTop : jQuery( $anchor ).offset().top - $scrollOffset + 'px'
								}, $scrollSpeed );

						}

				} );





} );
