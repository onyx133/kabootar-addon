<?php

class KAP_API extends WP_REST_Controller {

	/**
	 * Register the routes for the objects of the controller.
	 */
	public function register_routes() {
		$version   = '1';
		$namespace = 'kabotar-addon/v' . $version;
		$route     = 'get_posts';
		register_rest_route( $namespace, '/' . $route, array(
			array(
				'methods'             => WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'get_items' ),
				'permission_callback' => array( $this, 'get_item_permissions_check' ),
				'args'                => $this->get_endpoint_args_for_item_schema( true ),
			)
		) );
	}

	/**
	 * Get a collection of items
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 *
	 * @return false|int[]|string|WP_Error|WP_Post[]|WP_REST_Response
	 */
	public function get_items( $request ) {
		$item = $request->get_params();
		if ( $item['token'] === get_option( '_kap_token', '' ) ) {
			$final_response = array();
			if ( $item['posts'] === '1' ) {
				$final_response['posts'] = $this->get_posts_results();
			}
			if ( $item['pages'] === '1' ) {
				$final_response['pages'] = $this->get_pages_results();
			}
			if ( $item['cat'] === '1' ) {
				$final_response['cat'] = $this->get_categories_results();
			}
			if ($item['tag'] === '1') {
				$final_response['tag'] = $this->get_tags_results();
			}
			if ( $item['product'] === '1' ) {
				$final_response['product'] = $this->get_products_results();
			}
			if ( $item['product_cat'] === '1' ) {
				$final_response['product_cat'] = $this->get_product_categories();
			}
			if ($item['product_tag'] === '1') {
				$final_response['product_tag'] = $this->get_product_tag();
			}

			return new WP_REST_Response( array( 'status' => 110, 'info' => $final_response ) );
		}

		return new WP_REST_Response( array( 'status' => 25, 'info' => "" ) );
	}

	/**
	 * @return array
	 */
	public function get_posts_results(): array {
		//get all rows from wp_posts_table where post_status = publish
		global $wpdb;
		$posts_tb_res = array();

		$result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}posts where post_type = 'post' AND
                                         post_status='publish' " );
		foreach ( $result as $key => $value ) {
			$posts_tb_res[ $key ] = array(
				'title' => $value->post_title,
				'url'   => get_permalink( $value->ID )
			);
		}

		return $posts_tb_res;
	}

	public function get_pages_results(): array {
		global $wpdb;
		$pages_tb_res = array();

		$result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}posts where post_type != 'post' AND
                                         post_type!= 'product' AND post_status='publish' " );
		foreach ( $result as $key => $value ) {
			$pages_tb_res[ $key ] = array(
				'title' => $value->post_title,
				'url'   => get_permalink( $value->ID )
			);
		}

		return $pages_tb_res;
	}

	/**
	 * @return array
	 */
	public function get_categories_results(): array {
		$categories = array();
		$cat_res    = get_categories( array(
			'orderby' => 'name',
			'order'   => 'ASC'
		) );
		foreach ( $cat_res as $key => $value ) {
			$categories[ $key ] = array(
				'title' => $value->name,
				'url'   => get_category_link( $value->cat_ID )
			);
		}

		return $categories;
	}

	/**
	 * @return array
	 */
	public function get_tags_results(): array {
		$tag_res = array();
		$tags    = get_tags( array( 'get' => 'all' ) );
		foreach ( $tags as $key => $value ) {
			$tag_res[ $key ] = array(
				'title' => $value->name,
				'url'  => get_tag_link( $value->term_id )
			);
		}

		return $tag_res;
	}

	public function get_products_results(): array {
		global $wpdb;
		$product_tb_res = array();

		$result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}posts where 
                                         post_type = 'product' AND post_status='publish' " );
		foreach ( $result as $key => $value ) {
			$product_tb_res[ $key ] = array(
				'title' => $value->post_title,
				'url'   => get_permalink( $value->ID )
			);
		}

		return $product_tb_res;
	}

	public function get_product_categories(): array {
		$product_cat_res = array();
		if ( class_exists( 'WooCommerce' ) ) {
			$pr_cat_args        = array(
				'taxonomy'   => "product_cat",
				'get'        => 'all',
				'hide_empty' => true,
			);

			$product_categories = get_terms( $pr_cat_args );
			foreach ( $product_categories as $key => $value ) {
				$product_cat_res[ $key ] = array(
					'title' => $value->name,
					'url'   => get_term_link( $value->term_id )
				);
			}

			return $product_cat_res;
		}

		return array();
	}

	public function get_product_tag() {
		if ( class_exists( 'WooCommerce' ) ) {
		$pr_tag_args        = array(
			'taxonomy'   => "product_tag",
			'get'        => 'all',
			'hide_empty' => true,
		);
		$product_tag_res    = get_terms( $pr_tag_args );
		foreach ( $product_tag_res as $key => $value ) {
			$product_tag_res[ $key ] = array(
				'title' => $value->name,
				'url'   => get_term_link( $value->term_id )
			);
		}
		return $product_tag_res;
		}
		return array();
	}

	/**
	 * Check if a given request has access to get items
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 *
	 * @return WP_Error|bool
	 */
	public function get_items_permissions_check( $request ) {
		//return true; <--use to make readable by all
		return '__return_true';
	}

	/**
	 * Check if a given request has access to get a specific item
	 *
	 * @param WP_REST_Request $request Full data about the request.
	 *
	 * @return WP_Error|bool
	 */
	public function get_item_permissions_check( $request ) {
		return $this->get_items_permissions_check( $request );
	}

}
