<?php

/**
 * @wordpress-plugin
 * Plugin Name: کبوتر
 * Plugin URI: https://safine.net
 * Description: پلاگینی برای ابزار کبوتر که تمام پست‌ها و آدرس‌های پست‌های شما را می‌گیرد و در کبوتر اضافه می‌کند
 * Version: 1.1.0
 * Author: آکادمی سفینه (مهدی محمدی)
 * Author URI: https://safine.net/kabootar
 */

//Abort Direct Call Plugin
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'no-Access' );
}

// Plugin version
define( 'KABOOTAR_ADDON_PLUGIN', '1.0.0' );

//define necessary directories path
define( 'KAP_DIR', plugin_dir_path( __FILE__ ) );
define( 'KAP_URL', plugin_dir_url( __FILE__ ) );
define( 'KAP_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
define( 'KAP_INC_DIR', trailingslashit( KAP_DIR . 'inc' ) );

//register activate hook
register_activation_hook( __FILE__, 'kap_activation_hook' );

//register activate hook
register_deactivation_hook( __FILE__, 'kap_deactivation_hook' );

//register activation function
function kap_activation_hook() {
	require_once KAP_INC_DIR . 'KAP_ACTIVATOR.php';
	KAP_ACTIVATOR::activate();
}

//register de-activation function
function kap_deactivation_hook() {
	require_once KAP_INC_DIR . 'KAP_DEACTIVATOR.php';
	KAP_DEACTIVATOR::de_activate();
}

//core plugin class
require KAP_INC_DIR . 'class-kap-core.php';

//run and execute kap function
function execute_kap() {
	$plugin = new KAP_CORE();
	$plugin->run();
}

execute_kap();
