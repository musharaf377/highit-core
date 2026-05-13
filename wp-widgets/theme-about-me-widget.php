<?php

/**
 * Theme About Me Widget
 * @package Highlt
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit(); //exit if access directly
}
// Control core classes for avoid errors
if (class_exists('CSF')) {
    // Create a About Widget
    CSF::createWidget('highlt_about_me_widget', array(
        'title' => esc_html__('Highlt: About Me', 'highlt-core'),
        'classname' => 'highlt-about-me-widget',
        'description' => esc_html__('Display About Me widget', 'highlt-core'),
    ));

    // Create a About Widget

    if (!function_exists('highlt_about_me_widget')) {
        function highlt_about_me_widget($args, $instance)
        {
            echo $args['before_widget'];
            $highlt = highlt();
            $author_id = get_the_author_meta('ID');


?>
            <div class="author-info">
                <img src="<?php echo get_avatar_url(get_the_author_meta('email'), ['size' => '142']); ?>"
                    alt="">
                <h3 class="author-title"><?php echo get_the_author_meta('display_name', $author_id); ?></h3>
                <?php
                $highlt->posted_on();
                ?>
            </div>
<?php
            echo $args['after_widget'];
        }
    }
}

?>