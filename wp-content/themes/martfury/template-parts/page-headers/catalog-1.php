<?php
global $martfury_woocommerce;
$title_class = '';
if ( ! empty( $martfury_woocommerce ) && method_exists( $martfury_woocommerce, 'get_catalog_elements' ) ) {
	$elements = $martfury_woocommerce->get_catalog_elements();
	if ( empty( $elements ) || ! in_array( 'title', $elements ) ) {
		$title_class = 'hide-title';
	}
}

?>

<div class="page-header page-header-catalog">
	<div class="page-title <?php echo esc_attr( $title_class ); ?>">
		<div class="container">
			<?php the_archive_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</div>
	</div>
	<div class="page-breadcrumbs">
		<div class="container">
			<?php martfury_get_breadcrumbs(); ?>
		</div>
	</div>
</div>