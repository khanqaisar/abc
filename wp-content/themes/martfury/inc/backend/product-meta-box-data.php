<?php
/**
 * Functions and Hooks for product meta box data
 *
 * @package Martfury
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * martfury_Meta_Box_Product_Data class.
 */
class Martfury_Meta_Box_Product_Data {

	/**
	 * Constructor.
	 */
	public function __construct() {

		if ( ! function_exists( 'is_woocommerce' ) ) {
			return false;
		}
		// Add form
		add_action( 'woocommerce_product_data_panels', array( $this, 'product_meta_fields' ) );
		add_action( 'woocommerce_product_data_tabs', array( $this, 'product_meta_tab' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'product_meta_fields_save' ) );

		add_action( 'wp_ajax_product_meta_fields', array( $this, 'instance_product_meta_fields' ) );
		add_action( 'wp_ajax_nopriv_product_meta_fields', array( $this, 'instance_product_meta_fields' ) );
	}

	/**
	 * Get product data fields
	 *
	 */
	public function instance_product_meta_fields() {
		$post_id = $_POST['post_id'];
		ob_start();
		$this->create_product_extra_fields( $post_id );
		$response = ob_get_clean();
		wp_send_json_success( $response );
		die();
	}

	/**
	 * Product data tab
	 */
	public function product_meta_tab( $product_data_tabs ) {
		$product_data_tabs['martfury_instagram'] = array(
			'label'  => esc_html__( 'Instagram', 'martfury' ),
			'target' => 'product_martfury_instagram',
			'class'  => 'product-martfury_instagram'
		);

		return $product_data_tabs;
	}

	/**
	 * Add product data fields
	 *
	 */
	public function product_meta_fields() {
		global $post;
		$this->create_product_extra_fields( $post->ID );
	}

	/**
	 * product_meta_fields_save function.
	 *
	 * @param mixed $post_id
	 */
	public function product_meta_fields_save( $post_id ) {
		if ( isset( $_POST['product_instagram_hashtag'] ) ) {
			$woo_data = $_POST['product_instagram_hashtag'];
			update_post_meta( $post_id, 'product_instagram_hashtag', $woo_data );
		}
	}

	/**
	 * Create product meta fields
	 *
	 * @param $post_id
	 */
	public function create_product_extra_fields( $post_id ) {
		echo '<div id="product_martfury_instagram" class="panel woocommerce_options_panel">';
		woocommerce_wp_text_input(
			array(
				'id'       => 'product_instagram_hashtag',
				'label'    => esc_html__( 'Hashtag', 'martfury' ),
				'desc_tip' => esc_html__( 'Enter the hashtag for which photos will be displayed. If no hashtag is entered, no photos will display.', 'martfury' ),
			)
		);
		echo '</div>';


	}
}

new Martfury_Meta_Box_Product_Data;