<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
global $product;
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes   = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'g5shop__woocommerce-product-gallery',
		'g5shop__woocommerce-product-gallery-5',
		'woocommerce-product-gallery--' . ( $post_thumbnail_id ? 'with-images' : 'without-images' ),
		'images',
	)
);
$gallery_id = uniqid('product_gallery_');
?>
<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>">
	<figure class="g5shop__woocommerce-product-gallery__wrapper">
		<?php
		if ( $post_thumbnail_id ) {
			$full_src          = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
			$image             = wp_get_attachment_image( $post_thumbnail_id,'full',false,			apply_filters(
				'woocommerce_gallery_image_html_attachment_image_params',
				array(
					'title'                   => _wp_specialchars( get_post_field( 'post_title', $post_thumbnail_id ), ENT_QUOTES, 'UTF-8', true ),
					'data-caption'            => _wp_specialchars( get_post_field( 'post_excerpt', $post_thumbnail_id ), ENT_QUOTES, 'UTF-8', true ),
					'data-src'                => esc_url( $full_src[0] ),
					'data-large_image'        => esc_url( $full_src[0] ),
					'data-large_image_width'  => esc_attr( $full_src[1] ),
					'data-large_image_height' => esc_attr( $full_src[2] ),
					'class'                   => 'wp-post-image',
				),
				$post_thumbnail_id,
				'full',
				true
			));
			$html = '<div class="g5shop__woocommerce-product-gallery__image"><a data-g5core-mfp data-gallery-id="'. $gallery_id .'" href="' . esc_url( $full_src[0] ) . '">' . $image . '</a></div>';
		} else {
			$html  = '<div class="g5shop__woocommerce-product-gallery__image--placeholder">';
			$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'full' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) );
			$html .= '</div>';
		}
		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped

		$attachment_ids = $product->get_gallery_image_ids();
		if ( $attachment_ids && $product->get_image_id() ) {
			foreach ( $attachment_ids as $attachment_id ) {
				$image             = wp_get_attachment_image( $attachment_id,'full');
				$full_src          = wp_get_attachment_image_src( $attachment_id, 'full' );
				$html = '<div class="g5shop__woocommerce-product-gallery__image"><a data-g5core-mfp data-gallery-id="'. $gallery_id .'" href="' . esc_url( $full_src[0] ) . '">' . $image . '</a></div>';
				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped

			}
		}

		$prefix = G5SHOP()->meta_prefix;
		$video_url = get_post_meta(get_the_ID(),"{$prefix}video_url",true);
		if (!empty($video_url)) {
			?>
			<div class="g5shop__woocommerce-product-gallery__image video">
				<div class="g5core__embed-responsive g5core__image-size-16x9">
					<?php
					if (wp_oembed_get($video_url)) {
						echo wp_oembed_get($video_url, array('wmode' => 'transparent'));
					} else {
						echo $video_url;
					}
					?>
				</div>
			</div>
			<?php
		}
		?>
	</figure>
</div>