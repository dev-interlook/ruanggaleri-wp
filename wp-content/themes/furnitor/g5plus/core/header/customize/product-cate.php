<?php
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
} ?>

<?php class List_Cate_Images extends Walker_Category {
	function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {

		$prefix                        = G5SHOP()->meta_prefix;
		$image = get_term_meta( $category->term_id, "{$prefix}product_cate", true );

		$cat_name = apply_filters(
			'list_cats',
			esc_attr( $category->name ),
			$category
		);

		$link = '<a href="' . esc_url( get_term_link( $category ) ) . '" ';
		if ( $args['use_desc_for_title'] && ! empty( $category->description ) ) {
			$link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
		}

		$link .= '>';
		if ( ! empty( $image['url'] ) ) {
			$link .= '<img src="' . $image['url'] . '" alt="'.$category->name.'">';
		}
		$link .= $cat_name . '</a>';

		if ( ! empty( $args['show_count'] ) ) {
			$link .= ' (' . number_format_i18n( $category->count ) . ')';
		}
		if ( 'list' == $args['style'] ) {
			$output .= "\t<li";
			$class = 'cat-item cat-item-' . $category->term_id;
			if ( ! empty( $args['current_category'] ) ) {
				$_current_category = get_term( $args['current_category'], $category->taxonomy );
				if ( $category->term_id == $args['current_category'] ) {
					$class .=  ' current-cat';
				} elseif ( $category->term_id == $_current_category->parent ) {
					$class .=  ' current-cat-parent';
				}
			}
			$output .=  ' class="' . $class . '"';
			$output .= ">$link\n";
		} else {
			$output .= "\t$link<br />\n";
		}
	}
}
$args = array(
	'taxonomy'  => 'product_cat',
	'title_li' => '',
	'orderby'  => 'menu_order',
	'walker'        => new List_Cate_Images
);?>

<div class="g5shop__cate-warpper">
	<div class="g5shop__cate-browse">
		<div class="toggle-icon"><span></span></div>
		<span class="g5shop__cate-text"><?php esc_html_e('Browse Categories','furnitor')?></span>
	</div>
	<ul class="g5shop__list-cate">
	  <?php echo wp_list_categories( $args ); ?>
	</ul>
</div>
