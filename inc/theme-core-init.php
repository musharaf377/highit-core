<?php

/**
 * Theme Core Init
 * @package highit
 * @since 1.0.0
 */

if (!defined("ABSPATH")) {
    exit(); //exit if access directly
}

if (!class_exists('Highit_Core_Init')) {

    class Highit_Core_Init
    {
        /**
         * $instance
         * @since 1.0.0
         */
        protected static $instance;

        public function __construct()
        {
            //Load plugin assets
            add_action('wp_enqueue_scripts', array($this, 'plugin_assets'));
            //Load plugin admin assets
            add_action('admin_enqueue_scripts', array($this, 'admin_assets'));
            //load plugin text domain
            add_action('init', array($this, 'load_textdomain'));
            //load plugin dependency files()
            add_action('plugin_loaded', array($this, 'load_plugin_dependency_files'));
        }

        /**
         * getInstance()
         * @since 1.0.0
         */
        public static function getInstance()
        {
            if (null == self::$instance) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        /**
         * Load Plugin Text domain
         * @since 1.0.0
         */
        public function load_textdomain()
        {
            load_plugin_textdomain('highit-core', false, HIGHIT_CORE_ROOT_PATH . '/languages');
        }

        /**
         * Load plugin dependency files()
         * @since 1.0.0
         */
        public function load_plugin_dependency_files()
        {
            $includes_files = require_once HIGHIT_CORE_CONFIG . '/files-php.php';
        
            if (is_array($includes_files) && !empty($includes_files)) {
                foreach ($includes_files as $file) {
                    if (file_exists($file['folder-name'] . '/' . $file['file-name'] . '.php')) {
                        require_once $file['folder-name'] . '/' . $file['file-name'] . '.php';
                    }
                }
            }
        }

        /**
         * Admin assets
         * @since 1.0.0
         */
        public function plugin_assets()
        {
            self::load_plugin_css_files();
            self::load_plugin_js_files();
        }

        /**
         * Load plugin css files()
         * @since 1.0.0
         */
        public function load_plugin_css_files()
        {
            $plugin_version = HIGHIT_CORE_VERSION;

            $all_css_files = require_once HIGHIT_CORE_CONFIG . '/files-css.php';

            $all_css_files = apply_filters('highit_core_css', $all_css_files);

            if (is_array($all_css_files) && !empty($all_css_files)) {
                foreach ($all_css_files as $css) {
                    $css['ver'] = $plugin_version;
                    $css['media'] = 'all';
                    call_user_func_array('wp_enqueue_style', $css);
                }
            }
        }

        /**
         * Load plugin js
         * @since 1.0.0
         */
        public function load_plugin_js_files()
        {
            $plugin_version = HIGHIT_CORE_VERSION;

            $all_js_files = require_once HIGHIT_CORE_CONFIG . '/files-js.php';

            $all_js_files = apply_filters('highit_core_frontend_script_enqueue', $all_js_files);

            if (is_array($all_js_files) && !empty($all_js_files)) {
                foreach ($all_js_files as $js) {
                    wp_enqueue_script(
                        $js['handle'],
                        $js['src'],
                        $js['deps'],
                        $plugin_version,
                        $js['in_footer'] // Ensure this is passed to load the script in the footer
                    );
                }
            }
        }

        /**
         * Admin assets
         * @since 1.0.0
         */
        public function admin_assets()
        {
            self::load_admin_css_files();
            self::load_admin_js_files();
        }

        /**
         * Load plugin admin css files()
         * @since 1.0.0
         */
        public function load_admin_css_files()
        {
            $plugin_version = HIGHIT_CORE_VERSION;
            $all_css_files = array(
                array(
                    'handle' => 'highit-core-admin-style',
                    'src' => HIGHIT_CORE_ADMIN_ASSETS . '/css/admin.css',
                    'deps' => array(),
                    'ver' => $plugin_version,
                    'media' => 'all'
                ),
            );

            $all_css_files = apply_filters('highit_admin_css', $all_css_files);
            if (is_array($all_css_files) && !empty($all_css_files)) {
                foreach ($all_css_files as $css) {
                    call_user_func_array('wp_enqueue_style', $css);
                }
            }
        }

        /**
         * Load plugin admin js
         * @since 1.0.0
         */
        public function load_admin_js_files()
        {
            $plugin_version = HIGHIT_CORE_VERSION;
            $all_js_files = array(
                array(
                    'handle' => 'highit-core-widget',
                    'src' => HIGHIT_CORE_ADMIN_ASSETS . '/js/widget.js',
                    'deps' => array('jquery'),
                    'ver' => $plugin_version,
                ),
            );

            $all_js_files = apply_filters('highit_admin_js', $all_js_files);
            if (is_array($all_js_files) && !empty($all_js_files)) {
                foreach ($all_js_files as $js) {
                    call_user_func_array('wp_enqueue_script', $js);
                }
            }
        }
    } //end class
    if (class_exists('Highit_Core_Init')) {
        Highit_Core_Init::getInstance();
    }
}
