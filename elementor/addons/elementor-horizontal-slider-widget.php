<?php

/**
 * Elementor Widget
 * @package Highit
 * @since 1.0.0
 */

namespace Elementor;

class Highit_horizontal_Slider_Item_Widget extends Widget_Base
{

    public function get_name()
    {
        return 'highit-horizontal-slider-widget';
    }

    public function get_title()
    {
        return esc_html__('Vertical Slider', 'highit-core');
    }

    public function get_keywords()
    {
        return ['Vertical Slider', 'slider'];
    }

    public function get_icon()
    {
        return 'eicon-image';
    }

    public function get_categories()
    {
        return ['highit_widgets'];
    }

    protected function register_controls()
    {
        // General Settings
        $this->start_controls_section(
            'settings_section',
            [
                'label' => esc_html__('General Settings', 'highit-core'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();
        $repeater->add_control(
            'slider_image',
            [
                'label' => esc_html__('Slider Image', 'highit-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control('hero_slider_items', [
            'label' => esc_html__('Vertical Slider Item', 'highit-core'),
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
        ]);

        $this->end_controls_section();

        // Slider Settings
        $this->start_controls_section(
            'slider_settings_section',
            [
                'label' => esc_html__('Slider Settings', 'highit-core'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => esc_html__('Slides To Show', 'highit-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => '3',
            ]
        );

        $this->add_control(
            'loop',
            [
                'label' => esc_html__('Loop', 'highit-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'highit-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'speed',
            [
                'label' => esc_html__('Speed', 'highit-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10000,
                        'step' => 500,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 3000,
                ],
            ]
        );

        $this->end_controls_section();

        // Slider Container Style
        $this->start_controls_section(
            'slider_container_style',
            [
                'label' => esc_html__('Slider Container', 'highit-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'slider_height',
            [
                'label' => esc_html__('Height', 'highit-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [ 'min' => 100, 'max' => 1200, 'step' => 10 ],
                    'vh' => [ 'min' => 10, 'max' => 100 ],
                ],
                'default' => [ 'unit' => 'px', 'size' => 500 ],
                'selectors' => [
                    '{{WRAPPER}} .vertical-slider' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'slider_margin',
            [
                'label' => esc_html__('Margin', 'highit-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .vertical-slider-area' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'slider_padding',
            [
                'label' => esc_html__('Padding', 'highit-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .vertical-slider-area' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'slider_border_radius',
            [
                'label' => esc_html__('Border Radius', 'highit-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .vertical-slider' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Slide Item Style
        $this->start_controls_section(
            'slide_item_style',
            [
                'label' => esc_html__('Slide Item', 'highit-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'slide_image_width',
            [
                'label' => esc_html__('Image Width', 'highit-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 2000 ],
                    '%'  => [ 'min' => 0, 'max' => 100 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .vertical-slider .swiper-slide img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'slide_image_height',
            [
                'label' => esc_html__('Image Height', 'highit-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 1200 ],
                    '%' => [ 'min' => 0, 'max' => 100 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .vertical-slider .swiper-slide img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'slide_image_object_fit',
            [
                'label' => esc_html__('Object Fit', 'highit-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'cover'      => esc_html__('Cover', 'highit-core'),
                    'contain'    => esc_html__('Contain', 'highit-core'),
                    'fill'       => esc_html__('Fill', 'highit-core'),
                    'scale-down' => esc_html__('Scale Down', 'highit-core'),
                ],
                'default' => 'cover',
                'selectors' => [
                    '{{WRAPPER}} .vertical-slider .swiper-slide img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'slide_bg_color',
            [
                'label' => esc_html__('Background Color', 'highit-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .vertical-slider .swiper-slide' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'slide_border_radius',
            [
                'label' => esc_html__('Border Radius', 'highit-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .vertical-slider .swiper-slide' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'slide_spacing',
            [
                'label' => esc_html__('Space Between Slides', 'highit-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 100 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .vertical-slider .swiper-slide' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Pagination Style
        $this->start_controls_section(
            'pagination_style',
            [
                'label' => esc_html__('Pagination', 'highit-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'pagination_color',
            [
                'label' => esc_html__('Bullet Color', 'highit-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .vertical-pagination .swiper-pagination-bullet' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_active_color',
            [
                'label' => esc_html__('Active Bullet Color', 'highit-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .vertical-pagination .swiper-pagination-bullet-active' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_size',
            [
                'label' => esc_html__('Bullet Size', 'highit-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [ 'min' => 4, 'max' => 30 ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .vertical-pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $all_slider_items = $settings['hero_slider_items'];

        $slider_settings = [
            'items'    => $settings['items'],
            'loop'     => $settings['loop'] === 'yes' ? true : false,
            'autoplay' => $settings['autoplay'] === 'yes' ? true : false,
            'speed'    => $settings['speed']['size'],
        ];
?>
        <div class="vertical-slider-area">
            <div class="swiper vertical-slider" data-settings='<?php echo json_encode($slider_settings); ?>'>
                <div class="swiper-wrapper">
                    <?php foreach ($all_slider_items as $item): ?>
                        <div class="swiper-slide">
                            <div class="vertical-slider-content">
                                <img src="<?php echo esc_url($item['slider_image']['url']); ?>" alt="">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="vertical-pagination">
                    <div class="hero-slider-btn-wrap">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type(new Highit_horizontal_Slider_Item_Widget());
