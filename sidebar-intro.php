<?php
/**
 * Intro widgets area template
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

	if (
			! is_active_sidebar( 'intro' )
			|| is_paged()
			|| (
				! is_page_template( 'templates/intro.php' )
				&& empty( get_post_meta( get_the_ID(), 'show_intro_widgets', true ) )
			)
		) {
		return;
	}



/**
 * Output
 */

	?>

	<div class="intro-widgets-container">

		<aside id="intro-widgets" class="widget-area intro-widgets" role="complementary" aria-labelledby="sidebar-intro-label">

			<h2 class="screen-reader-text" id="sidebar-intro-label"><?php echo esc_attr_x( 'Intro sidebar', 'Sidebar aria label', 'firefly' ); ?></h2>

			<?php dynamic_sidebar( 'intro' ); ?>

		</aside>

	</div>
