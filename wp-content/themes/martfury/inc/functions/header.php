<?php
/**
 * Custom functions for header.
 *
 * @package Martfury
 */


/**
 * Get Menu extra Account
 *
 * @since  1.0.0
 *
 * @return string
 */
if ( ! function_exists( 'martfury_extra_account' ) ) :
	function martfury_extra_account() {
		$extras = martfury_menu_extras();
		$items  = '';

		if ( empty( $extras ) || ! in_array( 'account', $extras ) ) {
			return;
		}

		if ( is_user_logged_in() ) {
			$user_menu = martfury_nav_vendor_menu();
			if ( empty( $user_menu ) ) {
				$user_menu = martfury_nav_user_menu();
			}
			$account = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
			$author  = get_user_by( 'id', get_current_user_id() );
			$items .= sprintf(
				'<li class="extra-menu-item menu-item-account logined">
				<a href="%s"><i class="extra-icon icon-user"></i></a>
				<ul>
					<li>
						<h3>%s</h3>
					</li>
					<li>
						%s
					</li>
					<li class="line-space"></li>
					<li class="logout">
						<a href="%s">%s</a>
					</li>
				</ul>
			</li>',
				esc_url( $account ),
				esc_html__( 'Hello,', 'martfury' ) . ' ' . $author->display_name . ' !',
				implode( ' ', $user_menu ),
				esc_url( wp_logout_url( $account ) ),
				esc_html__( 'Logout', 'martfury' )
			);
		} else {

			$register      = '';
			$register_text = esc_html__( 'Register', 'martfury' );

			if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) {
				$register = sprintf(
					'<a href="%s" class="item-register" id="menu-extra-register">%s</a>',
					esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ),
					$register_text
				);
			}

			$items .= sprintf(
				'<li class="extra-menu-item menu-item-account">
				<a href="%s" id="menu-extra-login"><i class="extra-icon icon-user"></i>%s</a>
				%s
			</li>',
				esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ),
				esc_html__( 'Log in', 'martfury' ),
				$register
			);
		}

		echo $items;

	}
