<?php
/**
 * Quote post format content
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

		<?php

		// Processing

			// Remove <blockquote> tags

				$content = preg_replace( '/<(\/?)blockquote(.*?)>/', '', get_the_content() );

			// Quote source

				// First, look for custom field

					$quote_source = trim( get_post_meta( get_the_ID(), 'quote_source', true ) );

				// Fall back to post title as quote source if no custom field set

					if ( empty( $quote_source ) ) {
						$quote_source = strip_tags( get_the_title() );
					}

				// Finally, display the quote source only if it wasn't included in the post content

					if (
							false === stristr( $content, '<cite' )
							&& $quote_source
						) {
						$content .= '<cite class="quote-source">' . $quote_source . '</cite>';
					}


		// Output

			$content = explode( '<cite', $content );

			// Quote content

				echo '<blockquote class="quote-content">' . $content[0] . '</blockquote>';

			// Quote source

				if ( isset( $content[1] ) && $content[1] ) {
					echo '<cite' . $content[1];
				}

		?>

	</div>

	<?php do_action( 'tha_entry_bottom', $args ); ?>

</article>

<?php do_action( 'tha_entry_after', $args ); ?>
