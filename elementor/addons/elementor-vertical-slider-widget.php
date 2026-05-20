<?php

/**
 * Elementor Widget
 * @package Highlt
 * @since 1.0.0
 */

namespace Elementor;

class Highlt_Vertical_Slider_Item_Widget extends Widget_Base
{

    public function get_name()
    {
        return 'highlt-vertical-slider-widget';
    }

    public function get_title()
    {
        return esc_html__('Vertical Slider', 'highlt-core');
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
        return ['highlt_widgets'];
    }

    protected function register_controls()
    {
        // ── General Settings ─────────────────────────────────────────────────
        $this->start_controls_section(
            'settings_section',
            [
                'label' => esc_html__('General Settings', 'highlt-core'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'slider_image',
            [
                'label' => esc_html__('Image', 'highlt-core'),
                'type'  => Controls_Manager::MEDIA,
            ]
        );

        $repeater->add_control(
            'slider_link',
            [
                'label'       => esc_html__('Link', 'highlt-core'),
                'type'        => Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'highlt-core'),
                'default'     => [ 'url' => '' ],
            ]
        );

        $this->add_control('hero_slider_items', [
            'label'  => esc_html__('Slides', 'highlt-core'),
            'type'   => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
        ]);

        $this->end_controls_section();

        // ── Slider Settings ──────────────────────────────────────────────────
        $this->start_controls_section(
            'slider_settings_section',
            [
                'label' => esc_html__('Slider Settings', 'highlt-core'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'speed',
            [
                'label'   => esc_html__('Animation Duration (ms)', 'highlt-core'),
                'type'    => Controls_Manager::SLIDER,
                'range'   => [
                    'px' => [ 'min' => 200, 'max' => 2000, 'step' => 50 ],
                ],
                'default' => [ 'unit' => 'px', 'size' => 800 ],
            ]
        );

        $this->end_controls_section();

        // ── Slider Container Style ────────────────────────────────────────────
        $this->start_controls_section(
            'slider_container_style',
            [
                'label' => esc_html__('Slider Container', 'highlt-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'slider_height',
            [
                'label'      => esc_html__('Height', 'highlt-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range'      => [
                    'px' => [ 'min' => 100, 'max' => 1200, 'step' => 10 ],
                    'vh' => [ 'min' => 10,  'max' => 100 ],
                ],
                'default'    => [ 'unit' => 'vh', 'size' => 100 ],
                'selectors'  => [
                    '{{WRAPPER}} .vertical-slider' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'slider_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'highlt-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .vertical-slider' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ── Slide Item Style ──────────────────────────────────────────────────
        $this->start_controls_section(
            'slide_item_style',
            [
                'label' => esc_html__('Slide Item', 'highlt-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'slide_image_object_fit',
            [
                'label'     => esc_html__('Object Fit', 'highlt-core'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    'cover'      => esc_html__('Cover', 'highlt-core'),
                    'contain'    => esc_html__('Contain', 'highlt-core'),
                    'fill'       => esc_html__('Fill', 'highlt-core'),
                    'scale-down' => esc_html__('Scale Down', 'highlt-core'),
                ],
                'default'   => 'cover',
                'selectors' => [
                    '{{WRAPPER}} .vertical-slider .vs-slide img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'slide_bg_color',
            [
                'label'     => esc_html__('Background Color', 'highlt-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .vertical-slider .vs-slide' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'slide_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'highlt-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .vertical-slider .vs-slide' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ── Pagination Style ──────────────────────────────────────────────────
        $this->start_controls_section(
            'pagination_style',
            [
                'label' => esc_html__('Pagination', 'highlt-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'pagination_color',
            [
                'label'     => esc_html__('Bullet Color', 'highlt-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .vertical-pagination .swiper-pagination-bullet' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'pagination_active_color',
            [
                'label'     => esc_html__('Active Bullet Color', 'highlt-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .vertical-pagination .swiper-pagination-bullet-active' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'pagination_size',
            [
                'label'     => esc_html__('Bullet Size', 'highlt-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
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
        $settings         = $this->get_settings_for_display();
        $all_slider_items = $settings['hero_slider_items'];

        $slider_settings = [
            'speed' => $settings['speed']['size'],
        ];
?>
        <div class="vertical-slider-area">
            <div class="vertical-slider" data-settings='<?php echo json_encode($slider_settings); ?>'>
                <div class="vs-track">
                    <?php foreach ($all_slider_items as $item) :
                        $url      = !empty($item['slider_link']['url']) ? esc_url($item['slider_link']['url']) : '';
                        $target   = !empty($item['slider_link']['is_external']) ? ' target="_blank"' : '';
                        $nofollow = !empty($item['slider_link']['nofollow']) ? ' rel="nofollow"' : '';
                    ?>
                        <div class="vs-slide">
                            <div class="vertical-slider-content">
                                <?php if ($url) : ?>
                                    <a href="<?php echo $url; ?>"<?php echo $target . $nofollow; ?>>
                                        <img src="<?php echo esc_url($item['slider_image']['url']); ?>" alt="">
                                    </a>
                                <?php else : ?>
                                    <img src="<?php echo esc_url($item['slider_image']['url']); ?>" alt="">
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="vertical-pagination"></div>
            </div>
        </div>
<?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type(new Highlt_Vertical_Slider_Item_Widget());
