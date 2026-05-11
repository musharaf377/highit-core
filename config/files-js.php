<?php

$js_files = array(
    
    array(
        'handle' => 'swiper-js',
        'src' => HIGHIT_CORE_JS . '/swiper.min.js',
        'deps' => array('jquery'),
        'in_footer' => true
    ),

    array(
        'handle' => 'main',
        'src' => HIGHIT_CORE_JS . '/main.js',
        'deps' => array('jquery'),
        'in_footer' => true
    ),
);

if (!highit_core()->is_highit_active()) {
    $js_files[] = array(
        'handle' => 'bootstrap',
        'src' => HIGHIT_CORE_JS . '/bootstrap.min.js',
        'deps' => array('jquery'),
        'in_footer' => true
    );
}

return $js_files;
