<?php
/**
 * Link post format content
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 */





// Helper variables

	$args = ( ! isset( $helper ) ) ? ( null ) : ( array( 'helper' => $helper ) );

?>

<?php do_action( 'tha_entry_before', $args ); ?>

<article role="article" id="post-<?php the_ID(); ?>" <?php post_class(); echo apply_filters( 'wmhook_firefly_entry_container_atts', '' ); ?>>

	<?php do_action( 'tha_entry_top', $args ); ?>

	<div class="entry-content"<?php echo firefly_schema_org( 'entry_body' ); ?>>

		<?php the_content(); ?>

	</div>

	<?php do_action( 'tha_entry_bottom', $args ); ?>

</article>

<?php do_action( 'tha_entry_after', $args ); ?>
