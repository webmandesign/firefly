<?php
/**
 * Structure: Menu
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 *
 * Contents:
 *
 * 10) Primary Menu
 * 20) Social Links Menu
 */





/**
 * 10) Primary Menu
 */

	/**
	 * Navigation
	 *
	 * Accessibility markup applied (ARIA).
	 *
	 * @link  http://a11yproject.com/patterns/
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_navigation() {

		// Helper variables

			$output = array();


		// Processing

			$output[100] = '<nav id="site-navigation" class="main-navigation" role="navigation" aria-labelledby="site-navigation-label"' . firefly_schema_org( 'SiteNavigationElement' ) . '>';

			// Screen reader helpers

				$output[200] = '<h2 class="screen-reader-text" id="site-navigation-label">' . esc_html__( 'Primary Menu', 'firefly' ) . '</h2>';

			// Mobile menu toggle button

				$output[300] = '<button role="button" id="menu-toggle" class="menu-toggle" aria-controls="menu-primary" aria-expanded="false">' . esc_html_x( 'Menu', 'Mobile navigation toggle button title.', 'firefly' ) . '</button>';

			// Mobile menu bar

				if ( has_nav_menu( 'mobile' ) ) {

					$output[350] = '<div id="mobile-menu-container" class="mobile-menu-container">';

						$output[360] = wp_nav_menu( apply_filters( 'wmhook_fn_firefly_navigation_mobile_args', array(
								'theme_location' => 'mobile',
								'container'      => false,
								'menu_class'     => 'mobile-menu',
								'depth'          => 1,
								'items_wrap'     => '<ul id="menu-mobile" role="menubar">%3$s<li class="menu-toggle-bar-container"><button role="button" id="menu-toggle-bar" class="menu-toggle-bar" aria-controls="menu-primary" aria-expanded="false"><i class="menu-toggle-bar-icon" aria-hidden="true"></i> ' . esc_html__( 'More', 'firefly' ) . '</button></li></ul>',
								'fallback_cb'    => false,
								'echo'           => false,
							) ) );

					$output[370] = '</div>';

				}

			// Menu

				$output[400] = '<div id="site-navigation-container" class="main-navigation-container">';

					$output[410] = wp_nav_menu( apply_filters( 'wmhook_fn_firefly_navigation_args', array(
							'theme_location'  => 'primary',
							'container'       => 'div',
							'container_class' => 'menu',
							'menu_class'      => 'menu', // Fallback for pagelist
							'items_wrap'      => '<ul id="menu-primary" role="menubar">%3$s<li class="menu-toggle-skip-link-container"><a href="#menu-toggle" class="menu-toggle-skip-link">' . esc_html__( 'Skip to menu toggle button', 'firefly' ) . '</a></li></ul>',
							'fallback_cb'     => 'firefly_navigation_fallback',
							'echo'            => false,
						) ) );

				$output[490] = '</div>';

			$output[900] = '</nav>';

			// Filter the output array

				$output = (array) apply_filters( 'wmhook_fn_firefly_navigation_output_array', $output );


		// Output

			echo implode( '', $output );

	} // /firefly_navigation

	add_action( 'tha_header_top', 'firefly_navigation', 120 );



		/**
		 * Navigation fallback text
		 *
		 * @since    1.0
		 * @version  1.0
		 */
		function firefly_navigation_fallback() {

			// Output

				return esc_html__( 'Please, set up the menu in Appearance &raquo; Menus.', 'firefly' );

		} // /firefly_navigation_fallback



	/**
	 * Menu item modification: item description
	 *
	 * Primary menu only.
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  string $item_output Menu item output HTML (without closing `</li>`).
	 * @param  object $item        The current menu item.
	 * @param  int    $depth       Depth of menu item. Used for padding. Since WordPress 4.1.
	 * @param  array  $args        An array of wp_nav_menu() arguments.
	 */
	function firefly_nav_item_description( $item_output, $item, $depth, $args ) {

		// Processing

			if (
					isset( $args->theme_location )
					&& 'primary' == $args->theme_location
					&& trim( $item->description )
				) {

				$item_output = str_replace(
						$args->link_after . '</a>',
						'<span class="menu-item-description">' . trim( $item->description ) . '</span>' . $args->link_after . '</a>',
						$item_output
					);

			}


		// Output

			return $item_output;

	} // /firefly_nav_item_description

	add_filter( 'walker_nav_menu_start_el', 'firefly_nav_item_description', 10, 4 );



	/**
	 * Menu item modification: submenu expander
	 *
	 * Primary menu only.
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  string $item_output Menu item output HTML (without closing `</li>`).
	 * @param  object $item        The current menu item.
	 * @param  int    $depth       Depth of menu item. Used for padding. Since WordPress 4.1.
	 * @param  array  $args        An array of wp_nav_menu() arguments.
	 */
	function firefly_nav_item_expander( $item_output, $item, $depth, $args ) {

		// Processing

			if (
					isset( $args->theme_location )
					&& 'primary' == $args->theme_location
					&& in_array( 'menu-item-has-children', (array) $item->classes )
				) {

				$item_output = str_replace(
						$args->link_after . '</a>',
						$args->link_after . ' <span class="expander" aria-hidden="true"></span></a>', // Accessibility: on focus, no screen reader text required
						$item_output
					);

			}


		// Output

			return $item_output;

	} // /firefly_nav_item_expander

	add_filter( 'walker_nav_menu_start_el', 'firefly_nav_item_expander', 20, 4 );



	/**
	 * Navigation item classes
	 *
	 * Applies `has-description` classes on menu items.
	 *
	 * @link  http://a11yproject.com/patterns/
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  array  $classes The CSS classes that are applied to the menu item's `<li>` element.
	 * @param  object $item    The current menu item.
	 * @param  array  $args    An array of wp_nav_menu() arguments.
	 * @param  int    $depth   Depth of menu item. Used for padding. Since WordPress 4.1.
	 */
	function firefly_nav_item_classes( $classes, $item, $args, $depth = 0 ) {

		// Processing

			// Primary menu

				if (
						isset( $args->theme_location )
						&& 'primary' == $args->theme_location
					) {

					// Has menu item description?

						if ( trim( $item->post_content ) && $item->menu_item_parent ) {
							$classes[] = 'has-description';
						}

				}


		// Output

			return $classes;

	} // /firefly_nav_item_classes

	add_filter( 'nav_menu_css_class', 'firefly_nav_item_classes', 10, 4 );





