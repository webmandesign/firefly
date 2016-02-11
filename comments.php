<?php
/**
 * Comments list template
 *
 * @package    Firefly
 * @copyright  WebMan Design, Oliver Juhas
 *
 * @since    1.0
 * @version  1.0
 */





/**
 * Return early without loading comments if:
 * - the current post is protected by a password and the visitor has not yet entered the password
 * - the page is a front page
 * - we are not on single post page
 * - comments are closed or we have have no comments to display (even if the comments are closed now, there could be some old ones)
 * - post type doesn't support comments
 */
if (
		post_password_required()
		|| ( is_page() && is_front_page() )
		|| ! firefly_is_singular()
		|| ! ( comments_open() || have_comments() )
		|| ! post_type_supports( get_post_type(), 'comments' )
	) {
	return;
}





do_action( 'tha_comments_before' );

?>

<div id="comments" class="comments-area">

	<h2 id="comments-title" class="comments-title">
		<?php

		printf(
			esc_html( _nx( '1 comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', get_comments_number(), 'Comments list title.', 'firefly' ) ),
			number_format_i18n( get_comments_number() ),
			'<span>' . get_the_title() . '</span>'
		);

		?>

		<a href="#respond" class="add-comment-link"><?php echo esc_html_x( 'Add yours &rarr;', 'Add new comment link text.', 'firefly' ); ?></a>
	</h2>

	<?php

	/**
	 * Comments list
	 */
	if ( have_comments() ) :

		if (
				! comments_open()
				&& '0' != get_comments_number()
			) {

			?>

			<h3 class="comments-closed"><?php esc_html_e( 'Comments are closed. You can not add new comments.', 'firefly' ); ?></h3>

			<?php

		}

		// Actual comments list

			?>

			<ol class="comment-list">

				<?php

				wp_list_comments( array(
						'type'        => 'comment', // Do not display trackbacks and pingbacks
						'avatar_size' => 240,
						'style'       => 'ol',
						'short_ping'  => true
					) );

				?>

			</ol>

			<?php

		// Paginated comments

			if (
					1 < get_comment_pages_count()
					&& get_option( 'page_comments' )
				) {

				// There are comments to navigate through and multipaged comments are enabled in WordPress settings

				?>

				<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation" aria-labelledby="comment-nav-below-label">

					<h2 class="screen-reader-text" id="comment-nav-below-label"><?php esc_html_e( 'Comment navigation', 'firefly' ); ?></h2>

					<div class="nav-links">

						<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older comments', 'firefly' ) ); ?></div>
						<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer comments &rarr;', 'firefly' ) ); ?></div>

					</div>

				</nav>

				<?php

			}

	endif; // /have_comments()



	/**
	 * Comments form only if comments open
	 */
	if ( comments_open() ) {

		comment_form();

	}

	?>

</div><!-- #comments -->

<?php

do_action( 'tha_comments_after' );
