<?php
if (!defined('ABSPATH')) {
	exit;
}

use Elementor\Group_Control_Image_Size;
use Elementor\Widget_Base;

/**
 * @var $element Elementor\Widget_Base
 * @var $item_key
 * @var $layout
 * @var $enable_quote
 * @var $enable_background
 * @var $rating
 * @var $client_say
 * @var $author_name
 * @var $author_job
 * @var $image_html
 */

if (!isset($item_key)) {
	$item_key = '';
}

$wrapper_classes = array(
	'ube-testimonial',
	"ube-testimonial-{$layout}",
);

if ($layout === 'layout-07') {
	$wrapper_classes[] = 'd-flex';
}

$element->add_render_attribute("wrapper{$item_key}", 'class', $wrapper_classes);

$content_classes = array(
	'ube-testimonial-content'
);

if ($enable_quote === 'yes') {
	$content_classes[] = 'ube-testimonial-is-quote';
}
if ($enable_background === 'yes') {
	$content_classes[] = 'ube-testimonial-content-has-background';
}

$element->add_render_attribute("content_attr{$item_key}", 'class', $content_classes);

$html_rating = array();
if ($rating !== '') {
	$rating = absint($rating);
	for ($i = 1; $i <= 5; $i++) {
		$html_rating[] = ($i <= $rating) ? UBE_Icon::get_instance()->get_svg('star-solid') : UBE_Icon::get_instance()->get_svg('star-regular');
	}
}

?>
<div <?php echo $element->get_render_attribute_string("wrapper{$item_key}") ?>>
	<?php ube_get_template("elements/testimonial/{$layout}.php", array(
		'element' => $element,
		'html_rating' => $html_rating,
		'client_say' => $client_say,
		'author_name' => $author_name,
		'author_job' => $author_job,
		'image_html' => $image_html,
		'item_key' => $item_key
	)); ?>
</div>