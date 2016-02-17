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
 * 10) Basics
 * 20) Content
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





} );