endif;
/**
 * Get Menu extra cart
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'martfury_vendor_navigation_url' ) ) :
	function martfury_vendor_navigation_url() {
		$author = get_user_by( 'id', get_current_user_id() );
		$vendor = array();
		if ( function_exists( 'dokan_get_navigation_url' ) && in_array( 'seller', $author->roles ) ) {
			$vendor[] = sprintf( '<li><a href="%s">%s</a></li>', esc_url( dokan_get_navigation_url() ), esc_html__( 'Dashboard', 'martfury' ) );
			$vendor[] = sprintf( '<li><a href="%s">%s</a></li>', esc_url( dokan_get_navigation_url( 'products' ) ), esc_html__( 'Products', 'martfury' ) );
			$vendor[] = sprintf( '<li><a href="%s">%s</a></li>', esc_url( dokan_get_navigation_url( 'orders' ) ), esc_html__( 'Orders', 'martfury' ) );
			$vendor[] = sprintf( '<li><a href="%s">%s</a></li>', esc_url( dokan_get_navigation_url( 'edit-account' ) ), esc_html__( 'Settings', 'martfury' ) );
			if ( function_exists( 'dokan_get_store_url' ) ) {
				$vendor[] = sprintf( '<li><a href="%s">%s</a></li>', esc_url( dokan_get_store_url( get_current_user_id() ) ), esc_html__( 'Visit Store', 'martfury' ) );
			}
			$vendor[] = sprintf( '<li><a href="%s">%s</a></li>', esc_url( dokan_get_navigation_url( 'withdraw' ) ), esc_html__( 'Withdraw', 'martfury' ) );
		} elseif ( class_exists( 'WCVendors_Pro' ) && in_array( 'vendor', $author->roles ) ) {
			$dashboard_page_id = WCVendors_Pro::get_option( 'dashboard_page_id' );
			if ( $dashboard_page_id ) {
				$dashboard_page_url = get_permalink( $dashboard_page_id );
				$vendor[]           = sprintf( '<li><a href="%s">%s</a></li>', esc_url( $dashboard_page_url ), esc_html__( 'Dashboard', 'martfury' ) );
				$vendor[]           = sprintf( '<li><a href="%s">%s</a></li>', esc_url( $dashboard_page_url . 'product' ), esc_html__( 'Products', 'martfury' ) );
				$vendor[]           = sprintf( '<li><a href="%s">%s</a></li>', esc_url( $dashboard_page_url . 'order' ), esc_html__( 'Orders', 'martfury' ) );
				$vendor[]           = sprintf( '<li><a href="%s">%s</a></li>', esc_url( $dashboard_page_url . 'settings' ), esc_html__( 'Settings', 'martfury' ) );
			}
		} elseif ( class_exists( 'WC_Vendors' ) && in_array( 'vendor', $author->roles ) ) {
			$vendor_dashboard_page = WC_Vendors::$pv_options->get_option( 'vendor_dashboard_page' );
			$shop_settings_page    = WC_Vendors::$pv_options->get_option( 'shop_settings_page' );

			if ( ! empty( $vendor_dashboard_page ) && ! empty( $shop_settings_page ) ) {
				if ( ! empty( $vendor_dashboard_page ) ) {
					$vendor[] = sprintf( '<li><a href="%s">%s</a></li>', esc_url( get_permalink( $vendor_dashboard_page ) ), esc_html__( 'Dashboard', 'martfury' ) );
				}
				if ( ! empty( $shop_settings_page ) ) {
					$vendor[] = sprintf( '<li><a href="%s">%s</a></li>', esc_url( get_permalink( $shop_settings_page ) ), esc_html__( 'Shop Settings', 'martfury' ) );
				}
				if ( class_exists( 'WCV_Vendors' ) ) {
					$shop_page = WCV_Vendors::get_vendor_shop_page( get_current_user_id() );
					$vendor[]  = sprintf( '<li><a href="%s">%s</a></li>', esc_url( $shop_page ), esc_html__( 'Visit Store', 'martfury' ) );
				}
			}

		}


		return $vendor;
	}
endif;

/**
 * Get Custom Vendor
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'martfury_nav_user_menu' ) ) :
	function martfury_nav_user_menu() {
		$user_menu = array();
		if ( ! has_nav_menu( 'user_logged' ) ) {
			$orders   = get_option( 'woocommerce_myaccount_orders_endpoint', 'orders' );
			$account  = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
			$orders   = $account . $orders;
			$wishlist = '';
			if ( shortcode_exists( 'yith_wishlist_constructor' ) ) {
				$wishlist = sprintf(
					'<li>
						<a href="%s">%s</a>
					</li>',
					esc_url( get_permalink( get_option( 'yith_wcwl_wishlist_page_id' ) ) ),
					esc_html__( 'My Wishlist', 'martfury' )
				);
			}

			$user_menu[] = sprintf(
				'<li>
					<a href="%s">%s</a>
				</li>
				<li>
					<a href="%s">%s</a>
				</li>
				<li>
					<a href="%s">%s</a>
				</li>
				%s
				</li>',
				esc_url( $account ),
				esc_html__( 'Dashboard', 'martfury' ),
				esc_url( $account . '/' . get_option( 'woocommerce_myaccount_edit_account_endpoint', 'edit-account' ) ),
				esc_html__( 'Account Settings', 'martfury' ),
				esc_url( $orders ),
				esc_html__( 'Orders History', 'martfury' ),
				$wishlist
			);
		} else {
			ob_start();
			martfury_get_nav_menu( 'user_logged' );
			$user_menu[] = ob_get_clean();
		}

		return $user_menu;
	}
endif;

/**
 * Get Custom Vendor
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'martfury_nav_vendor_menu' ) ) :
	function martfury_nav_vendor_menu() {
		$author = get_user_by( 'id', get_current_user_id() );
		$vendor_menu = array();

		if ( ! in_array( 'vendor', $author->roles ) && ! in_array( 'seller', $author->roles ) && ! in_array( 'dc_vendor', $author->roles ) ) {
			return $vendor_menu;
		}
		if ( ! has_nav_menu( 'vendor_logged' ) ) {
			$vendor_menu = martfury_vendor_navigation_url();
		} else {
			ob_start();
			martfury_get_nav_menu( 'vendor_logged' );
			$vendor_menu[] = ob_get_clean();
		}

		return $vendor_menu;
	}
endif;


/**
 * Get Menu extra cart
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'martfury_extra_cart' ) ) :
	function martfury_extra_cart() {
		$extras = martfury_menu_extras();

		if ( empty( $extras ) || ! in_array( 'cart', $extras ) ) {
			return '';
		}

		if ( ! function_exists( 'woocommerce_mini_cart' ) ) {
			return '';
		}
		global $woocommerce;
		ob_start();
		woocommerce_mini_cart();
		$mini_cart = ob_get_clean();

		$mini_content = sprintf( '	<div class="widget_shopping_cart_content">%s</div>', $mini_cart );

		printf(
			'<li class="extra-menu-item menu-item-cart mini-cart woocommerce">
			<a class="cart-contents" id="icon-cart-contents" href="%s">
				<i class="icon-bag2 extra-icon"></i>
				<span class="mini-item-counter">
					%s
				</span>
			</a>
			<div class="mini-cart-content">
			<span class="tl-arrow-menu"></span>
			%s
			</div>
		</li>',
			esc_url( wc_get_cart_url() ),
			intval( $woocommerce->cart->cart_contents_count ),
			$mini_content
		);

	}
endif;

/**
 * Get Menu extra wishlist
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'martfury_extra_wislist' ) ) :
	function martfury_extra_wislist() {
		$extras = martfury_menu_extras();


		if ( empty( $extras ) || ! in_array( 'wishlist', $extras ) ) {
			return '';
		}

		if ( ! function_exists( 'YITH_WCWL' ) ) {
			return '';
		}

		$count = YITH_WCWL()->count_products();

		printf(
			'<li class="extra-menu-item menu-item-wishlist menu-item-yith">
			<a class="yith-contents" id="icon-wishlist-contents" href="%s">
				<i class="icon-heart extra-icon" rel="tooltip"></i>
				<span class="mini-item-counter">
					%s
				</span>
			</a>
		</li>',
			esc_url( esc_url( get_permalink( get_option( 'yith_wcwl_wishlist_page_id' ) ) ) ),
			intval( $count )
		);

	}
endif;


/**
 * Get Menu extra search
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'martfury_extra_search' ) ) :
	function martfury_extra_search( $show_cat = true ) {
		$extras = martfury_menu_extras();
		$items  = '';

		if ( empty( $extras ) || ! in_array( 'search', $extras ) ) {
			return $items;
		}

		$cats_text   = martfury_get_option( 'custom_categories_text' );
		$search_text = martfury_get_option( 'custom_search_text' );
		$button_text = martfury_get_option( 'custom_search_button' );
		$search_type = martfury_get_option( 'search_content_type' );

		if ( $search_type == 'all' ) {
			$show_cat = false;
		}

		$cat = '';
		if ( taxonomy_exists( 'product_cat' ) && $show_cat ) {
			$cat = wp_dropdown_categories(
				array(
					'name'            => 'product_cat',
					'taxonomy'        => 'product_cat',
					'orderby'         => 'NAME',
					'hierarchical'    => 1,
					'hide_empty'      => 0,
					'echo'            => 0,
					'value_field'     => 'slug',
					'class'           => 'product-cat-dd',
					'show_option_all' => esc_html( $cats_text ),
				)
			);
		}
		$item_class     = empty( $cat ) ? 'no-cats' : '';
		$post_type_html = '';
		if ( $search_type == 'product' ) {
			$post_type_html = '<input type="hidden" name="post_type" value="product">';
		}
		$items .= sprintf(
			'<form class="products-search" method="get" action="%s">
					<div class="psearch-content">
						<div class="product-cat"><div class="product-cat-label %s">%s</div> %s</div>
						<div class="search-wrapper">
							<input type="text" name="s"  class="search-field" autocomplete="off" placeholder="%s">
							%s
							<div class="search-results"></div>
						</div>
						<button type="submit" class="search-submit">%s</button>
					</div>
				</form>',
			esc_url( home_url( '/' ) ),
			esc_attr( $item_class ),
			esc_html( $cats_text ),
			$cat,
			esc_html( $search_text ),
			$post_type_html,
			esc_html( $button_text )
		);

		echo $items;
	}
endif;


/**
 * Get header menu
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'martfury_header_menu' ) ) :
	function martfury_header_menu() {
		?>
		<div class="primary-nav nav">
			<?php martfury_get_nav_menu( 'primary' ); ?>
		</div>
		<?php
	}
endif;

/**
 * Get header bar
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'martfury_header_bar' ) ) :
	function martfury_header_bar() {
		?>
		<div class="header-bar topbar">
			<?php
			$sidebar = 'header-bar';
			if ( is_active_sidebar( $sidebar ) ) {
				dynamic_sidebar( $sidebar );
			}
			?>
		</div>
		<?php
	}
endif;

/**
 * Get header recently products
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'martfury_header_recently_products' ) ) :
	function martfury_header_recently_products() {

		if ( ! intval( martfury_get_option( 'header_recently_viewed' ) ) ) {
			return;
		}

		$title = martfury_get_option( 'header_recently_viewed_title' );
		if ( $title ):
			?>
			<h3 class="recently-title">
				<?php echo esc_html( $title ); ?>
			</h3>
			<?php
			echo '<div class="mf-recently-products header-recently-viewed" id="header-recently-viewed"><div class="mf-loading"></div></div>';
		endif;
	}
endif;

/**
 * Get header exrta department
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'martfury_extra_department' ) ) :
	function martfury_extra_department( $dep_close = false, $id = '' ) {
		$extras = martfury_menu_extras();

		if ( empty( $extras ) || ! in_array( 'department', $extras ) ) {
			return;
		}

		if ( ! has_nav_menu( 'shop_department' ) ) {
			return;
		}

		$dep_text = '<i class="icon-menu">&nbsp;</i>';
		$dep_text .= '<span class="text">' . martfury_get_option( 'custom_department_text' ) . '</span>';
		$dep_open = 'close';

		if ( in_array( martfury_get_option( 'header_layout' ), array(
				'1',
				'3',
			) ) && ! $dep_close && martfury_is_homepage() ) {
			$dep_open = martfury_get_option( 'department_open_homepage' );
		}
		$cat_style = '';
		if ( martfury_get_option( 'header_layout' ) == '3' ) {
			$space = martfury_get_option( 'department_space_homepage' );
			if ( martfury_is_homepage() && $space ) {
				$cat_style = sprintf( 'style=padding-top:%s', esc_attr( $space ) );
			}
		}

		?>
		<div class="products-cats-menu <?php echo esc_attr( $dep_open ); ?>">
			<h2 class="cats-menu-title"><?php echo wp_kses( $dep_text, wp_kses_allowed_html( 'post' ) ); ?></h2>

			<div class="toggle-product-cats nav" <?php echo esc_attr( $cat_style ); ?>>
				<?php martfury_get_nav_menu( 'shop_department', true, $id ); ?>
			</div>
		</div>
		<?php
	}
endif;


/**
 * Get header exrta department
 *
 * @since  1.0.0
 *
 *
 * @return string
 */
