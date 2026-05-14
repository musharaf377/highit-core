<?php

$php_files = array(
    array(
        'file-name' => 'codestar-framework',
        'folder-name' => HIGHLT_CORE_LIB . '/codestar-framework'
    ),
    array(
        'file-name' => 'theme-menu-page',
        'folder-name' => HIGHLT_CORE_ADMIN
    ),
    array(
        'file-name' => 'theme-custom-post-type',
        'folder-name' => HIGHLT_CORE_ADMIN
    ),
    array(
        'file-name' => 'theme-highlt-core-excerpt',
        'folder-name' => HIGHLT_CORE_INC
    ),
    array(
        'file-name' => 'csf-taxonomy',
        'folder-name' => HIGHLT_CORE_INC
    ),
    array(
        'file-name' => 'theme-core-shortcodes',
        'folder-name' => HIGHLT_CORE_INC
    ),
    array(
        'file-name' => 'portfolio-tab-ajax',
        'folder-name' => HIGHLT_CORE_INC
    ),
    array(
        'file-name' => 'elementor-widget-init',
        'folder-name' => HIGHLT_CORE_ELEMENTOR
    ),
    array(
        'file-name' => 'theme-about-me-widget',
        'folder-name' => HIGHLT_CORE_WP_WIDGETS
    ),
    array(
        'file-name' => 'theme-about-us-widget',
        'folder-name' => HIGHLT_CORE_WP_WIDGETS
    ),
    array(
        'file-name' => 'theme-contact-info-widget',
        'folder-name' => HIGHLT_CORE_WP_WIDGETS
    )
);

if (defined('ELEMENTOR_VERSION')) {
    $php_files[] = array(
        'file-name' => 'theme-elementor-icon-manager',
        'folder-name' => HIGHLT_CORE_INC
    );
}

return $php_files;
