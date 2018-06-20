<?php
$menu_class = 'col-md-12 col-sm-12 col-xs-12';
if ( intval( martfury_get_option( 'header_bar' ) ) ) {
	$menu_class = 'col-md-6 col-sm-6 col-xs-12';
}
?>
<div class="header-main-wapper">
	<div class="header-main">
		<div class="container">
			<div class="row header-row">
				<div class="header-logo col-md-3 col-sm-3">
					<div class="d-logo">
						<?php get_template_part( 'template-parts/logo' ); ?>
					</div>
					<div class="d-department hidden-md hidden-xs hidden-sm">
						<?php martfury_extra_department(); ?>
					</div>
				</div>
				<div class="header-extras col-md-9 col-sm-9">
					<?php martfury_extra_search(); ?>
					<ul class="extras-menu">
						<?php
						martfury_extra_wislist();
						martfury_extra_cart();
						martfury_extra_account();
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="main-menu hidden-md hidden-xs hidden-sm">
	<div class="container">
		<div class="row">
			<div class="<?php echo esc_attr( $menu_class ); ?>">
				<div class="col-header-menu">
					<?php martfury_header_menu(); ?>
				</div>
			</div>
			<?php if ( intval( martfury_get_option( 'header_bar' ) ) ) : ?>
				<div class="col-md-6 col-sm-6 col-header-bar">
					<?php martfury_header_bar(); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<div class="mobile-menu hidden-lg">
	<div class="container">
		<div class="mobile-menu-row">
			<a class="mf-toggle-menu" id="mf-toggle-menu" href="#">
				<i class="icon-menu"></i>
			</a>
			<?php martfury_extra_search( false ); ?>
		</div>
	</div>
</div>


