<?php

$js_files = array(
    
    array(
        'handle' => 'swiper-js',
        'src' => HIGHLT_CORE_JS . '/swiper.min.js',
        'deps' => array('jquery'),
        'in_footer' => true
    ),

    array(
        'handle' => 'main',
        'src' => HIGHLT_CORE_JS . '/main.js',
        'deps' => array('jquery'),
        'in_footer' => true
    ),
);

if (!highlt_core()->is_highlt_active()) {
    $js_files[] = array(
        'handle' => 'bootstrap',
        'src' => HIGHLT_CORE_JS . '/bootstrap.min.js',
        'deps' => array('jquery'),
        'in_footer' => true
    );
}

return $js_files;
