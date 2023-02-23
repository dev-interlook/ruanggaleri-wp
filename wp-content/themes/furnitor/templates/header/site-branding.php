<?php
$custom_logo_id = get_theme_mod( 'custom_logo' );
$site_branding_classes = array('site-branding');
if (!empty($custom_logo_id)) {
	$site_branding_classes[] = 'has-logo';
}
?>
<div class="<?php echo join(' ', $site_branding_classes)?>">
	<?php the_custom_logo(); ?>

	<div class="site-branding-text">
		<?php if ( is_front_page() ) : ?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<?php else : ?>
			<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
		<?php endif; ?>

		<?php $description = get_bloginfo( 'description', 'display' ); ?>
		<?php if ($description || is_customize_preview()): ?>
			<p class="site-description"><?php echo wp_kses($description,wp_kses_allowed_html('user_description')); ?></p>
		<?php endif; ?>
	</div><!-- .site-branding-text -->
</div><!-- .site-branding -->