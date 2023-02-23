<div class="breadcrumbs-wrap">
	<div class="container">
		<?php furnitor_the_breadcrumbs(); ?>
	</div>
</div>
<?php if (is_singular('post')): ?>
	<div class="page-header single-post-header">
		<div class="container">
			<div class="page-header-inner">
				<header class="entry-header">
					<?php furnitor_get_template('post/entry-date') ?>
					<?php furnitor_get_template('post/entry-title') ?>
					<?php furnitor_get_template('post/entry-meta') ?>
				</header><!-- .entry-header -->
			</div>
		</div>
	</div>
<?php else: ?>
	<div class="page-header">
		<div class="container">
			<div class="page-header-inner">
				<?php if ( ( is_home() && ! is_front_page() ) || ( is_page() ) ): ?>
					<div class="page-main-title"><?php echo furnitor_get_page_title() ?></div>
				<?php else: ?>
					<h1 class="page-main-title"><?php echo furnitor_get_page_title() ?></h1>
				<?php endif; ?>
				<?php if ( is_archive() ): ?>
					<?php the_archive_description( '<div class="page-sub-title">', '</div>' ); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php endif; ?>