if ( ! function_exists( 'martfury_get_nav_menu' ) ) :
	function martfury_get_nav_menu( $location, $walker = true, $id = '' ) {
		$nav_menu   = (array) get_transient( 'martfury_nav_menu_query' );
		$query_slug = $location . intval( $walker ) . $id;
		$query_hash = md5( $query_slug );

		if ( ! has_nav_menu( $location ) ) {
			return;
		}

		if ( ! isset( $nav_menu[ $query_hash ] ) ) {
			$options = array(
				'theme_location' => $location,
				'container'      => false,
				'echo'           => 0,
				'menu_id'        => $query_slug,
			);

			if ( $walker ) {
				$options['walker'] = new Martfury_Mega_Menu_Walker();
			}
			$nav_menu[ $query_hash ] = wp_nav_menu( $options );
			set_transient( 'martfury_nav_menu_query', $nav_menu, DAY_IN_SECONDS );
		}

		echo $nav_menu[ $query_hash ];

		?>
		<?php
	}
endif;


/**
 * Get menu extra
 *
 * @since  1.0.0
 *
 *
 * @return string
 */

if ( ! function_exists( 'martfury_menu_extras' ) ) :
	function martfury_menu_extras() {
		$menu_extras = martfury_get_option( 'menu_extras' );

		return $menu_extras;
	}
