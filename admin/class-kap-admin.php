<?php

class KAP_ADMIN {
	public function enqueue_styles() {
		/**
		 * Include only in our plugin
		 */
		if (isset($_GET["page"]) && (strpos($_GET['page'], 'kabootar') !== false)) {
			wp_enqueue_style( 'kap_main_css', KAP_URL . 'admin/assets/css/main.css' );
			wp_register_style('prefix_bootstrap', KAP_URL . 'admin/assets/css/bootstrap.min.css');
			wp_enqueue_style( 'prefix_bootstrap' );
		}
	}

	public function enqueue_scripts() {
		/**
		 * Include only in our plugin
		 */
		if (isset($_GET["page"]) && (strpos($_GET['page'], 'kabootar') !== false)) {
			wp_register_script( 'kap_main_js', KAP_URL . 'admin/assets/js/main.js', array( 'jquery' ),
				'' );
			$nonce = wp_create_nonce( "kap_pub_nonce" );
			wp_localize_script( 'kap_main_js', 'kap_object', array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => $nonce
			) );
			wp_enqueue_script( 'kap_main_js' );
			wp_register_script('prefix_bootstrap', KAP_URL . 'admin/assets/js/bootstrap.min.js');
			wp_enqueue_script( 'prefix_bootstrap' );
		}
	}

	public function add_action_link( $links, $file ) {
		if ( $file !== KAP_PLUGIN_BASENAME ) {
			return $links;
		}
		$register_token_link = '<a href="admin.php?page=kabotar">' . esc_html__( 'ثبت توکن',
				'kabotar' ) . '</a>';
		array_unshift( $links, $register_token_link );

		return $links;
	}

	public function kap_menu_init() {
		add_options_page(
			__( 'ثبت توکن', 'kabotar' ),
			__( 'کبوتر', 'kabotar' ),
			'manage_options',
			'kabootar',
			[ $this, 'kap_token_menu_callback' ]
		);
	}

	public function kap_not_add_token() {
		$validity = get_option( '_kap_token', '' ) ?? '';
		if ( empty( $validity ) ) { ?>
            <div class="notice notice-error">
                <p style="font-size: 16px;">
					<?php esc_html_e( 'هنوز توکنی ثبت نکرده اید. برای ثبت توکن روی دکمه زیر کلیک کنید.',
						'kabotar' ); ?>
                </p>
                <p style="font-size: 16px;">
                    <a href="<?php echo admin_url() . 'options-general.php?page=kabootar' ?>">
                        <button class="btn btn-primary"><?php esc_html_e( 'ثبت توکن',
								'kabotar' ); ?></button>
                    </a>
                </p>
            </div>
		<?php }
	}

	public function kap_token_menu_callback() {
		if ( empty( get_option( '_kap_token' , '') ) ) {
			ob_start();
			include_once KAP_DIR . 'admin/temp/dash-menu-temp.php';
			echo ob_get_clean();
		} else {
			ob_start();
			include_once KAP_DIR . 'admin/temp/dash-menu-active-temp.php';
			echo ob_get_clean();
		}
	}

	public function register_token() {
		if ( wp_doing_ajax() && wp_verify_nonce( $_REQUEST['nonce'], 'kap_pub_nonce' ) ) {
			$token = $_POST['token'] ?? '';
			if ( ! empty( $token ) ) {
				update_option( '_kap_token', $token );
				echo json_encode( array(
					'code'     => '110',
					'response' => 'توکن شما با موفقیت ثبت شد'
				) );
			}
		} else {
			echo json_encode( array(
				'code'     => '25',
				'response' => 'مشکلی به وجود آمده لطفا دوباره تلاش کنید.'
			) );
		}
		die();
	}

	public function change_token() {
		if ( wp_doing_ajax() && wp_verify_nonce( $_REQUEST['nonce'], 'kap_pub_nonce' ) ) {
			$delete_option = delete_option( '_kap_token' );
			if ( $delete_option ) {
				echo json_encode( array(
					'code' => '110'
				) );
			}
		}
		die();
	}

	public function kap_rest_api() {
		$kap_api = new KAP_API();
		$kap_api->register_routes();
	}
}