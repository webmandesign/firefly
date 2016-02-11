<?php
/**
 * Footer widgets area template
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 */





/**
 * Requirements check
 */

	if ( ! is_active_sidebar( 'footer' ) ) {
		return;
	}



/**
 * Helper variables
 */

	$widgets_count = wp_get_sidebars_widgets();

	if ( is_array( $widgets_count ) && isset( $widgets_count['footer'] ) ) {
		$widgets_count = $widgets_count[ 'footer' ];
	} else {
		$widgets_count = array();
	}

	$widgets_count = count( $widgets_count );

	$widgets_columns = absint( get_theme_mod( 'layout_footer_columns' ) );

	if ( empty( $widgets_columns ) ) {
		$widgets_columns = absint( apply_filters( 'wmhook_firefly_widgets_columns', 3, 'footer' ) );
	}

	if ( $widgets_count < $widgets_columns ) {
		$widgets_columns = $widgets_count;
	}



/**
 * Output
 */

	?>

	<div class="site-footer-area footer-area-footer-widgets">

		<div class="footer-widgets-inner site-footer-area-inner">

			<aside id="footer-widgets" class="widget-area footer-widgets widgets-count-<?php echo esc_attr( $widgets_count ); ?> columns-<?php echo esc_attr( $widgets_columns ); ?>" data-widgets-count="<?php echo esc_attr( $widgets_count ); ?>" data-columns="<?php echo esc_attr( $widgets_columns ); ?>" role="complementary" aria-labelledby="sidebar-footer-label">

				<h2 class="screen-reader-text" id="sidebar-footer-label"><?php echo esc_attr_x( 'Footer sidebar', 'Sidebar aria label', 'firefly' ); ?></h2>

				<?php dynamic_sidebar( 'footer' ); ?>

			</aside>

		</div>

	</div>
