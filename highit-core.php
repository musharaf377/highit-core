<?php
/*
Plugin Name: Highit Core
Plugin URI: https://highit.agency
Description: Plugin to contain short codes and custom post types of the Highit theme.
Author: Highit
Author URI: https://highit.agency
Version: 1.0.0
Text Domain: highit-core
*/

/**
 * If this file is called directly, abort.
 * @package highit
 * @since 1.0.0
 */
if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

/**
 * Plugin directory path
 * @package highit
 * @since 1.0.0
 */
define('HIGHIT_CORE_ROOT_PATH', plugin_dir_path(__FILE__));
define('HIGHIT_CORE_ROOT_URL', plugin_dir_url(__FILE__));
define('HIGHIT_CORE_SELF_PATH', 'highit-core/highit-core.php');
define('HIGHIT_CORE_VERSION', '2.0.1');
define('HIGHIT_CORE_INC', HIGHIT_CORE_ROOT_PATH . '/inc');
define('HIGHIT_CORE_LIB', HIGHIT_CORE_ROOT_PATH . '/lib');
define('HIGHIT_CORE_CONFIG', HIGHIT_CORE_ROOT_PATH . '/config');
define('HIGHIT_CORE_ELEMENTOR', HIGHIT_CORE_ROOT_PATH . '/elementor');
define('HIGHIT_CORE_ADMIN', HIGHIT_CORE_ROOT_PATH . '/admin');
define('HIGHIT_CORE_ADMIN_ASSETS', HIGHIT_CORE_ROOT_URL . 'admin/assets');
define('HIGHIT_CORE_WP_WIDGETS', HIGHIT_CORE_ROOT_PATH . '/wp-widgets');
define('HIGHIT_CORE_ASSETS', HIGHIT_CORE_ROOT_URL . 'assets/');
define('HIGHIT_CORE_CSS', HIGHIT_CORE_ASSETS . 'css');
define('HIGHIT_CORE_JS', HIGHIT_CORE_ASSETS . 'js');
define('HIGHIT_CORE_IMG', HIGHIT_CORE_ASSETS . 'img');


/**
 * Load additional helpers functions
 * @package highit
 * @since 1.0.0
 */
if (!function_exists('highit_core')) {
	require_once HIGHIT_CORE_INC . '/theme-core-helper-functions.php';
	if (!function_exists('highit_core')) {
		function highit_core()
		{
			return class_exists('Highit_Core_Helper_Functions') ? new Highit_Core_Helper_Functions() : false;
		}
	}
}


/**
 * Load Codestar Framework Functions
 * @package highit
 * @since 1.0.0
 */
if (!highit_core()->is_highit_active()) {
	if (file_exists(HIGHIT_CORE_ROOT_PATH . '/inc/csf-functions.php')) {
		require_once HIGHIT_CORE_ROOT_PATH . '/inc/csf-functions.php';
	}
}


/**
 * Core Plugin Init
 * @package highit
 * @since 1.0.0
 */
if (file_exists(HIGHIT_CORE_ROOT_PATH . '/inc/theme-core-init.php')) {
	require_once HIGHIT_CORE_ROOT_PATH . '/inc/theme-core-init.php';
}
