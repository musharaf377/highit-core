<?php

return array(
    array(
        'taxonomy' => 'case_study_cat',
        'object_type' => 'case_study',
        'args' => array(
            "labels" => array(
                "name" => esc_html__("Case Study Category", 'highit-core'),
                "singular_name" => esc_html__("Case Study Category", 'highit-core'),
                "menu_name" => esc_html__("Case Study Category", 'highit-core'),
                "all_items" => esc_html__("All Case Study Category", 'highit-core'),
                "add_new_item" => esc_html__("Add New Case Study Category", 'highit-core')
            ),
            "public" => true,
            "hierarchical" => true,
            "show_ui" => true,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "query_var" => true,
            "rewrite" => array('slug' => 'case_study_cat', 'with_front' => true),
            "show_admin_column" => true,
            "show_in_rest" => true,
            "show_in_quick_edit" => true,
        )
    ),
);
