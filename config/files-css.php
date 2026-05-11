<?php

$css_files = array(
    
    array(
        'handle' => 'highit-swiper-css',
        'src' => HIGHIT_CORE_CSS . '/swiper.min.css',
        'deps' => array(),
    ),

    array(
        'handle' => 'highit-core-main-style',
        'src' => HIGHIT_CORE_CSS . '/main-style.css',
        'deps' => array(),
    ),

    array(
        'handle' => 'highit-ele-widgets',
        'src' => HIGHIT_CORE_CSS . '/ele-widgets.css',
        'deps' => array(),
    ),
    array(
        'handle' => 'highit-ele-responsive',
        'src' => HIGHIT_CORE_CSS . '/responsive.css',
        'deps' => array(),
    ),


);

if (!highit_core()->is_highit_active()) {
    $css_files[] = array(
        'handle' => 'bootstrap',
        'src' => HIGHIT_CORE_CSS . '/bootstrap.min.css',
        'deps' => array(),
    );

    $css_files[] = array(
        'handle' => 'main-style',
        'src' => HIGHIT_CORE_CSS . '/main-style.css',
        'deps' => array(),
    );
    $css_files[] = array(
        'handle' => 'responsive',
        'src' => HIGHIT_CORE_CSS . '/responsive.css',
        'deps' => array(),
    );
}

return $css_files;
