<?php

$css_files = array(
    
    array(
        'handle' => 'highlt-swiper-css',
        'src' => HIGHLT_CORE_CSS . '/swiper.min.css',
        'deps' => array(),
    ),

    array(
        'handle' => 'highlt-core-main-style',
        'src' => HIGHLT_CORE_CSS . '/main-style.css',
        'deps' => array(),
    ),

    array(
        'handle' => 'highlt-ele-widgets',
        'src' => HIGHLT_CORE_CSS . '/ele-widgets.css',
        'deps' => array(),
    ),
    array(
        'handle' => 'highlt-ele-responsive',
        'src' => HIGHLT_CORE_CSS . '/responsive.css',
        'deps' => array(),
    ),


);

if (!highlt_core()->is_highlt_active()) {
    $css_files[] = array(
        'handle' => 'bootstrap',
        'src' => HIGHLT_CORE_CSS . '/bootstrap.min.css',
        'deps' => array(),
    );

    $css_files[] = array(
        'handle' => 'main-style',
        'src' => HIGHLT_CORE_CSS . '/main-style.css',
        'deps' => array(),
    );
    $css_files[] = array(
        'handle' => 'responsive',
        'src' => HIGHLT_CORE_CSS . '/responsive.css',
        'deps' => array(),
    );
}

return $css_files;
