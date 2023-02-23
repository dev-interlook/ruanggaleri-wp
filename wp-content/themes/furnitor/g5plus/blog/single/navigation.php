<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}
if (get_post_type() !== 'attachment') {
	the_post_navigation( array(
		'prev_text' => '<i class="fas fa-arrow-left"></i><div class="nav-content"> <span aria-hidden="true" class="nav-subtitle">' .esc_html__( 'Previous', 'furnitor' ) . '</span><span class="nav-title">%title</span></div>',
		'next_text' => '<div class="nav-content"><span aria-hidden="true" class="nav-subtitle">' . esc_html__( 'Next', 'furnitor' ) . '</span><span class="nav-title">%title</span></div><i class="fas fa-arrow-right"></i>',
	) );
}