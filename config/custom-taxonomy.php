<?php

return array(
    array(
        'taxonomy' => 'portfolio_cat',
        'object_type' => 'portfolio',
        'args' => array(
            "labels" => array(
                "name" => esc_html__("Portfolio Category", 'highlt-core'),
                "singular_name" => esc_html__("Portfolio Category", 'highlt-core'),
                "menu_name" => esc_html__("Portfolio Category", 'highlt-core'),
                "all_items" => esc_html__("All Portfolio Category", 'highlt-core'),
                "add_new_item" => esc_html__("Add New Portfolio Category", 'highlt-core')
            ),
            "public" => true,
            "hierarchical" => true,
            "show_ui" => true,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "query_var" => true,
            "rewrite" => array('slug' => 'portfolio_cat', 'with_front' => true),
            "show_admin_column" => true,
            "show_in_rest" => true,
            "show_in_quick_edit" => true,
        )
    ),
);
