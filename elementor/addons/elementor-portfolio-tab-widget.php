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
            'items_per_category',
            [
                'label'       => esc_html__('Items Per Category', 'highlt-core'),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 6,
                'min'         => 1,
                'description' => esc_html__('Initial items shown per category. Remaining items load via the Load More button.', 'highlt-core'),
            ]
        );

        $this->add_control(
            'load_more_label',
            [
                'label'   => esc_html__('Load More Label', 'highlt-core'),
                'type'    => Controls_Manager::TEXT,
                'default' => esc_html__('Load More', 'highlt-core'),
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

        // Image Title style controls (hover overlay on image tab)
        $this->start_controls_section(
            'image_title_style_section',
            [
                'label' => esc_html__('Image Title', 'highlt-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'image_title_background',
                'label'    => esc_html__('Background', 'highlt-core'),
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .portfolio-image-overlay',
            ]
        );

        $this->add_control(
            'image_title_color',
            [
                'label'     => esc_html__('Text Color', 'highlt-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .portfolio-image-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'image_title_typography',
                'label'    => esc_html__('Typography', 'highlt-core'),
                'selector' => '{{WRAPPER}} .portfolio-image-title',
            ]
        );

        $this->add_responsive_control(
            'image_title_padding',
            [
                'label'      => esc_html__('Overlay Padding', 'highlt-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top'    => 20,
                    'right'  => 20,
                    'bottom' => 20,
                    'left'   => 20,
                    'unit'   => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .portfolio-image-overlay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_title_align',
            [
                'label'   => esc_html__('Alignment', 'highlt-core'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left'   => [
                        'title' => esc_html__('Left', 'highlt-core'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'highlt-core'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'highlt-core'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'left',
                'selectors' => [
                    '{{WRAPPER}} .portfolio-image-overlay' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Load More Button style controls
        $this->start_controls_section(
            'load_more_style_section',
            [
                'label' => esc_html__('Load More Button', 'highlt-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'load_more_align',
            [
                'label'   => esc_html__('Alignment', 'highlt-core'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left'   => [
                        'title' => esc_html__('Left', 'highlt-core'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'highlt-core'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'highlt-core'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .portfolio-load-more-wrap' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'load_more_margin',
            [
                'label'      => esc_html__('Margin', 'highlt-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'    => 30,
                    'right'  => 0,
                    'bottom' => 0,
                    'left'   => 0,
                    'unit'   => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .portfolio-load-more-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'load_more_padding',
            [
                'label'      => esc_html__('Padding', 'highlt-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'default'    => [
                    'top'    => 10,
                    'right'  => 28,
                    'bottom' => 10,
                    'left'   => 28,
                    'unit'   => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .portfolio-load-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'load_more_typography',
                'label'    => esc_html__('Typography', 'highlt-core'),
                'selector' => '{{WRAPPER}} .portfolio-load-more',
            ]
        );

        $this->add_control(
            'load_more_border_style',
            [
                'label'   => esc_html__('Border Style', 'highlt-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'solid',
                'options' => [
                    'none'   => esc_html__('None', 'highlt-core'),
                    'solid'  => esc_html__('Solid', 'highlt-core'),
                    'dashed' => esc_html__('Dashed', 'highlt-core'),
                    'dotted' => esc_html__('Dotted', 'highlt-core'),
                    'double' => esc_html__('Double', 'highlt-core'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .portfolio-load-more' => 'border-style: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'load_more_border_width',
            [
                'label'      => esc_html__('Border Width', 'highlt-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default'    => [
                    'top'    => 1,
                    'right'  => 1,
                    'bottom' => 1,
                    'left'   => 1,
                    'unit'   => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .portfolio-load-more' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'load_more_border_style!' => 'none',
                ],
            ]
        );

        $this->add_responsive_control(
            'load_more_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'highlt-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default'    => [
                    'top'    => 0,
                    'right'  => 0,
                    'bottom' => 0,
                    'left'   => 0,
                    'unit'   => 'px',
                ],
                'selectors'  => [
                    '{{WRAPPER}} .portfolio-load-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('load_more_state_tabs');

        // Normal state
        $this->start_controls_tab(
            'load_more_normal_tab',
            [
                'label' => esc_html__('Normal', 'highlt-core'),
            ]
        );

        $this->add_control(
            'load_more_color',
            [
                'label'     => esc_html__('Text Color', 'highlt-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .portfolio-load-more' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_bg',
            [
                'label'     => esc_html__('Background Color', 'highlt-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .portfolio-load-more' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_border_color',
            [
                'label'     => esc_html__('Border Color', 'highlt-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FCFA13',
                'selectors' => [
                    '{{WRAPPER}} .portfolio-load-more' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'load_more_border_style!' => 'none',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover state
        $this->start_controls_tab(
            'load_more_hover_tab',
            [
                'label' => esc_html__('Hover', 'highlt-core'),
            ]
        );

        $this->add_control(
            'load_more_color_hover',
            [
                'label'     => esc_html__('Text Color', 'highlt-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .portfolio-load-more:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_bg_hover',
            [
                'label'     => esc_html__('Background Color', 'highlt-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FCFA13',
                'selectors' => [
                    '{{WRAPPER}} .portfolio-load-more:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'load_more_border_color_hover',
            [
                'label'     => esc_html__('Border Color', 'highlt-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '#FCFA13',
                'selectors' => [
                    '{{WRAPPER}} .portfolio-load-more:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'load_more_border_style!' => 'none',
                ],
            ]
        );

        $this->add_control(
            'load_more_transition',
            [
                'label'     => esc_html__('Transition Duration (s)', 'highlt-core'),
                'type'      => Controls_Manager::NUMBER,
                'min'       => 0,
                'max'       => 3,
                'step'      => 0.1,
                'default'   => 0.3,
                'selectors' => [
                    '{{WRAPPER}} .portfolio-load-more' => 'transition: all {{VALUE}}s ease;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

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
            'posts_per_page'     => isset($settings['posts_per_page']) && $settings['posts_per_page'] !== '' ? (int) $settings['posts_per_page'] : -1,
            'orderby'            => !empty($settings['orderby']) ? sanitize_key($settings['orderby']) : 'date',
            'order'              => (!empty($settings['order']) && strtoupper($settings['order']) === 'ASC') ? 'ASC' : 'DESC',
            'items_per_category' => isset($settings['items_per_category']) && $settings['items_per_category'] !== '' ? max(1, (int) $settings['items_per_category']) : 6,
            'load_more_label'    => !empty($settings['load_more_label']) ? $settings['load_more_label'] : esc_html__('Load More', 'highlt-core'),
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
