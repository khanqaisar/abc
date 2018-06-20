<?php
/**
 * Hooks for frontend display
 *
 * @package Martfury
 */


/**
 * Adds custom classes to the array of body classes.
 *
 * @since 1.0
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function martfury_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( $header_layout = martfury_get_option( 'header_layout' ) ) {
		$classes[] = 'header-layout-' . $header_layout;
	}

	if ( is_singular( 'post' ) ) {
		$classes[] = 'single-post-layout-' . martfury_single_post_style();
	}

	if ( martfury_is_blog() ) {
		$classes[] = 'mf-blog-page';
		$classes[] = 'blog-layout-' . martfury_get_layout();

		if ( intval( martfury_get_option( 'show_blog_cats' ) ) ) {
			$classes[] = 'has-blog-cats';
		}

	} elseif ( martfury_is_catalog() || martfury_is_dc_vendor_store() ) {
		$classes[]      = 'mf-catalog-page';
		$classes[]      = martfury_get_layout();
		$catalog_layout = martfury_get_catalog_layout();
		$classes[]      = 'mf-catalog-layout-' . $catalog_layout;
		$shop_view      = isset( $_COOKIE['shop_view'] ) ? $_COOKIE['shop_view'] : martfury_get_option( 'catalog_view_' . $catalog_layout );
		$classes[]      = 'shop-view-' . $shop_view;
	} elseif ( is_search() ) {
		$classes[] = 'blog-layout-grid';
	} else {
		$classes[] = martfury_get_layout();
	}

	if ( is_singular( 'product' ) ) {
		$product_layout = martfury_get_option( 'product_page_layout' );
		$classes[]      = 'single-product-layout-' . $product_layout;

		if ( intval( martfury_get_option( 'product_add_to_cart_fixed_mobile' ) ) ) {
			$classes[] = 'mb-add-to-cart-fixed';
		}
	}

	if ( intval( martfury_get_option( 'preloader' ) ) ) {
		$classes[] = 'mf-preloader';
	}

	if ( intval( martfury_get_option( 'catalog_ajax_filter' ) ) ) {
		$classes[] = 'catalog-ajax-filter';
	}

	if ( $skin = martfury_get_option( 'color_skin' ) ) {
		$classes[] = 'mf-' . $skin . '-skin';
	}

	if ( intval( martfury_get_option( 'sticky_header' ) ) ) {
		$classes[] = 'sticky-header';
	}
	$extras = martfury_menu_extras();
	if ( empty( $extras ) || ! in_array( 'department', $extras ) ) {
		$classes[] = 'header-no-department';
	}

	return $classes;
}

add_filter( 'body_class', 'martfury_body_classes' );

/**
 * Print the open tags of site content container
 */

if ( ! function_exists( 'martfury_open_site_content_container' ) ) :
	function martfury_open_site_content_container() {

		printf( '<div class="%s"><div class="row">', esc_attr( apply_filters( 'martfury_site_content_container_class', martfury_class_full_width() ) ) );
	}
endif;

add_action( 'martfury_after_site_content_open', 'martfury_open_site_content_container' );

/**
 * Print the close tags of site content container
 */

if ( ! function_exists( 'martfury_close_site_content_container' ) ) :
	function martfury_close_site_content_container() {
		print( '</div></div>' );
	}

endif;

add_action( 'martfury_before_site_content_close', 'martfury_close_site_content_container' );
