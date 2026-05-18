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

        // Style controls
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style', 'highlt-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'tabs_spacing',
            [
                'label'     => esc_html__('Tabs Padding', 'highlt-core'),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units'=> ['px', '%'],
                'default'   => [
                    'top'    => 0,
                    'right'  => 0,
                    'bottom' => 15,
                    'left'   => 0,
                    'unit'   => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-tab-area .tabs-nav' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'tab_button_font_size',
            [
                'label' => esc_html__('Tab Font Size (px)', 'highlt-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 14,
                'selectors' => [
                    '{{WRAPPER}} .portfolio-tab-area .tab-btn' => 'font-size: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_control(
            'tab_button_font_weight',
            [
                'label' => esc_html__('Tab Font Weight', 'highlt-core'),
                'type' => Controls_Manager::SELECT,
                'default' => '400',
                'options' => [
                    '300' => esc_html__('Light (300)', 'highlt-core'),
                    '400' => esc_html__('Normal (400)', 'highlt-core'),
                    '500' => esc_html__('Medium (500)', 'highlt-core'),
                    '600' => esc_html__('Semi Bold (600)', 'highlt-core'),
                    '700' => esc_html__('Bold (700)', 'highlt-core'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-tab-area .tab-btn' => 'font-weight: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'tab_button_border_style',

            [
                'label' => esc_html__('Tab Border Style', 'highlt-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'solid',
                'options' => [
                    'solid' => esc_html__('Solid', 'highlt-core'),
                    'dashed' => esc_html__('Dashed', 'highlt-core'),
                    'dotted' => esc_html__('Dotted', 'highlt-core'),
                    'double' => esc_html__('Double', 'highlt-core'),
                    'none' => esc_html__('None', 'highlt-core'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-tab-area .tab-btn' => 'border-style: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(

            'tab_button_bg',
            [
                'label' => esc_html__('Tab Background', 'highlt-core'),
                'type'  => Controls_Manager::COLOR,
                'default' => '#f5f5f5',
                'selectors' => [
                    '{{WRAPPER}} .portfolio-tab-area .tab-btn' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tab_button_color',
            [
                'label' => esc_html__('Tab Text Color', 'highlt-core'),
                'type'  => Controls_Manager::COLOR,
                'default' => '#222222',
                'selectors' => [
                    '{{WRAPPER}} .portfolio-tab-area .tab-btn' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tab_button_border_color',
            [
                'label' => esc_html__('Tab Border Color', 'highlt-core'),
                'type'  => Controls_Manager::COLOR,
                'default' => '#e5e5e5',
                'selectors' => [
                    '{{WRAPPER}} .portfolio-tab-area .tab-btn' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tab_button_active_bg',
            [
                'label' => esc_html__('Active Tab Background', 'highlt-core'),
                'type'  => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .portfolio-tab-area .tab-btn.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tab_button_active_color',
            [
                'label' => esc_html__('Active Tab Text Color', 'highlt-core'),
                'type'  => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .portfolio-tab-area .tab-btn.active' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tab_button_active_border_color',
            [
                'label' => esc_html__('Active Tab Border Color', 'highlt-core'),
                'type'  => Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .portfolio-tab-area .tab-btn.active' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tab_button_radius',
            [
                'label'      => esc_html__('Tab Radius', 'highlt-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top'    => 4,
                    'right'  => 4,
                    'bottom' => 4,
                    'left'   => 4,
                    'unit'   => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-tab-area .tab-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'tab_button_border_width',
            [
                'label' => esc_html__('Tab Border Width', 'highlt-core'),
                'type'  => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default' => [
                    'top' => 1,
                    'right' => 1,
                    'bottom' => 1,
                    'left' => 1,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-tab-area .tab-btn' => 'border-width: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px; border-style: solid;',
                ],
            ]

        );

        $this->add_control(
            'content_padding',
            [
                'label'      => esc_html__('Content Padding', 'highlt-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 0,
                    'left' => 0,
                    'unit' => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .portfolio-tab-area .tab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                <nav class="tabs-nav highlt-fade-animation">
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
