<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see           https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       3.3.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product;

$attachment_ids = $product->get_gallery_image_ids();
$video_image    = get_post_meta( $product->get_id(), 'video_thumbnail', true );
$video_url      = get_post_meta( $product->get_id(), 'video_url', true );
$video_width    = 1024;
$video_height   = 768;
$video_thumb    = '';
$video_html     = '';
if ( $video_image ) {
	$video_thumb = wp_get_attachment_image_src( $video_image, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
	// If URL: show oEmbed HTML
	if ( filter_var( $video_url, FILTER_VALIDATE_URL ) ) {

		$atts = array(
			'width'  => $video_width,
			'height' => $video_height
		);
		if ( $oembed = @wp_oembed_get( $video_url, $atts ) ) {
			$video_html = $oembed;
		} else {
			$atts = array(
				'src'    => $video_url,
				'width'  => $video_width,
				'height' => $video_height
			);

			$video_html = wp_video_shortcode( $atts );

		}
	}
	if ( $video_html ) {
		$video_html    = '<div class="mf-video-wrapper">' . $video_html . '</div>';
		$video_wrapper = sprintf( '<a href="%s"></a>', esc_html( $video_html ) );
		$video_html    = '<div data-thumb="' . esc_url( $video_thumb[0] ) . '" class="woocommerce-product-gallery__image mf-product-video">' . $video_wrapper . $video_html . '</div>';
	}
}

if ( $attachment_ids && has_post_thumbnail() ) {
	foreach ( $attachment_ids as $attachment_id ) {
		$full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
		$thumbnail       = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );
		$attributes      = array(
			'title'                   => get_post_field( 'post_title', $attachment_id ),
			'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
			'data-src'                => $full_size_image[0],
			'data-large_image'        => $full_size_image[0],
			'data-large_image_width'  => $full_size_image[1],
			'data-large_image_height' => $full_size_image[2],
		);

		$html = '<div data-thumb="' . esc_url( $thumbnail[0] ) . '" class="woocommerce-product-gallery__image"><a href="' . esc_url( $full_size_image[0] ) . '">';
		if ( intval( martfury_get_option( 'lazyload' ) ) ) {
			$html .= martfury_get_image_html( $attachment_id, 'shop_single', false, $attributes );
		} else {
			$html .= wp_get_attachment_image( $attachment_id, 'shop_single', false, $attributes );
		}
		$html .= '</a></div>';

		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
	}

	echo $video_html;
}
