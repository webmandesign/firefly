<?php
/**
 * Plugin integration
 *
 * Advanced Custom Fields
 *
 * @link  https://wordpress.org/plugins/advanced-custom-fields/
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

	if ( ! function_exists( 'register_field_group' ) ) {
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
	function firefly_acf_register_field_group() {

		// Processing

			// Register metabox

				register_field_group( array(
					'id'     => 'firefly_page_options',
					'title'  => esc_html__( 'Page options', 'firefly' ),
					'fields' => array (

						// Hide subpages list

							array (
								'key'           => 'firefly_hide_children',
								'label'         => esc_html__( 'Do not display child pages', 'firefly' ),
								'name'          => 'hide_children',
								'type'          => 'checkbox',
								'default_value' => 0,
								'layout'        => 'vertical',
								'choices'       => array (
									esc_html__( 'Do not display child pages', 'firefly' ) => esc_html__( 'In case you set up some child pages for this page (use this page as a parent page), you can hide the child pages list with this option.', 'firefly' ),
								),
							),

						// Show intro widgets

							array (
								'key'           => 'firefly_show_intro_widgets',
								'label'         => esc_html__( 'Show intro widgets', 'firefly' ),
								'name'          => 'show_intro_widgets',
								'type'          => 'checkbox',
								'default_value' => 0,
								'layout'        => 'vertical',
								'choices'       => array (
									esc_html__( 'Show intro widgets', 'firefly' ) => esc_html__( 'Even if you are not using "With intro widgets" page template, you can display intro widgets in this page intro title by enabling this option.', 'firefly' ),
								),
							),

						// Custom thumbnail

							array (
								'key'           => 'firefly_custom_thumbnail_id',
								'label'         => esc_html__( 'Custom thumbnail', 'firefly' ),
								'name'          => 'custom_thumbnail_id',
								'type'          => 'image',
								'default_value' => 0,
								'layout'        => 'vertical',
								'instructions'  => esc_html__( 'In case this is a child page and it is being displayed in the list on the parent page, the image you set here will override the featured image usually displayed in child pages list.', 'firefly' ),
								'save_format'   => 'id',
								'preview_size'  => 'thumbnail',
								'library'       => 'all',
							),

					),
					'location' => array (
						array (

							// Display on Pages

								array (
									'param'    => 'post_type',
									'operator' => '==',
									'value'    => 'page',
									'order_no' => 0,
									'group_no' => 0,
								),

							// Don't display on blog Page

								array (
									'param'    => 'page_type',
									'operator' => '!=',
									'value'    => 'posts_page',
									'order_no' => 0,
									'group_no' => 1,
								),

						),
					),
					'options' => array (
						'position' => 'normal',
						'layout'   => 'default',
					),
					'menu_order' => 0,
				) );

	} // /firefly_acf_register_field_group

	add_action( 'init', 'firefly_acf_register_field_group' );
