<?php

return array(
    [
        'post_type' => 'portfolio',
        'args' => array(
            'label' => esc_html__('Portfolio', 'highlt-core'),
            'description' => esc_html__('Portfolio', 'highlt-core'),
            'labels' => array(
                'name' => esc_html_x('Portfolio', 'Post Type General Name', 'highlt-core'),
                'singular_name' => esc_html_x('Portfolio', 'Post Type Singular Name', 'highlt-core'),
                'menu_name' => esc_html__('Portfolio', 'highlt-core'),
                'all_items' => esc_html__('Portfolio', 'highlt-core'),
                'view_item' => esc_html__('View Portfolio', 'highlt-core'),
                'add_new_item' => esc_html__('Add New Portfolio', 'highlt-core'),
                'add_new' => esc_html__('Add New Portfolio', 'highlt-core'),
                'edit_item' => esc_html__('Edit Portfolio', 'highlt-core'),
                'update_item' => esc_html__('Update Portfolio', 'highlt-core'),
                'search_items' => esc_html__('Search Portfolio', 'highlt-core'),
                'not_found' => esc_html__('Not Found', 'highlt-core'),
                'not_found_in_trash' => esc_html__('Not found in Trash', 'highlt-core'),
                'featured_image' => esc_html__('Portfolio Image', 'highlt-core'),
                'remove_featured_image' => esc_html__('Remove Portfolio Image', 'highlt-core'),
                'set_featured_image' => esc_html__('Set Portfolio Image', 'highlt-core'),
            ),
            'supports' => array('title', 'thumbnail', 'excerpt', 'editor', 'comments'),
            'taxonomies' => array('post_tag'), // this is IMPORTANT
            'hierarchical' => false,
            'public' => true,
            "publicly_queryable" => true,
            'show_ui' => true,
            "rewrite" => array('slug' => 'portfolio', 'with_front' => true),
            'can_export' => true,
            'capability_type' => 'post',
            "show_in_rest" => true,
            'query_var' => true
        )       
    ]
);
