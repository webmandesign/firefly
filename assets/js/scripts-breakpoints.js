/**
 * Script for getting responsive breakpoints from CSS
 *
 * @link  https://www.lullabot.com/articles/importing-css-breakpoints-into-javascript
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 */





// Global space

	var $fireflyBreakpoint = {};

	$fireflyBreakpoint.refreshValue = function() {

			// Processing

				this.value = window
					.getComputedStyle( document.querySelector( 'body' ), ':before' )
					.getPropertyValue( 'content' )
					.replace( /['"]+/g, '' );

		};



// Refresh on screen resize/orientation change

	jQuery( function() {

		jQuery( window )
			.on( 'resize orientationchange', function( e ) {

				// Processing

					$fireflyBreakpoint
						.refreshValue();

			} )
			.resize();

	} );
