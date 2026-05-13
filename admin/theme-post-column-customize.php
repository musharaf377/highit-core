<?php

/**
 * Post Column Customize Custom Function
 * @package Highlt
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
	exit(); //exit if access directly
}

if (!class_exists('highlt_Post_Column_Customize')) {
	class highlt_Post_Column_Customize
	{
		//$instance variable
		private static $instance;

		public function __construct()
		{
			//service admin add table value hook
			add_filter("manage_edit-service_columns", array($this, "edit_service_columns"));
			add_action('manage_service_posts_custom_column', array($this, 'add_thumbnail_columns'), 10, 2);
			//service category icon
			add_filter("manage_edit-ar_post_cat_columns", array($this, "edit_service_cat_columns"));
			add_filter('manage_ar_post_cat_custom_column', array($this, 'add_service_category_columns'), 13, 3);
		}

		/**
		 * get Instance
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
		 * Edit service
		 * @since 1.0.0
		 */
		public function edit_service_columns($columns)
		{

			$order = ('asc' == $_GET['order']) ? 'desc' : 'asc';
			$cat_title = $columns['taxonomy-ar_post_cat'];
			unset($columns);
			$columns['cb'] = '<input type="checkbox" />';
			$columns['title'] = esc_html__('Title', 'highlt-core');
			$columns['thumbnail'] = '<a href="edit.php?post_type=service&orderby=title&order=' . urlencode($order) . '">' . esc_html__('Thumbnail', 'highlt-core') . '</a>';
			$columns['taxonomy-ar_post_cat'] = '<a href="edit.php?post_type=service&orderby=taxonomy&order=' . urlencode($order) . '">' . $cat_title . '<span class="sorting-indicator"></span></a>';
			$columns['date'] = esc_html__('Date', 'highlt-core');
			return $columns;
		}

		/**
		 * Add thumbnail
		 * @since 1.0.0
		 */
		public function add_thumbnail_columns($column, $post_id)
		{
			switch ($column) {
				case 'thumbnail':
					echo '<a class="row-thumbnail" href="' . esc_url(admin_url('post.php?post=' . $post_id . '&amp;action=edit')) . '">' . get_the_post_thumbnail($post_id, 'thumbnail') . '</a>';
					break;
				default:
					break;
			}
		}

		/**
		 * Service category column customize
		 * @since 1.0.0
		 */
		public function edit_service_cat_columns($columns)
		{
			$columns['icon'] = esc_html__('Icon', 'highlt-core');
			return $columns;
		}

		/**
		 * Service Category column add
		 * @since 1.0.0
		 */
		public function add_service_category_columns($string, $columns, $post_id)
		{
			$post_term_meta = get_term_meta($post_id, 'highlt_service_category', true);
			$icon = isset($post_term_meta['icon']) ? $post_term_meta['icon'] : '';
			switch ($columns) {
				case 'icon':
					echo '<i class="neaterller-font-size50 ' . $icon . '"></i>';
					break;
				default:
					break;
			}
		}
	} //end class
	if (class_exists('highlt_Post_Column_Customize')) {
		highlt_Post_Column_Customize::getInstance();
	}
}
