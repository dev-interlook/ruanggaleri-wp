<?php
// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
if (!is_singular('product')) {
	return;
}

$previous = get_adjacent_post( false, '', true );
$next = get_adjacent_post( false, '', false );

if ( ! $next && ! $previous ) {
	return;
}

$prev_product = wc_get_product($previous);
$nev_product = wc_get_product($next);

?>
<nav role="navigation" class="navigation g5shop__product-navigation">
	<?php if ( is_a( $prev_product, 'WC_Product' ) ) : ?>
		<div class="product-nav prev dropdown"><?php previous_post_link( '%link', '<i class="far fa-arrow-left"></i>' ); ?>
			<div class="dropdown-menu">
				<div class="media">
					<?php printf('%s',$prev_product->get_image('thumbnail')); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<div class="media-body align-self-center">
						<h5 class="mt-0"><a href="<?php echo esc_url( $prev_product->get_permalink() ); ?>"><?php echo esc_html( $prev_product->get_name() ); ?></a></h5>
						<?php printf('%s',$prev_product->get_price_html()); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( is_a( $nev_product, 'WC_Product' ) ) : ?>
		<div class="product-nav next dropdown"><?php next_post_link( '%link',  '<i class="far fa-arrow-right"></i>' ); ?>
			<div class="dropdown-menu">
				<div class="media">
					<?php printf('%s',$nev_product->get_image('thumbnail')); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<div class="media-body align-self-center">
						<h5 class="mt-0"><a href="<?php echo esc_url( $nev_product->get_permalink() ); ?>"><?php echo esc_html( $nev_product->get_name() ); ?></a></h5>
						<?php echo printf('%s',$nev_product->get_price_html()); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
</nav>

