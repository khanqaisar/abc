<?php
/**
 * Hooks for template header
 *
 * @package Martfury
 */


/**
 * Enqueue scripts and styles.
 *
 * @since 1.0
 */
function martfury_enqueue_scripts() {
	/**
	 * Register and enqueue styles
	 */
	wp_register_style( 'martfury-fonts', martfury_fonts_url(), array(), '20170801' );
	wp_register_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.7' );
	wp_register_style( 'linearicons', get_template_directory_uri() . '/css/linearicons.min.css', array(), '1.0.0' );
	wp_register_style( 'ionicons', get_template_directory_uri() . '/css/ionicons.min.css', array(), '2.0.0' );
	wp_register_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.6.3' );
	wp_register_style( 'eleganticons', get_template_directory_uri() . '/css/eleganticons.min.css', array(), '1.0.0' );
	wp_register_style( 'photoswipe', get_theme_file_uri( 'css/photoswipe.css' ), array(), '4.1.1' );
	wp_enqueue_style( 'martfury', get_template_directory_uri() . '/style.css', array(
		'martfury-fonts',
		'linearicons',
		'ionicons',
		'font-awesome',
		'eleganticons',
		'bootstrap',
	), '20170801' );

	wp_add_inline_style( 'martfury', martfury_header_styles() );

	/**
	 * Register and enqueue scripts
	 */

	wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/js/plugins/html5shiv.min.js', array(), '3.7.2' );
	wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'respond', get_template_directory_uri() . '/js/plugins/respond.min.js', array(), '1.4.2' );
	wp_script_add_data( 'respond', 'conditional', 'lt IE 9' );

	wp_register_script( 'photoswipe', get_template_directory_uri() . '/js/plugins/photoswipe.min.js', array(), '4.1.1', true );
	wp_register_script( 'photoswipe-ui', get_template_directory_uri() . '/js/plugins/photoswipe-ui.min.js', array( 'photoswipe' ), '4.1.1', true );
	wp_register_script( 'threesixty', get_template_directory_uri() . '/js/plugins/threesixty.min.js', array(), '2.0.5', true );
	wp_register_script( 'waypoints', get_template_directory_uri() . '/js/plugins/waypoints.min.js', array( 'jquery' ), '2.0.2' );
	wp_register_script( 'isinviewport', get_template_directory_uri() . '/js/plugins/isInViewport.min.js', array(), '1.0.0', true );
	wp_register_script( 'mf-countdown', get_template_directory_uri() . '/js/plugins/jquery.coundown.js', array(), '1.0.0', true );
	wp_register_script( 'counterup', get_template_directory_uri() . '/js/plugins/jquery.counterup.min.js', array(), '1.0.0', true );
	wp_register_script( 'fitvids', get_template_directory_uri() . '/js/plugins/jquery.fitvids.js', array(), '1.1.0', true );
	wp_register_script( 'lazyload', get_template_directory_uri() . '/js/plugins/jquery.lazyload.min.js', array(), '1.9.7', true );
	wp_register_script( 'parallax', get_template_directory_uri() . '/js/plugins/jquery.parallax.min.js', array(), '1.0.0', true );
	wp_register_script( 'slimscroll', get_template_directory_uri() . '/js/plugins/jquery.slimscroll.js', array(), '1.3.8', true );
	wp_register_script( 'tabs', get_template_directory_uri() . '/js/plugins/jquery.tabs.js', array(), '1.0.0', true );
	wp_register_script( 'nprogress', get_template_directory_uri() . '/js/plugins/nprogress.js', array(), '1.0.0', true );
	wp_register_script( 'slick', get_template_directory_uri() . '/js/plugins/slick.min.js', array(), '1.6.0', true );
	wp_register_script( 'isotope', get_template_directory_uri() . '/js/plugins/isotope.pkgd.min.js', array(), '2.2.2', true );
	wp_enqueue_script( 'wc-add-to-cart-variation' );
	if ( is_singular() ) {

		wp_enqueue_style( 'photoswipe' );
		wp_enqueue_script( 'photoswipe-ui' );
		wp_enqueue_script( 'wc-single-product' );

		$photoswipe_skin = 'photoswipe-default-skin';
		if ( wp_style_is( $photoswipe_skin, 'registered' ) && ! wp_style_is( $photoswipe_skin, 'enqueued' ) ) {
			wp_enqueue_style( $photoswipe_skin );
		}
	}
	global $post;
	if ( ( ! empty( $post->post_content ) && strstr( $post->post_content, '[martfury_product_deals_carousel' ) ) ) {
		if ( current_theme_supports( 'wc-product-gallery-zoom' ) ) {
			wp_enqueue_script( 'zoom' );
		}
		if ( current_theme_supports( 'wc-product-gallery-slider' ) ) {
			wp_enqueue_script( 'flexslider' );
		}
		wp_enqueue_script( 'wc-single-product' );
	}

	if ( is_singular( 'product' ) ) {
		wp_enqueue_script( 'threesixty' );
	}

	$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	wp_enqueue_script( 'martfury', get_template_directory_uri() . "/js/scripts$min.js", array(
		'jquery',
		'jquery-ui-tooltip',
		'imagesloaded',
		'lazyload',
		'waypoints',
		'isinviewport',
		'mf-countdown',
		'counterup',
		'fitvids',
		'parallax',
		'slimscroll',
		'tabs',
		'nprogress',
		'slick',
		'isotope',
	), '20170801', true );

	$product_images_dg = '';
	if ( is_singular( 'product' ) ) {
		$images_dg = get_post_meta( get_the_ID(), 'product_360_view', false );
		if ( $images_dg ) {
			foreach ( $images_dg as $image ) {
				$image_dg          = wp_get_attachment_image_src( $image, 'full' );
				$product_images_dg .= $product_images_dg ? ',' : '';
				$product_images_dg .= $image_dg ? $image_dg[0] : '';
			}
		}
	}

	wp_localize_script(
		'martfury', 'martfuryData', array(
			'rtl'                 => is_rtl() ? 'true' : 'false',
			'ajax_url'            => admin_url( 'admin-ajax.php' ),
			'nonce'               => wp_create_nonce( '_martfury_nonce' ),
			'currency_pos'        => get_option( 'woocommerce_currency_pos' ),
			'currency_symbol'     => function_exists( 'get_woocommerce_currency_symbol' ) ? get_woocommerce_currency_symbol() : '',
			'thousand_sep'        => function_exists( 'wc_get_price_thousand_separator' ) ? wc_get_price_thousand_separator() : '',
			'decimal_sep'         => function_exists( 'wc_get_price_decimal_separator' ) ? wc_get_price_decimal_separator() : '',
			'price_decimals'      => function_exists( 'wc_get_price_decimals' ) ? wc_get_price_decimals() : '',
			'days'                => esc_html__( 'days', 'martfury' ),
			'hours'               => esc_html__( 'hours', 'martfury' ),
			'minutes'             => esc_html__( 'minutes', 'martfury' ),
			'seconds'             => esc_html__( 'seconds', 'martfury' ),
			'product_degree'      => $product_images_dg,
			'add_to_cart_ajax'    => intval( martfury_get_option( 'product_add_to_cart_ajax' ) ),
			'search_content_type' => martfury_get_option( 'search_content_type' ),
			'nl_days'             => intval( martfury_get_option( 'newsletter_reappear' ) ),
			'nl_seconds'          => intval( martfury_get_option( 'newsletter_visible' ) ) == 2 ? intval( martfury_get_option( 'newsletter_seconds' ) ) : 0,

		)
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'martfury_enqueue_scripts' );

