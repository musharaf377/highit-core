<?php

/**
 * Elementor Widget — Portfolio Tab
 * @package Highlt
 * @since 1.0.0
 */

namespace Elementor;

if (!defined('ABSPATH')) {
    exit;
}

class Highlt_Portfolio_Tab_Widget extends Widget_Base
{

    public function get_name()
    {
        return 'highlt-portfolio-tab-widget';
    }

    public function get_title()
    {
        return esc_html__('Portfolio Tab', 'highlt-core');
    }

    public function get_icon()
    {
        return 'eicon-slider-album';
    }

    public function get_categories()
    {
        return ['highlt_widgets'];
    }

    protected function register_controls()
    {

        $this->start_controls_section(
            'settings_section',
            [
                'label' => esc_html__('General Settings', 'highlt-core'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'image_tab_label',
            [
                'label'   => esc_html__('Image Tab Label', 'highlt-core'),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__('Images', 'highlt-core'),
            ]
        );

        $this->add_control(
            'video_tab_label',
            [
                'label'   => esc_html__('Video Tab Label', 'highlt-core'),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__('Videos', 'highlt-core'),
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label'       => esc_html__('Posts Per Page', 'highlt-core'),
                'type'        => Controls_Manager::NUMBER,
                'default'     => -1,
                'description' => esc_html__('Use -1 to show all portfolio items.', 'highlt-core'),
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'   => esc_html__('Order By', 'highlt-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date'       => esc_html__('Date', 'highlt-core'),
                    'title'      => esc_html__('Title', 'highlt-core'),
                    'menu_order' => esc_html__('Menu Order', 'highlt-core'),
                    'rand'       => esc_html__('Random', 'highlt-core'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label'   => esc_html__('Order', 'highlt-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'DESC' => esc_html__('Descending', 'highlt-core'),
                    'ASC'  => esc_html__('Ascending', 'highlt-core'),
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render the widget shell. Items are loaded via AJAX from the
     * Highlt_Portfolio_Tab_Ajax handler on tab activation.
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $image_tab_label = !empty($settings['image_tab_label']) ? $settings['image_tab_label'] : esc_html__('Images', 'highlt-core');
        $video_tab_label = !empty($settings['video_tab_label']) ? $settings['video_tab_label'] : esc_html__('Videos', 'highlt-core');

        $data_settings = array(
            'posts_per_page' => isset($settings['posts_per_page']) && $settings['posts_per_page'] !== '' ? (int) $settings['posts_per_page'] : -1,
            'orderby'        => !empty($settings['orderby']) ? sanitize_key($settings['orderby']) : 'date',
            'order'          => (!empty($settings['order']) && strtoupper($settings['order']) === 'ASC') ? 'ASC' : 'DESC',
        );

?>
        <div class="portfolio-tab-area" data-settings="<?php echo esc_attr(wp_json_encode($data_settings)); ?>">
            <div class="section-header">
                <nav class="tabs-nav">
                    <button type="button" class="tab-btn active" data-target="images-tab" data-tab="image"><?php echo esc_html($image_tab_label); ?></button>
                    <button type="button" class="tab-btn" data-target="videos-tab" data-tab="video"><?php echo esc_html($video_tab_label); ?></button>
                </nav>
            </div>

            <div class="content-area">
                <div id="images-tab" class="tab-content active" data-tab="image"></div>
                <div id="videos-tab" class="tab-content" data-tab="video"></div>
            </div>
        </div>
<?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type(new Highlt_Portfolio_Tab_Widget());
