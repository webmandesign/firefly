/**
 * Customize preview scripts
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 */





jQuery( function() {





	/**
	 * Site title and description.
	 */

		wp.customize( 'blogname', function( value ) {

			// Processing

				value
					.bind( function( to ) {

						jQuery( '.site-title span' )
							.text( to );

					} );

		} ); // /blogname

		wp.customize( 'blogdescription', function( value ) {

			// Processing

				value
					.bind( function( to ) {

						jQuery( '.site-description' )
							.text( to );

					} );

		} ); // /blogdescription





} );