endif;


/**
 * Returns CSS for the color schemes.
 *
 *
 * @param array $colors Color scheme colors.
 *
 * @return string Color scheme CSS.
 */
function martfury_get_color_scheme_css( $colors, $darken_color ) {
	return <<<CSS
	/* Color Scheme */

	/* Color */

	a:hover, 
	.primary-color, 
	.site-header .products-cats-menu .menu > li:hover > a, 
	.header-layout-3 .site-header .primary-nav > ul > li > a:hover, 
	.header-layout-6 .site-header .primary-nav > ul > li > a:hover, 
	.header-layout-6 .site-header .primary-nav > ul > li.current-menu-parent > a,.header-layout-6 .site-header .primary-nav > ul > li.current-menu-item > a,.header-layout-6 .site-header .primary-nav > ul > li.current-menu-ancestor > a, 
	.page-header .breadcrumbs, 
	.single-post-header .entry-metas a:hover, 
	.single-post-header.layout-2.has-bg .entry-metas a:hover, 
	.page-header-catalog .page-breadcrumbs a:hover, 
	.page-header-page .page-breadcrumbs a:hover, 
	.page-header-default .page-breadcrumbs a:hover, 
	.nav li li a:hover, 
	.blog-wapper .categories-links a:hover, 
	.blog-wapper .entry-title a:hover, 
	.blog-wapper .entry-meta a:hover, 
	.blog-wapper.sticky .entry-title:hover:before, 
	.numeric-navigation .page-numbers.current,.numeric-navigation .page-numbers:hover, 
	.single-post .entry-header .entry-metas a:hover, 
	.single-post .entry-format.format-quote blockquote cite a:hover, 
	.single-post .entry-footer .tags-links a:hover, 
	.single-post .post-navigation .nav-links a:hover, 
	.error-404 .page-content a, 
	.woocommerce ul.products li.product.product-category:hover .woocommerce-loop-category__title,.woocommerce ul.products li.product.product-category:hover .count, 
	.woocommerce ul.products li.product .mf-product-details-hover .sold-by-meta a:hover, 
	.woocommerce ul.products li.product .mf-product-details-hover .product-title, 
	.woocommerce ul.products li.product h2:hover a, 
	.woocommerce.shop-view-list .mf-shop-content ul.products li.product .mf-product-details h2 a:hover, 
	.woocommerce.shop-view-list .mf-shop-content ul.products li.product .mf-product-details .mf-product-price-box .yith-wcwl-add-to-wishlist .yith-wcwl-add-button > a:hover,.woocommerce.shop-view-list .mf-shop-content ul.products li.product .mf-product-details .mf-product-price-box .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse > a:hover,.woocommerce.shop-view-list .mf-shop-content ul.products li.product .mf-product-details .mf-product-price-box .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse > a:hover, 
	.woocommerce.shop-view-list .mf-shop-content ul.products li.product .mf-product-details .mf-product-price-box .compare-button .compare:hover, 
	.woocommerce-cart .woocommerce table.shop_table td.product-remove .mf-remove:hover, 
	.woocommerce-account .woocommerce .woocommerce-MyAccount-navigation ul li a:hover, 
	.woocommerce-account .woocommerce .woocommerce-Addresses .woocommerce-Address .woocommerce-Address-edit .edit:hover, 
	.catalog-sidebar .woocommerce-widget-layered-nav .woocommerce-widget-layered-nav-list .woocommerce-widget-layered-nav-list__item.chosen.show-swatch .swatch-label, 
	.catalog-sidebar .widget_rating_filter ul .wc-layered-nav-rating.chosen a:after, 
	.catalog-sidebar .widget_rating_filter ul .wc-layered-nav-rating.chosen.show-swatch .swatch-label, 
	.mf-catalog-topbar .widget .woocommerce-ordering li li .active, 
	.mf-catalog-topbar .woocommerce-widget-layered-nav .woocommerce-widget-layered-nav-list .woocommerce-widget-layered-nav-list__item.show-swatch.chosen .swatch-color:before, 
	.mf-catalog-topbar .catalog-filter-actived .remove-filter-actived, 
	.mf-products-top-carousel .carousel-header .cats-list li a:hover, 
	.mf-catalog-top-categories .top-categories-list .categories-list > li:hover > a, 
	.mf-catalog-top-categories .top-categories-grid .cats-list .parent-cat:hover, 
	.mf-catalog-top-categories .top-categories-grid .cats-list ul li.view-more a:hover, 
	.mf-other-categories .categories-list .cats-list .parent-cat:hover, 
	.dokan-dashboard .dokan-dashboard-wrap .dokan-table a:hover, 
	.dokan-widget-area .dokan-category-menu #cat-drop-stack > ul li.parent-cat-wrap a:hover, 
	.dokan-store.shop-view-list .seller-items ul.products li.product .mf-product-details h2 a:hover, 
	.dokan-store.shop-view-list .seller-items ul.products li.product .mf-product-details .mf-product-price-box .yith-wcwl-add-to-wishlist .yith-wcwl-add-button > a:hover,.dokan-store.shop-view-list .seller-items ul.products li.product .mf-product-details .mf-product-price-box .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse > a:hover,.dokan-store.shop-view-list .seller-items ul.products li.product .mf-product-details .mf-product-price-box .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse > a:hover, 
	.dokan-store.shop-view-list .seller-items ul.products li.product .mf-product-details .mf-product-price-box .compare-button .compare:hover, 
	.comment-respond .logged-in-as a:hover, 
	.widget ul li a:hover, 
	.widget_product_tag_cloud a:hover, 
	.widget-language ul li a:hover, 
	.widget-language ul li.active a, 
	.widgets-area ul li.current-cat > a,.dokan-store-sidebar ul li.current-cat > a,.widgets-area ul li.chosen > a,.dokan-store-sidebar ul li.chosen > a,.widgets-area ul li.current-cat > .count,.dokan-store-sidebar ul li.current-cat > .count,.widgets-area ul li.chosen > .count,.dokan-store-sidebar ul li.chosen > .count, 
	.widgets-area ul li .children li.current-cat > a,.dokan-store-sidebar ul li .children li.current-cat > a, 
	.widgets-area .mf_widget_product_categories ul li .children li.current-cat > a,.dokan-store-sidebar .mf_widget_product_categories ul li .children li.current-cat > a, 
	.site-footer .footer-info .info-item i, 
	.mf-recently-products .recently-header .link:hover, 
	.martfury-icon-box.icon_position-top-center .box-icon, 
	.martfury-icon-box.icon_position-left .box-icon, 
	.martfury-icon-box .box-url:hover, 
	.martfury-icon-box-2 .box-item .box-icon, 
	.martfury-latest-post .extra-links a:hover, 
	.mf-image-box .box-title a:hover, 
	.martfury-counter .mf-icon, 
	.martfury-testimonial-slides .testimonial-info > i, 
	.martfury-faq_group .g-title, 
	.mf-products-of-category .cats-info .extra-links li a:hover, 
	.mf-products-of-category .cats-info .footer-link .link:hover, 
	.mf-products-of-category .products-box ul.products li.product .product-inner:hover .mf-product-content h2 a, 
	.mf-category-tabs .tabs-header ul li a.active, 
	.mf-category-tabs .tabs-header ul li a.active h2, 
	.mf-products-of-category-2 .cats-header .extra-links li a:hover, 
	.mf-products-of-category-2 .products-side .link:hover, 
	.mf-category-box .cat-header .extra-links li a:hover, 
	.mf-category-box .sub-categories .term-item:hover .term-name, 
	.mf-products-carousel .cat-header .cat-title a:hover, 
	.mf-products-carousel .cat-header .extra-links li a:hover, 
	.mf-product-deals-day ul.products li.product .sold-by-meta a:hover, 
	.mf-product-deals-day .header-link a:hover, 
	.mf-product-deals-carousel .product .entry-summary .product-title a:hover{
		color: {$colors};
	}

	/* Background Color */

	.btn-primary,.btn,
	.slick-dots li:hover button,.slick-dots li.slick-active button,
	#nprogress .bar,
	.mf-newsletter-popup .newletter-content .mc4wp-form input[type="submit"],
	.site-header .products-search .search-submit,
	.site-header .extras-menu > li > a .mini-item-counter,
	.header-layout-1 .site-header .products-cats-menu:before,
	.header-layout-2 .site-header .main-menu,
	.header-layout-3 .site-header,
	.header-layout-3 .site-header .products-cats-menu .menu > li:hover,
	.header-layout-4 .site-header,
	.page-header-catalog .page-title,
	.single-post .post-password-form input[type=submit],
	.woocommerce a.button,.woocommerce button.button,.woocommerce input.button,.woocommerce #respond input#submit,
	.woocommerce a.button:hover,.woocommerce button.button:hover,.woocommerce input.button:hover,.woocommerce #respond input#submit:hover,
	.woocommerce a.button.alt,.woocommerce button.button.alt,.woocommerce input.button.alt,.woocommerce #respond input#submit.alt,
	.woocommerce a.button.alt:hover,.woocommerce button.button.alt:hover,.woocommerce input.button.alt:hover,.woocommerce #respond input#submit.alt:hover,
	
	.woocommerce ul.products li.product .mf-product-thumbnail .compare-button .compare:hover,
	.woocommerce ul.products li.product .mf-product-thumbnail .footer-button > a:hover,.woocommerce ul.products li.product .mf-product-thumbnail .footer-button .added_to_cart:hover,
	.woocommerce.shop-view-list .mf-shop-content ul.products li.product .mf-product-details .mf-product-price-box .button,
	.woocommerce.shop-view-list .mf-shop-content ul.products li.product .mf-product-details .mf-product-price-box .added_to_cart.wc-forward,
	.woocommerce div.product .wc-tabs-wrapper ul.tabs .tl-wc-tab,
	.woocommerce div.product form.cart .single_add_to_cart_button,
	.woocommerce nav.woocommerce-pagination ul li span.current,.woocommerce nav.woocommerce-pagination ul li a:hover,
	.woocommerce-cart .woocommerce table.cart .btn-shop,.woocommerce-cart .woocommerce table.checkout .btn-shop,
	.woocommerce-account .woocommerce .woocommerce-MyAccount-navigation ul li.is-active,
	.woocommerce-account .woocommerce .woocommerce-MyAccount-content .my_account_orders .leave_feedback,
	.mf-product-fbt .product-buttons .mf_add_to_cart_button,
	.mf-product-instagram .slick-slider .slick-dots li.slick-active,
	.mf-product-instagram .slick-slider .slick-dots li:hover button,.mf-product-instagram .slick-slider .slick-dots li.slick-active button,
	.dokan-dashboard .dokan-dashboard-wrap .dokan-btn,
	.dokan-widget-area .seller-form .dokan-btn,
	.dokan-widget-area .seller-form .dokan-btn:hover,
	.dokan-widget-area .dokan-store-contact .dokan-btn,
	.dokan-widget-area .dokan-store-contact .dokan-btn:hover,
	.dokan-store.shop-view-list .seller-items ul.products li.product .mf-product-details .mf-product-price-box .button,
	.dokan-store.shop-view-list .seller-items ul.products li.product .mf-product-details .mf-product-price-box .added_to_cart.wc-forward,
	.dokan-pagination-container ul.dokan-pagination li.active a,.dokan-pagination-container ul.dokan-pagination li a:hover,
	.dokan-seller-listing .store-footer .dokan-btn,
	.comment-respond .form-submit .submit,
	.widget .mc4wp-form input[type="submit"],
	.site-footer .footer-newsletter .newsletter-form .mc4wp-form-fields input[type="submit"],
	.mf-recently-products .product-list li .btn-secondary,
	.martfury-button.color-dark a,
	.martfury-button.color-white a,
	.martfury-journey ul a.active span,.martfury-journey ul a:hover span,
	.martfury-member:after,
	.martfury-process .process-step:before,
	.martfury-newletter .mc4wp-form input[type="submit"],.woocommerce ul.products li.product .mf-product-thumbnail .yith-wcwl-add-to-wishlist .yith-wcwl-add-button > a:hover,.woocommerce ul.products li.product .mf-product-thumbnail .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse > a:hover,.woocommerce ul.products li.product .mf-product-thumbnail .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse > a:hover,
	.wpcf7 input[type="submit"],
	.mf-category-tabs .tabs-header ul li:after,
	.mf-product-deals-day ul.slick-dots li.slick-active button,
	.mf-product-deals-grid .cat-header,
	.woocommerce .tawc-deal .deal-progress .progress-value,
	.mf-products-list-carousel ul.slick-dots li.slick-active button {
		background-color: {$colors};
	}
	
	.widget_shopping_cart_content .woocommerce-mini-cart__buttons .checkout,
	 .header-layout-4 .topbar,
	 .header-layout-3 .topbar{
		background-color: {$darken_color};
	}

	/* Border Color */
	.slick-dots li button, 
	.woocommerce.shop-view-list .mf-shop-content ul.products li.product .mf-product-details .mf-product-price-box .compare-button .compare:hover:after, 
	.woocommerce div.product div.images .product-degree-images, 
	.woocommerce div.product div.images .flex-control-nav li:hover img, 
	.woocommerce div.product div.images .flex-control-nav li img.flex-active, 
	.woocommerce div.product .tawcvs-swatches .swatch.selected, 
	.woocommerce div.product .tawcvs-swatches .swatch.swatch-color.selected:after, 
	.catalog-sidebar .woocommerce-widget-layered-nav .woocommerce-widget-layered-nav-list .woocommerce-widget-layered-nav-list__item.chosen a:before, 
	.catalog-sidebar .woocommerce-widget-layered-nav .woocommerce-widget-layered-nav-list .woocommerce-widget-layered-nav-list__item.chosen.show-swatch .swatch-label, 
	.catalog-sidebar .widget_rating_filter ul .wc-layered-nav-rating.chosen a:before, 
	.catalog-sidebar .widget_rating_filter ul .wc-layered-nav-rating.chosen.show-swatch .swatch-label, 
	.mf-catalog-categories-4 .cat-item:hover, 
	.mf-catalog-top-categories .top-categories-list .categories-list .sub-categories, 
	.mf-catalog-top-categories .top-categories-grid .cats-list ul li.view-more a:hover, 
	.mf-product-instagram .slick-slider .slick-dots li button, 
	.mf-recently-products .recently-header .link:hover, 
	.mf-recently-products .product-list li a:hover, 
	.mf-image-box:hover, 
	.martfury-process .process-step .step, 
	.martfury-bubbles, 
	.mf-product-deals-carousel, 
	.mf-products-list-carousel ul.slick-dots li.slick-active button, 
	.mf-product-deals-grid ul.products{
		border-color: {$colors};
	}
	
	.mf-loading:before,
	.woocommerce .blockUI.blockOverlay:after,
	.mf-product-gallery-degree .mf-gallery-degree-spinner:before{
		  border-color: {$colors} {$colors} {$colors} transparent;
	}
	
	#nprogress .peg {  box-shadow: 0 0 10px {$colors}, 0 0 5px {$colors};}
	
	blockquote {
		border-left-color:{$colors};
	}
	
	.mf-product-deals-day .header-link a:hover{border-bottom-color: {$colors}; }
	
CSS;
}