/**
 * 20) Social Links Menu
 */

	/**
	 * Display social links
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_menu_social() {

		// Output

			get_template_part( 'template-parts/menu', 'social' );

	} // /firefly_menu_social

	add_action( 'tha_header_top', 'firefly_menu_social', 130 );



	/**
	 * Display social links in Menu widget
	 *
	 * @since    1.0
	 * @version  1.0
	 *
	 * @param  array  $nav_menu_args Array of parameters for `wp_nav_menu()` function.
	 * @param  string $nav_menu      Menu slug assigned in the widget.
	 * @param  array  $args          Widget parameters.
	 */
	function firefly_menu_social_widget( $nav_menu_args, $nav_menu, $args ) {

		// Helper variables

			$nav_menu_obj = wp_get_nav_menu_object( $nav_menu );
			$locations    = get_nav_menu_locations();


		// Requirements check

			if (
					! isset( $locations['social'] )
					|| ! $locations['social']
					|| absint( $locations['social'] ) !== absint( $nav_menu_obj->term_id )
				) {
				return $nav_menu_args;
			}


		// Processing

			$nav_menu_args['container_class'] = 'social-links';
			$nav_menu_args['menu_class']      = 'social-links-items';
			$nav_menu_args['depth']           = 1;
			$nav_menu_args['link_before']     = '<span class="screen-reader-text">';
			$nav_menu_args['link_after']      = '</span>';
			$nav_menu_args['items_wrap']      = '<ul id="%1$s" class="%2$s">%3$s</ul>';


		// Output

			return $nav_menu_args;

	} // /firefly_menu_social

	add_filter( 'widget_nav_menu_args', 'firefly_menu_social_widget', 10, 3 );
