<?php

class KAP_CORE {

	protected $loader;

	protected $kap;

	/**
	 * KAP_CORE constructor.
	 */
	public function __construct() {
		$this->kap = 'kabootar';
		$this->load_files();
		error_reporting( 0 );
	}

	private function load_files() {
		//load dependencies
		require_once KAP_INC_DIR . 'class-kap-loader.php';
		require_once KAP_DIR . 'admin/class-kap-admin.php';
		require_once KAP_DIR . 'api/class-kap-api.php';

		$this->loader = new KAP_LOADER();
		$this->define_admin_hooks();
	}

	private function define_admin_hooks() {
		$kap_admin = new KAP_ADMIN();
		//enqueue admin styles
		$this->loader->add_action( 'admin_enqueue_scripts', $kap_admin, 'enqueue_styles' );
		//enqueue admin scripts
		$this->loader->add_action( 'admin_enqueue_scripts', $kap_admin, 'enqueue_scripts' );
		//add register token action link
		$this->loader->add_filter( "plugin_action_links", $kap_admin, 'add_action_link', 10, 2 );
		//add menu
		$this->loader->add_action( 'admin_menu', $kap_admin, 'kap_menu_init' );
		//add admin notice for token validate
		$this->loader->add_action( 'admin_notices', $kap_admin, 'kap_not_add_token' );
		//register token ajax action
		$this->loader->add_action( 'wp_ajax_register_token', $kap_admin, 'register_token' );
		$this->loader->add_action( 'wp_ajax_nopriv_register_token', $kap_admin, 'register_token' );
		//change token ajax action
		$this->loader->add_action( 'wp_ajax_change_token', $kap_admin, 'change_token' );
		$this->loader->add_action( 'wp_ajax_nopriv_change_token', $kap_admin, 'change_token' );
		//enable wp rest api
		$this->loader->add_filter( 'json_enabled', null, '__return_true' );
		$this->loader->add_filter( 'json_jsonp_enabled', null, '__return_true' );
		$this->loader->add_filter( 'rest_enabled', null, '__return_true' );
		$this->loader->add_filter( 'rest_jsonp_enabled', null, '__return_true' );
		//initialize kabotar rest api
		$this->loader->add_action( 'rest_api_init', $kap_admin, 'kap_rest_api' );
	}

	public function run() {
		$this->loader->run();
	}

	/**
	 * @return mixed
	 */
	public function getLoader() {
		return $this->loader;
	}

	/**
	 * @return string
	 */
	public function getKap() {
		return $this->kap;
	}

}