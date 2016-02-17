<?php
/**
 * Plugin integration
 *
 * Pods
 *
 * @link  https://wordpress.org/plugins/pods/
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 *
 * Contents:
 *
 *  1) Requirements check
 * 10) Plugin integration
 */





/**
 * 1) Requirements check
 */

	if (
			! function_exists( 'pods_register_type' )
			|| ! function_exists( 'pods_register_field' )
		) {
		return;
	}





/**
 * 10) Plugin integration
 */

	/**
	 * Add custom metaboxes
	 *
	 * @since    1.0
	 * @version  1.0
	 */
	function firefly_pods_register_custom_fields() {

		// Processing

			// Register a Pod

				pods_register_type(
					'post_type',
					'firefly_page_options',
					array(
						'label'        => esc_html__( 'Page options', 'firefly' ),
						'type'         => 'post_type',
						'storage'      => 'meta',
						'object'       => 'page',
						'show_in_menu' => 1,
					)
				);

			// Adding custom fields

				// Hide subpages list

					pods_register_field(
						'firefly_page_options',
						'hide_children',
						array(
							'label'               => esc_html__( 'Do not display child pages', 'firefly' ),
							'description'         => esc_html__( 'In case you set up some child pages for this page (use this page as a parent page), you can hide the child pages list with this option.', 'firefly' ),
							'type'                => 'boolean',
							'weight'              => 0,
							'boolean_format_type' => 'checkbox',
							'boolean_yes_label'   => esc_html__( 'Yes', 'firefly' ),
							'boolean_no_label'    => esc_html__( 'No', 'firefly' ),
						)
					);

				// Intro widgets display

					pods_register_field(
						'firefly_page_options',
						'show_intro_widgets',
						array(
							'label'               => esc_html__( 'Show intro widgets', 'firefly' ),
							'description'         => esc_html__( 'Even if you are not using "With intro widgets" page template, you can display intro widgets in this page intro title by enabling this option.', 'firefly' ),
							'type'                => 'boolean',
							'weight'              => 1,
							'boolean_format_type' => 'checkbox',
							'boolean_yes_label'   => esc_html__( 'Yes', 'firefly' ),
							'boolean_no_label'    => esc_html__( 'No', 'firefly' ),
						)
					);

	} // firefly_pods_register_custom_fields

	// add_action( 'init', 'firefly_pods_register_custom_fields' );
