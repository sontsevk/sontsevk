<?php
/**
 * @package San Kloud
 */
?>
<div id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="page-content">
		<?php if ( '' !== get_the_title() ): ?>
			<div class="page-title">
				<h2>
					<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'san-kloud' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h2>
			</div>
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'san-kloud' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><span class="post-date"><?php echo get_the_date( get_option( 'date_format' ) ); ?></span></a>
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'san-kloud' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'san-kloud' ) . '</span>', 'after' => '</div>' ) ); ?>
			<p class="post-meta">
				<?php _e( 'Posted by', 'san-kloud' ); ?> <?php the_author_posts_link(); ?> <?php _e( 'in', 'san-kloud' ); ?> <?php the_category( ', ' ); ?> <?php the_tags( __( 'Tags: ', 'san-kloud ' ), ', ', '' ); ?> <?php edit_post_link( __( 'Edit', 'san-kloud' ), '<span class="sep">|</span> <span class="edit-link">', '</span>' ); ?>
			</p>
			<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
			<div class="comment-count">
				<?php comments_popup_link( "<span class='leave-reply'>" . __( 'Reply', 'san-kloud' ) . "</span>", __( '1 comment', 'san-kloud' ), __( '% comments', 'san-kloud' ) ); ?>
			</div>
			<?php endif; ?>
		<?php else : ?>
			<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'san-kloud' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><span class="post-date no-title"><?php echo get_the_date( get_option( 'date_format' ) ); ?></span></a>
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'san-kloud' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'san-kloud' ) . '</span>', 'after' => '</div>' ) ); ?>
			<p class="post-meta">
				<?php _e( 'Posted by', 'san-kloud' ); ?> <?php the_author_posts_link(); ?> <?php _e( 'in', 'san-kloud' ); ?> <?php the_category( ', ' ); ?> <?php the_tags( __( 'Tags: ', 'san-kloud ' ), ', ', '' ); ?> <?php edit_post_link( __( 'Edit', 'san-kloud' ), '<span class="sep">|</span> <span class="edit-link">', '</span>' ); ?>
			</p>
			<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) : ?>
			<div class="comment-count">
				<?php comments_popup_link( "<span class='leave-reply'>" . __( 'Reply', 'san-kloud' ) . "</span>", __( '1 comment', 'san-kloud' ), __( '% comments', 'san-kloud' ) ); ?>
			</div>
			<?php endif; ?>
			<br class="clear" />
		<?php endif; ?>

		<br class="clear">
	</div>
	<div class="page-bottom">
	</div>
</div>