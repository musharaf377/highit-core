<?php

/**
 * Theme Custom Post Type(CPTs)
 * @package Highit
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit(); //exit if access directly
}

if (!class_exists('Highit_Custom_Post_Type')) {
    class Highit_Custom_Post_Type
    {

        //$instance variable
        private static $instance;

        public function __construct()
        {
            //register post type
            add_action('init', array($this, 'register_custom_post_type'));
        }

        /**
         * get Instance
         * @since  2.0.0
         */
        public static function getInstance()
        {
            if (null == self::$instance) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        /**
         * Register Custom Post Type
         * @since  2.0.0
         */
        public function register_custom_post_type()
        {
            if (!defined('ELEMENTOR_VERSION')) {
                return;
            }

            $all_post_type = require_once HIGHIT_CORE_ROOT_PATH . '/config/cpt.php';

            if (!empty($all_post_type) && is_array($all_post_type)) {
                foreach ($all_post_type as $post_type) {
                    call_user_func_array('register_post_type', $post_type);
                }
            }


            /**
             * Custom Taxonomy Register
             * @since 1.0.0
             */

            $all_custom_taxonmy = require_once HIGHIT_CORE_ROOT_PATH . '/config/custom-taxonomy.php';

            if (is_array($all_custom_taxonmy) && !empty($all_custom_taxonmy)) {
                foreach ($all_custom_taxonmy as $taxonomy) {
                    call_user_func_array('register_taxonomy', $taxonomy);
                }
            }

            flush_rewrite_rules();
        }
    } //end class

    if (class_exists('Highit_Custom_Post_Type')) {
        Highit_Custom_Post_Type::getInstance();
    }
}
