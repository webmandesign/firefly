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

			// Intro heading section

				register_field_group( array(
					'id' => 'acf_intro-heading-section',
					'title' => esc_html__( 'Intro heading section', 'firefly' ),
					'fields' => array (
						array (
							'key' => 'field_5617c1ad72650',
							'label' => esc_html__( 'Intro title section', 'firefly' ),
							'name' => 'no_title',
							'type' => 'checkbox',
							'choices' => array (
								esc_html__( 'Disable intro title section', 'firefly' ) => esc_html__( 'Disable intro title section for this page', 'firefly' ),
							),
							'default_value' => 0,
							'layout' => 'vertical',
						),
					),
					'location' => array (
						array (
							array (
								'param' => 'post_type',
								'operator' => '==',
								'value' => 'page',
								'order_no' => 0,
								'group_no' => 0,
							),
						),
						array (
							array (
								'param' => 'post_type',
								'operator' => '==',
								'value' => 'wm_staff',
								'order_no' => 0,
								'group_no' => 1,
							),
						),
					),
					'options' => array (
						'position' => 'normal',
						'layout' => 'default',
						'hide_on_screen' => array (
							0 => 'custom_fields',
						),
					),
					'menu_order' => 0,
				) );

			// Subpages list setup

				register_field_group( array(
					'id' => 'acf_subpages-list-setup',
					'title' => esc_html__( 'Subpages list setup', 'firefly' ),
					'fields' => array (
						array (
							'key' => 'field_5617caf386563',
							'label' => esc_html__( 'Instructions', 'firefly' ),
							'name' => '',
							'type' => 'message',
							'message' => esc_html__( 'These settings will modify the page display in the list of subpages. The page needs to be nested under a parent page and you need to set up the parent page with "List subpages" page template assigned.', 'firefly' ),
						),
						array (
							'key' => 'field_5617c4bff40f2',
							'label' => esc_html__( 'Page icon class', 'firefly' ),
							'name' => 'custom_icon',
							'type' => 'text',
							'instructions' => esc_html__( 'Icon class can be found in Appearance > Icon Font', 'firefly' ),
							'default_value' => '',
							'placeholder' => 'icon-phone',
							'prepend' => '',
							'append' => '',
							'formatting' => 'none',
							'maxlength' => '',
						),
						array (
							'key' => 'field_5617c27d72651',
							'label' => esc_html__( 'Featured image in list of subpages', 'firefly' ),
							'name' => 'custom_image_url',
							'type' => 'image',
							'instructions' => esc_html__( 'Set this if you wish to override the display of the page featured image', 'firefly' ),
							'save_format' => 'id',
							'preview_size' => 'admin-thumbnail',
							'library' => 'all',
						),
					),
					'location' => array (
						array (
							array (
								'param' => 'post_type',
								'operator' => '==',
								'value' => 'page',
								'order_no' => 0,
								'group_no' => 0,
							),
						),
					),
					'options' => array (
						'position' => 'normal',
						'layout' => 'default',
						'hide_on_screen' => array (
							0 => 'custom_fields',
						),
					),
					'menu_order' => 0,
				) );

	} // /firefly_acf_register_field_group

	add_action( 'init', 'firefly_acf_register_field_group' );
