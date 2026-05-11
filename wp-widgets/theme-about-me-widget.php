<?php

/**
 * Theme About Me Widget
 * @package Highit
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit(); //exit if access directly
}
// Control core classes for avoid errors
if (class_exists('CSF')) {
    // Create a About Widget
    CSF::createWidget('highit_about_me_widget', array(
        'title' => esc_html__('Highit: About Me', 'highit-core'),
        'classname' => 'highit-about-me-widget',
        'description' => esc_html__('Display About Me widget', 'highit-core'),
    ));

    // Create a About Widget

    if (!function_exists('highit_about_me_widget')) {
        function highit_about_me_widget($args, $instance)
        {
            echo $args['before_widget'];
            $highit = highit();
            $author_id = get_the_author_meta('ID');


?>
            <div class="author-info">
                <img src="<?php echo get_avatar_url(get_the_author_meta('email'), ['size' => '142']); ?>"
                    alt="">
                <h3 class="author-title"><?php echo get_the_author_meta('display_name', $author_id); ?></h3>
                <?php
                $highit->posted_on();
                ?>
            </div>
<?php
            echo $args['after_widget'];
        }
    }
}

?>