if ( ! function_exists( 'martfury_typography_css' ) ) :
	/**
	 * Get typography CSS base on settings
	 *
	 * @since 1.1.6
	 */
	function martfury_typography_css() {
		$css        = '';
		$properties = array(
			'font-family'    => 'font-family',
			'font-size'      => 'font-size',
			'variant'        => 'font-weight',
			'line-height'    => 'line-height',
			'letter-spacing' => 'letter-spacing',
			'color'          => 'color',
			'text-transform' => 'text-transform',
		);

		$settings = array(
			'body_typo'          => 'body',
			'heading1_typo'      => '.single .entry-content h1, .woocommerce div.product .woocommerce-tabs .panel h1',
			'heading2_typo'      => '.single .entry-content h2, .woocommerce div.product .woocommerce-tabs .panel h2',
			'heading3_typo'      => '.single .entry-content h3, .woocommerce div.product .woocommerce-tabs .panel h3',
			'heading4_typo'      => '.single .entry-content h4, .woocommerce div.product .woocommerce-tabs .panel h4',
			'heading5_typo'      => '.single .entry-content h5, .woocommerce div.product .woocommerce-tabs .panel h5',
			'heading6_typo'      => '.single .entry-content h6, .woocommerce div.product .woocommerce-tabs .panel h6',
			'menu_typo'          => '.site-header .primary-nav > ul > li > a, .site-header .products-cats-menu .menu > li > a',
			'mega_menu_typo'     => '.site-header .menu .is-mega-menu .dropdown-submenu .menu-item-mega > a',
			'sub_menu_typo'      => '.site-header .menu li li a',
			'footer_typo'        => '.site-footer',
			'footer_widget_typo' => '.site-footer .footer-widgets .widget .widget-title',
		);

		foreach ( $settings as $setting => $selector ) {
			$typography = martfury_get_option( $setting );
			$default    = (array) martfury_get_option_default( $setting );
			$style      = '';

			foreach ( $properties as $key => $property ) {
				if ( isset( $typography[ $key ] ) && ! empty( $typography[ $key ] ) ) {
					if ( isset( $default[ $key ] ) && strtoupper( $default[ $key ] ) == strtoupper( $typography[ $key ] ) ) {
						continue;
					}
					$value = 'font-family' == $key ? '"' . rtrim( trim( $typography[ $key ] ), ',' ) . '"' : $typography[ $key ];
					$value = 'variant' == $key ? str_replace( 'regular', '400', $value ) : $value;

					if ( $value ) {
						$style .= $property . ': ' . $value . ';';
					}
				}
			}

			if ( ! empty( $style ) ) {
				$css .= $selector . '{' . $style . '}';
			}
		}

		$css .= martfury_get_heading_typography_css();

		return $css;
	}
