<?php
/**
 * The template for displaying archive content layout
 *
 * @since 1.0
 * @version 1.0
 */
if (have_posts()) {
    /* Start the Loop */
    while ( have_posts() ) : the_post();
        furnitor_get_template('post/content');
    endwhile;
    echo paginate_links(array(
        'type' => 'list',
        'mid_size' => 1,
        'prev_text' => esc_html__('Prev', 'furnitor'),
        'next_text' => esc_html__('Next', 'furnitor'),
    ));
} else {
	furnitor_get_template( 'post/content-none');
}
