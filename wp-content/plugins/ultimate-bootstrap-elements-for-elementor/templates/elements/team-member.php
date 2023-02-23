<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Group_Control_Image_Size;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;

/**
 * @var $element Elementor\Widget_Base
 * @var $style
 * @var $item_key
 * @var $image_hover_style
 * @var $hover_animation
 * @var $hover_image_animation
 * @var $team_member_link
 * @var $image_html
 * @var $image_src
 * @var $social_html
 * @var $name
 * @var $position
 * @var $description
 */

if (!isset($item_key)) {
	$item_key = '';
}

$team_member_classes = array(
	'ube-team-member',
	"ube-tm-{$style}",
	//'card',
	//'overflow-hidden'
);

$team_member_tag = 'span';


if ( $style == 'style-03' ) {
	$team_member_classes[] = "ube-tm-hover-{$image_hover_style}";

} else {
	if (!empty($hover_animation)) {
		$team_member_classes[] = "ube-image-hover-{$hover_animation}";
	}

	if (!empty($hover_image_animation)) {
		$team_member_classes[] = "ube-image-hover-{$hover_image_animation}";
	}
}

$element->add_render_attribute( "team_member_item{$item_key}", 'class', $team_member_classes );
if ( ! empty( $team_member_link['url'] ) ) {
	$element->add_link_attributes( "image_link{$item_key}", $team_member_link );
	$element->add_link_attributes( "name_link{$item_key}", $team_member_link );
	$team_member_tag = 'a';

}
$element->add_render_attribute( "image_link{$item_key}", 'class', 'card-img' );
ube_get_template("elements/team-member/{$style}.php", array(
	'element' => $element,
	'item_key' => $item_key,
	'image_html' => $image_html,
	'image_src' => $image_src,
	'team_member_tag' => $team_member_tag,
	'social_html' => $social_html,
	'name' => $name,
	'position' => $position,
	'description' => $description
));