<?php

/**
 * Theme About Us Widget
 * @package Highlt
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit(); //exit if access directly
}
// Control core classes for avoid errors
if (class_exists('CSF')) {


    // Create a About Widget
    CSF::createWidget('highlt_about_widget', array(
        'title' => esc_html__('Highlt: About Us', 'highlt-core'),
        'classname' => 'highlt-widget-about',
        'description' => esc_html__('Display about us widget', 'highlt-core'),
        'fields' => array(
            array(
                'id' => 'logo-area',
                'type' => 'media',
                'title' => esc_html__('Upload Your Photo', 'highlt-core'),
            ),
            array(
                'id' => 'description',
                'type' => 'textarea',
                'title' => esc_html__('Description', 'Highlt-core'),
                'default' => esc_html__('Find Us on', 'highlt-core')
            ),
            array(
                'id' => 'highlt-footer-download-image-repeater',
                'type' => 'repeater',
                'title' => esc_html__('Download Image', 'highlt-core'),
                'fields' => array(
                    array(
                        'id' => 'highlt-footer-download',
                        'type' => 'media',
                        'title' => esc_html__('Upload Your Download Photo', 'highlt-core'),
                    ),
                    array(
                        'id' => 'highlt-footer-download-url',
                        'type' => 'text',
                        'title' => esc_html__('Enter Your Url', 'highlt-core'),
                        'default' => esc_html__('#', 'highlt-core')
                    ),

                ),
            ),
        )
    ));


    if (!function_exists('highlt_about_widget')) {
        function highlt_about_widget($args, $instance)
        {

            echo $args['before_widget'];

            $logo = $instance['logo-area'];
            $img_id = $logo['id'] ?? '';
            $img_print = $img_id ? wp_get_attachment_image_src($img_id, 'full')[0] : '';
            $alt_text = get_post_meta($img_id, '_wp_attachment_image_alt', true);
            $paragraph = $instance['description'] ?? '';
            $socialIcon = is_array($instance['highlt-footer-download-image-repeater']) && !empty($instance['highlt-footer-download-image-repeater']) ? $instance['highlt-footer-download-image-repeater'] : [];


?>
            <div class="footer-widget widget">
                <div class="about_us_widget style-01">
                    <a href="<?php echo get_home_url(); ?>" class="footer-logo"><?php
                                                                                if (!empty($img_print)) {
                                                                                    printf('<img src="%1$s" alt="%2$s"/>', esc_url($img_print), esc_attr($alt_text));
                                                                                }
                                                                                ?></a>
                    <p> <?php echo $paragraph; ?></p>
                    <ul class="contact_info_list">
                        <?php
                        foreach ($socialIcon as $icon) {

                            echo '<li class="single-info-item"><a href="' . $icon['highlt-footer-download-url'] . '">
                              <img src="' . $icon['highlt-footer-download']['url'] . '" alt="' . $icon['highlt-footer-download']['alt'] . '">
                        </li>';
                        };
                        ?>
                    </ul>
                </div>
            </div>

<?php

            echo $args['after_widget'];
        }
    }
}

?>