/**
 * Custom styles on header
 *
 * @since  1.0.0
 */
function martfury_header_styles() {
	/**
	 * All Custom CSS rules
	 */
	$inline_css = '';

	//Logo
	$logo_size_width = intval( martfury_get_option( 'logo_width' ) );
	$logo_css        = $logo_size_width ? 'width:' . $logo_size_width . 'px; ' : '';

	$logo_size_height = intval( martfury_get_option( 'logo_height' ) );
	$logo_height_css  = $logo_size_height ? 'height:' . $logo_size_height . 'px; ' : '';

	$logo_margin     = martfury_get_option( 'logo_margins' );
	$logo_margin_css = $logo_margin['top'] ? 'margin-top:' . $logo_margin['top'] . '; ' : '';
	$logo_margin_css .= $logo_margin['right'] ? 'margin-right:' . $logo_margin['right'] . '; ' : '';
	$logo_margin_css .= $logo_margin['bottom'] ? 'margin-bottom:' . $logo_margin['bottom'] . '; ' : '';
	$logo_margin_css .= $logo_margin['left'] ? 'margin-left:' . $logo_margin['left'] . '; ' : '';

	if ( ! empty( $logo_css ) ) {
		$inline_css .= '.site-header .logo img ' . ' {' . $logo_css . '}';
	}

	if ( ! empty( $logo_height_css ) ) {
		$inline_css .= '@media (min-width: 1200px) {.site-header .logo img ' . ' {' . $logo_height_css . '} }';
	}

	if ( ! empty( $logo_margin_css ) ) {
		$inline_css .= '.site-header .logo ' . ' {' . $logo_margin_css . '}';
	}


	/* 404 background */

	if ( is_404() ) {
		$bg_color = martfury_get_option( 'not_found_bg' );

		if ( $bg_color ) {
			$inline_css .= '.error404 .site-content { background-color:' . esc_url( $bg_color ) . '; }';
		}
	}

	// Promotion
	if ( intval( martfury_get_option( 'promotion' ) ) ) {
		$promotion_bg_color = martfury_get_option( 'promotion_bg_color' );
		$promotion_bg_image = martfury_get_option( 'promotion_bg_image' );

		$promo_css = ! empty( $promotion_bg_color ) ? "background-color: {$promotion_bg_color};" : '';

		if ( ! empty( $promotion_bg_image ) ) {


			$promo_css .= "background-image: url({$promotion_bg_image});";

			$promo_bg_repeats = martfury_get_option( 'promotion_bg_repeats' );
			$promo_css        .= "background-repeat: {$promo_bg_repeats};";

			$promo_bg_vertical   = martfury_get_option( 'promotion_bg_vertical' );
			$promo_bg_horizontal = martfury_get_option( 'promotion_bg_horizontal' );
			$promo_css           .= "background-position: {$promo_bg_horizontal} {$promo_bg_vertical};";

			$promo_bg_attachments = martfury_get_option( 'promotion_bg_attachments' );
			$promo_css            .= "background-attachment: {$promo_bg_attachments};";

			$promo_bg_size = martfury_get_option( 'promotion_bg_size' );
			$promo_css     .= "background-size: {$promo_bg_size};";
		}

		if ( $promo_css ) {
			$inline_css .= '.top-promotion {' . $promo_css . '}';
		}

	}

	$color_scheme_option = martfury_get_option( 'color_scheme' );
	$color_scheme        = '';
	if ( $color_scheme_option == 'red' ) {
		$color_scheme = '#dd2400';
	} elseif ( $color_scheme_option == 'orange' ) {
		$color_scheme = '#fb7c00';
	}
	if ( intval( martfury_get_option( 'custom_color_scheme' ) ) ) {
		$color_scheme = martfury_get_option( 'custom_color' );
	}
	// Don't do anything if the default color scheme is selected.
	if ( $color_scheme ) {
		$darken_color = $color_scheme;
		if ( class_exists( 'Kirki_Color' ) && method_exists( 'Kirki_Color', 'adjust_brightness' ) ) {
			$darken_color = Kirki_Color::adjust_brightness( $color_scheme, -15 );
		}

		$inline_css .= martfury_get_color_scheme_css( $color_scheme, $darken_color );
	}

	$inline_css .= martfury_typography_css();

	return $inline_css;
}

