<?php
/*
Plugin Name: Highlt Core
Plugin URI: https://highlt.agency
Description: Plugin to contain short codes and custom post types of the Highlt theme.
Author: Highlt
Author URI: https://highlt.agency
Version: 1.0.0
Text Domain: highlt-core
*/

/**
 * If this file is called directly, abort.
 * @package highlt
 * @since 1.0.0
 */
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Plugin directory path
 * @package highlt
 * @since 1.0.0
 */
define('HIGHLT_CORE_ROOT_PATH', plugin_dir_path(__FILE__));
define('HIGHLT_CORE_ROOT_URL', plugin_dir_url(__FILE__));
define('HIGHLT_CORE_SELF_PATH', 'highlt-core/highlt-core.php');
define('HIGHLT_CORE_VERSION', '2.0.1');
define('HIGHLT_CORE_INC', HIGHLT_CORE_ROOT_PATH . '/inc');
define('HIGHLT_CORE_LIB', HIGHLT_CORE_ROOT_PATH . '/lib');
define('HIGHLT_CORE_CONFIG', HIGHLT_CORE_ROOT_PATH . '/config');
define('HIGHLT_CORE_ELEMENTOR', HIGHLT_CORE_ROOT_PATH . '/elementor');
define('HIGHLT_CORE_ADMIN', HIGHLT_CORE_ROOT_PATH . '/admin');
define('HIGHLT_CORE_ADMIN_ASSETS', HIGHLT_CORE_ROOT_URL . 'admin/assets');
define('HIGHLT_CORE_WP_WIDGETS', HIGHLT_CORE_ROOT_PATH . '/wp-widgets');
define('HIGHLT_CORE_ASSETS', HIGHLT_CORE_ROOT_URL . 'assets/');
define('HIGHLT_CORE_CSS', HIGHLT_CORE_ASSETS . 'css');
define('HIGHLT_CORE_JS', HIGHLT_CORE_ASSETS . 'js');
define('HIGHLT_CORE_IMG', HIGHLT_CORE_ASSETS . 'img');


/**
 * Load additional helpers functions
 * @package highlt
 * @since 1.0.0
 */
if (!function_exists('highlt_core')) {
	require_once HIGHLT_CORE_INC . '/theme-core-helper-functions.php';
	if (!function_exists('highlt_core')) {
		function highlt_core()
		{
			return class_exists('Highlt_Core_Helper_Functions') ? new Highlt_Core_Helper_Functions() : false;
		}
	}
}


/**
 * Load Codestar Framework Functions
 * @package highlt
 * @since 1.0.0
 */
if (!highlt_core()->is_highlt_active()) {
	if (file_exists(HIGHLT_CORE_ROOT_PATH . '/inc/csf-functions.php')) {
		require_once HIGHLT_CORE_ROOT_PATH . '/inc/csf-functions.php';
	}
}


/**
 * Core Plugin Init
 * @package highlt
 * @since 1.0.0
 */
if (file_exists(HIGHLT_CORE_ROOT_PATH . '/inc/theme-core-init.php')) {
	require_once HIGHLT_CORE_ROOT_PATH . '/inc/theme-core-init.php';
}