endif;

/**
 * Returns CSS for the typography.
 *
 *
 * @param array $body_typo Color scheme body typography.
 *
 * @return string typography CSS.
 */
function martfury_get_heading_typography_css() {

	$headings   = array(
		'h1' => 'heading1_typo',
		'h2' => 'heading2_typo',
		'h3' => 'heading3_typo',
		'h4' => 'heading4_typo',
		'h5' => 'heading5_typo',
		'h6' => 'heading6_typo',
	);
	$inline_css = '';
	foreach ( $headings as $heading ) {
		$keys = array_keys( $headings, $heading );
		if ( $keys ) {
			$inline_css .= martfury_get_heading_font( $keys[0], $heading );
		}
	}

	return $inline_css;

}

/**
 * Returns CSS for the typography.
 *
 *
 * @param array $body_typo Color scheme body typography.
 *
 * @return string typography CSS.
 */
function martfury_get_heading_font( $key, $heading ) {

	$inline_css   = '';
	$heading_typo = martfury_get_option( $heading );

	if ( $heading_typo ) {
		if ( isset( $heading_typo['font-family'] ) && strtolower( $heading_typo['font-family'] ) !== 'work sans' ) {
			$typo       = rtrim( trim( $heading_typo['font-family'] ), ',' );
			$inline_css .= $key . '{font-family:' . $typo . ', Arial, sans-serif}';

			if ( isset( $heading_typo['variant'] ) ) {
				$inline_css .= $key . '.vc_custom_heading{font-weight:' . $heading_typo['variant'] . '}';
			}
		}
	}

	if ( empty( $inline_css ) ) {
		return;
	}

	return <<<CSS
	{$inline_css}
CSS;
}