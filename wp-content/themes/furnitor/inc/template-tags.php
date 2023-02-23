<?php
function furnitor_comment_form_args() {
	$commenter = wp_get_current_commenter();
	$req = get_option('require_name_email');
	$html_req = ($req ? " required='required'" : '');

	$fields = array(
		'author'  => '<p class="comment-form-author">' . '<input id="author" name="author" type="text" placeholder="' . esc_attr__( 'Fullname', 'furnitor' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245"' . $html_req . ' /></p>',
		'email'   => '<p class="comment-form-email">' . '<input id="email" name="email" placeholder="' . esc_attr__( 'Email address', 'furnitor' )  . '" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" maxlength="100" aria-describedby="email-notes"' . $html_req . ' /></p>',
		'url'     => '<p class="comment-form-url">' . '<input id="url" name="url" placeholder="' . esc_attr__( 'Website', 'furnitor' ) . '" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" maxlength="200" /></p>',
	);

	$defaults = array(
		'format'               => 'html5',
		'comment_field'      => '<p class="comment-form-comment"><textarea placeholder="' . esc_attr__('Comment', 'furnitor') . '" id="comment" name="comment" cols="45" rows="2" maxlength="65525" required="required"></textarea></p>',
		'fields'             => $fields,
		'class_submit'       => 'btn btn-dark',
		'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title"><span>',
		'title_reply_after'    => '</span></h3>',
	);

	return $defaults;
}


add_filter('widget_categories_args', 'furnitor_widget_categories_args');
function furnitor_widget_categories_args($cat_args)
{
	$cat_args['taxonomy'] = 'category';
	return $cat_args;
}

function furnitor_cat_count_span($links, $args)
{
	if (isset($args['taxonomy']) && ($args['taxonomy'] == 'category')) {
		$links = str_replace('(', '<span class="count">', $links);
		$links = str_replace(')', '</span>', $links);
	}

	return $links;
}
add_filter('wp_list_categories', 'furnitor_cat_count_span',15,2);

function furnitor_archive_count_span($links, $url, $text, $format)
{
	if ($format === 'option') {
		return $links;
	}
	//$links = str_replace( '</a>&nbsp;(', ' <span class="count">', $links );
	//$links = str_replace( ')', '</span></a>', $links );
	$links = str_replace('&nbsp;(', '<span class="count">', $links);
	$links = str_replace(')', '</span>', $links);
	return $links;
}
add_filter('get_archives_link', 'furnitor_archive_count_span', 10, 4);

function furnitor_kses_allowed_html($tags, $context) {
	switch($context) {
		case 'image':
			$tags = array(
				'img' => array('alt' => true,'align' => true,'border' => true,'height' => true,'hspace' => true,'loading' => true, 'longdesc' => true, 'vspace' => true, 'src' => true, 'usemap' =>  true, 'width' =>  true, 'aria-describedby' => true, 'aria-details' =>  true, 'aria-label' =>  true, 'aria-labelledby' =>  true,'aria-hidden' =>  true, 'class' =>  true, 'id' =>  true, 'style' =>  true, 'title' => true, 'role' => true, 'data-*' =>  true)
			);
			return $tags;
		case 'breadcrumbs';
			$tags = array(
				'ul' => array('type' =>  true, 'aria-describedby' =>  true , 'aria-details' =>  true, 'aria-label' =>  true, 'aria-labelledby' =>  true, 'aria-hidden' =>  true, 'class' =>  true, 'id' =>  true, 'style' =>  true, 'title' => true, 'role' =>  true, 'data-*' =>  true),
				'ol' =>  array('start' =>  true , 'type' => true, 'reversed' =>  true, 'aria-describedby' =>  true, 'aria-details' =>  true, 'aria-label' => true, 'aria-labelledby' => true, 'aria-hidden' => true, 'class' => true,'id' =>  true, 'style' =>  true,'title' => true, 'role' =>  true, 'data-*' =>  true ),
				'li' => array('align' =>  true , 'value' => true,  'aria-describedby' =>  true, 'aria-details' =>  true, 'aria-label' => true, 'aria-labelledby' => true, 'aria-hidden' => true, 'class' => true,'id' =>  true, 'style' =>  true,'title' => true, 'role' =>  true, 'data-*' =>  true ),
				'a' => array('href' =>  true , 'rel' => true,  'rev' =>  true, 'name' =>  true, 'target' => true, 'download' => true,'aria-describedby' =>  true, 'aria-details' =>  true, 'aria-label' => true, 'aria-labelledby' => true, 'aria-hidden' => true, 'class' => true,'id' =>  true, 'style' =>  true,'title' => true, 'role' =>  true, 'data-*' =>  true ),
				'span' => array('dir' =>  true , 'align' => true,  'lang' =>  true, 'xml:lang' =>  true, 'aria-describedby' =>  true, 'aria-details' =>  true, 'aria-label' => true, 'aria-labelledby' => true, 'aria-hidden' => true, 'class' => true,'id' =>  true, 'style' =>  true,'title' => true, 'role' =>  true, 'data-*' =>  true ),
				'i' => array('aria-describedby' =>  true, 'aria-details' =>  true, 'aria-label' => true, 'aria-labelledby' => true, 'aria-hidden' => true, 'class' => true,'id' =>  true, 'style' =>  true,'title' => true, 'role' =>  true, 'data-*' =>  true ),
			);
			return $tags;
		case 'categories_list':
			$tags = array(
				'ul' => array('type' =>  true, 'aria-describedby' =>  true , 'aria-details' =>  true, 'aria-label' =>  true, 'aria-labelledby' =>  true, 'aria-hidden' =>  true, 'class' =>  true, 'id' =>  true, 'style' =>  true, 'title' => true, 'role' =>  true, 'data-*' =>  true),
				'ol' =>  array('start' =>  true , 'type' => true, 'reversed' =>  true, 'aria-describedby' =>  true, 'aria-details' =>  true, 'aria-label' => true, 'aria-labelledby' => true, 'aria-hidden' => true, 'class' => true,'id' =>  true, 'style' =>  true,'title' => true, 'role' =>  true, 'data-*' =>  true ),
				'li' => array('align' =>  true , 'value' => true,  'aria-describedby' =>  true, 'aria-details' =>  true, 'aria-label' => true, 'aria-labelledby' => true, 'aria-hidden' => true, 'class' => true,'id' =>  true, 'style' =>  true,'title' => true, 'role' =>  true, 'data-*' =>  true ),
				'a' => array('href' =>  true , 'rel' => true,  'rev' =>  true, 'name' =>  true, 'target' => true, 'download' => true,'aria-describedby' =>  true, 'aria-details' =>  true, 'aria-label' => true, 'aria-labelledby' => true, 'aria-hidden' => true, 'class' => true,'id' =>  true, 'style' =>  true,'title' => true, 'role' =>  true, 'data-*' =>  true ),
				'span' => array('dir' =>  true , 'align' => true,  'lang' =>  true, 'xml:lang' =>  true, 'aria-describedby' =>  true, 'aria-details' =>  true, 'aria-label' => true, 'aria-labelledby' => true, 'aria-hidden' => true, 'class' => true,'id' =>  true, 'style' =>  true,'title' => true, 'role' =>  true, 'data-*' =>  true ),
				'i' => array('aria-describedby' =>  true, 'aria-details' =>  true, 'aria-label' => true, 'aria-labelledby' => true, 'aria-hidden' => true, 'class' => true,'id' =>  true, 'style' =>  true,'title' => true, 'role' =>  true, 'data-*' =>  true ),
			);
			return $tags;
		default:
			return $tags;
	}
}
add_filter('wp_kses_allowed_html','furnitor_kses_allowed_html',10,2);
