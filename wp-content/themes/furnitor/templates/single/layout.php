<?php
/**
 * The template for displaying single content layout
 *
 * @since 1.0
 * @version 1.0
 */

while ( have_posts() ) : the_post();

	furnitor_get_template( 'post/content', array('post_format' => get_post_format()));

	if (get_post_type() !== 'attachment') {
		the_post_navigation( array(
			'prev_text' => '<i class="fas fa-arrow-left"></i><div class="nav-content"> <span aria-hidden="true" class="nav-subtitle">' .esc_html__( 'Previous', 'furnitor' ) . '</span><span class="nav-title">%title</span></div>',
			'next_text' => '<div class="nav-content"><span aria-hidden="true" class="nav-subtitle">' . esc_html__( 'Next', 'furnitor' ) . '</span><span class="nav-title">%title</span></div><i class="fas fa-arrow-right"></i>',
		) );
	}

	furnitor_get_template('post/entry-author');

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) :
		comments_template();
	endif;
endwhile; // End of the loop.