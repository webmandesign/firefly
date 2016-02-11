/**
 * Accessible navigation
 *
 * @link  http://a11yproject.com/
 * @link  https://codeable.io/community/wordpress-accessibility-creating-accessible-dropdown-menus/
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 *
 * Contents:
 *
 * 10) Accessibility
 * 20) Mobile navigation
 */





jQuery( function() {





	/**
	 * Cache
	 */

		var $fireflySiteNavigation   = jQuery( document.getElementById( 'site-navigation' ) ),
		    $fireflySiteMenuPrimary  = jQuery( document.getElementById( 'menu-primary' ) ),
		    $fireflyMenuToggleButton = jQuery( '#menu-toggle, #menu-toggle-bar' );





	/**
	 * 10) Accessibility
	 */

		/**
		 * Adding ARIA attributes
		 */

			$fireflySiteNavigation
				.find( 'li' )
					.attr( 'role', 'menuitem' );

			$fireflySiteNavigation
				.find( '.menu-item-has-children' )
					.attr( 'aria-haspopup', 'true' );

			$fireflySiteNavigation
				.find( '.sub-menu' )
					.attr( 'role', 'menu' );



		/**
		 * Setting `.focus` class for menu parent
		 */

			$fireflySiteNavigation
				.on( 'focus.aria mouseenter.aria', '.menu-item-has-children', function( e ) {

					// Processing

						jQuery( e.currentTarget )
							.addClass( 'focus' );

				} );

			$fireflySiteNavigation
				.on( 'blur.aria mouseleave.aria', '.menu-item-has-children', function( e ) {

					// Processing

						jQuery( e.currentTarget )
							.removeClass( 'focus' );

				} );



		/**
		 * Touch-enabled
		 */

			$fireflySiteNavigation
				.on( 'touchstart click', '.menu-item-has-children > a .expander', function( e ) {

					// Helper variables

						var $this = jQuery( this ).parent().parent(); // Get the LI element


					// Processing

						e.preventDefault();

						$this
							.toggleClass( 'focus' )
							.siblings()
								.removeClass( 'focus' );

				} );



		/**
		 * Menu navigation with arrow keys
		 */

			$fireflySiteNavigation
				.on( 'keydown', 'a', function( e ) {

					// Helper variables

						var $this = jQuery( this );


					// Processing

						if ( e.which === 37 ) {

							// Left key

								e.preventDefault();

								$this
									.parent()
									.prev()
										.children( 'a' )
											.focus();

						} else if ( e.which === 39 ) {

							// Right key

								e.preventDefault();

								$this
									.parent()
									.next()
										.children( 'a' )
											.focus();

						} else if ( e.which === 40 ) {

							// Down key

								e.preventDefault();

								if ( $this.next().length ) {

									$this
										.next()
											.find( 'li:first-child a' )
											.first()
												.focus();

								} else {

									$this
										.parent()
										.next()
											.children( 'a' )
												.focus();

								}

						} else if ( e.which === 38 ) {

							// Up key

								e.preventDefault();

								if ( $this.parent().prev().length ) {

									$this
										.parent()
										.prev()
											.children( 'a' )
												.focus();

								} else {

									$this
										.parents( 'ul' )
										.first()
										.prev( 'a' )
											.focus();

								}

						}

				} );





	/**
	 * 20) Mobile navigation
	 */

		/**
		 * Mobile navigation
		 */

			/**
			 * Mobile menu actions
			 */
			function fireflyMobileMenuActions() {

				// Processing

					if ( ! $fireflySiteNavigation.hasClass( 'active' ) ) {

						$fireflySiteMenuPrimary
							.attr( 'aria-hidden', 'true' );

						$fireflyMenuToggleButton
							.attr( 'aria-expanded', 'false' );

					}

					$fireflySiteNavigation
						.on( 'keydown', function( e ) {

							// Processing

								if ( e.which === 27 ) {

									// ESC key

										e.preventDefault();

										$fireflySiteNavigation
											.removeClass( 'active' );

										$fireflySiteMenuPrimary
											.attr( 'aria-hidden', 'true' );

										$fireflyMenuToggleButton
											.focus();

								}

						} );

			} // /fireflyMobileMenuActions

			// Default mobile menu setup

				if ( 960 >= window.innerWidth ) {

					$fireflySiteNavigation
						.removeClass( 'active' );

					fireflyMobileMenuActions();

				}

			// Clicking the menu toggle button

				$fireflyMenuToggleButton
					.on( 'click', function( e ) {

						// Processing

							e.preventDefault();

							$fireflySiteNavigation
								.toggleClass( 'active' );

							if ( $fireflySiteNavigation.hasClass( 'active' ) ) {

								$fireflySiteMenuPrimary
									.attr( 'aria-hidden', 'false' );

								$fireflyMenuToggleButton
									.attr( 'aria-expanded', 'true' );

							} else {

								$fireflySiteMenuPrimary
									.attr( 'aria-hidden', 'true' );

								$fireflyMenuToggleButton
									.attr( 'aria-expanded', 'false' );

							}

					} );

			// Refocus to menu toggle button once the end of the menu is reached

				$fireflySiteNavigation
					.on( 'focus.aria', '.menu-toggle-skip-link', function( e ) {

						// Processing

							$fireflyMenuToggleButton
								.focus();

					} );

			// Disable mobile navigation on wider screens

				jQuery( window )
					.on( 'resize orientationchange', function( e ) {

						// Processing

							if ( 960 < window.innerWidth ) {

								// On desktops

								$fireflySiteNavigation
									.removeClass( 'active' );

								$fireflySiteMenuPrimary
									.attr( 'aria-hidden', 'false' );

								$fireflyMenuToggleButton
									.attr( 'aria-expanded', 'true' );

							} else {

								// On mobiles

								fireflyMobileMenuActions();

							}

					} );





} );