/**
 * Display the site header
 *
 * @since 1.0.0
 */
function martfury_show_header() {
	if ( is_page_template( 'template-coming-soon-page.php' ) ) {
		get_template_part( 'template-parts/logo' );
	} else {
		$header_layout = martfury_get_option( 'header_layout' );
		$header_layout = $header_layout ? $header_layout : 1;
		$header_layout = $header_layout == 5 ? 2 : $header_layout;
		get_template_part( 'template-parts/headers/layout', $header_layout );
	}
}

add_action( 'martfury_header', 'martfury_show_header' );

/**
 * Display the top bar
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'martfury_show_topbar' ) ) :
	function martfury_show_topbar() {

		if ( ! intval( martfury_get_option( 'topbar' ) ) ) {
			return;
		}

		if ( is_page_template( 'template-coming-soon-page.php' ) ) {
			return;
		}

		get_template_part( 'template-parts/headers/topbar' );
	}
endif;

add_action( 'martfury_before_header', 'martfury_show_topbar', 10 );

/**
 * Display promotion section at the top of site
 *
 * @since 1.0
 */
if ( ! function_exists( 'martfury_promotion' ) ) :
	function martfury_promotion() {
		if ( ! intval( martfury_get_option( 'promotion' ) ) ) {
			return;
		}

		if ( is_404() || is_page_template( 'template-coming-soon-page.php' ) ) {
			return;
		}

		if ( intval( martfury_get_option( 'promotion_home_only' ) ) && ! is_front_page() ) {
			return;
		}

		$button      = '';
		$button_text = martfury_get_option( 'promotion_button_text' );
		$button_link = martfury_get_option( 'promotion_button_link' );
		if ( ! empty( $button_text ) && ! empty( $button_link ) ) {
			$button = sprintf( '<a class="link" href="%s">%s</a>', esc_url( $button_link ), esc_html( $button_text ) );
		}

		if ( intval( martfury_get_option( 'promotion_close' ) ) ) {
			$button .= '<span class="close"><i class="icon-cross2"></i></span>';
		}

		printf(
			'<div id="top-promotion" class="top-promotion promotion">
				<div class="container">
					<div class="promotion-content">
						<div class="promo-inner">
						%s
						</div>
						<div class="promo-link">
						%s
						</div>
					</div>
				</div>
			</div>',
			do_shortcode( wp_kses( martfury_get_option( 'promotion_content' ), wp_kses_allowed_html( 'post' ) ) ),
			$button
		);
	}
endif;
add_action( 'martfury_before_header', 'martfury_promotion', 5 );