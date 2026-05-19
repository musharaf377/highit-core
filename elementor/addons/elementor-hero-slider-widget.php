<?php

/**
 * Elementor Widget
 * @package Highlt
 * @since 1.0.0
 */

namespace Elementor;

class Highlt_Hero_Slider_Item_Widget extends Widget_Base
{

    /**
     * Get widget name.
     *
     * Retrieve Elementor widget name.
     *
     * @return string Widget name.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_name()
    {
        return 'highlt-hero-single-item-widget';
    }

    /**
     * Get widget title.
     *
     * Retrieve Elementor widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_title()
    {
        return esc_html__('Hero Slider', 'highlt-core');
    }

    public function get_keywords()
    {
        return ['highlt Hero Slider', 'slider'];
    }

    /**
     * Get widget icon.
     *
     * Retrieve Elementor widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_icon()
    {
        return 'eicon-image';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the Elementor widget belongs to.
     *
     * @return array Widget categories.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_categories()
    {
        return ['highlt_widgets'];
    }

    /**
     * Register Elementor widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls()
    {


        $this->start_controls_section(
            'settings_section',
            [
                'label' => esc_html__('General Settings', 'highlt-core'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();
        $repeater->add_control(
            'background_image',
            [
                'label' => esc_html__('Image', 'highlt-core'),
                'type' => Controls_Manager::MEDIA,
                'description' => esc_html__('Upload image for slider', 'highlt-core'),
            ]
        );

        $repeater->add_control(
            'enable_video',
            [
                'label' => esc_html__('Enable Video', 'highlt-core'),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__('Toggle to add video instead of image', 'highlt-core'),
            ]
        );

        $repeater->add_control(
            'video',
            [
                'label' => esc_html__('Video', 'highlt-core'),
                'type' => Controls_Manager::MEDIA,
                'media_type' => ['video'],
                'description' => esc_html__('Upload video file from media library', 'highlt-core'),
                'condition' => [
                    'enable_video' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'video_thumbnail',
            [
                'label' => esc_html__('Video Thumbnail', 'highlt-core'),
                'type' => Controls_Manager::MEDIA,
                'description' => esc_html__('Thumbnail image for video', 'highlt-core'),
                'condition' => [
                    'enable_video' => 'yes',
                ],
            ]
        );  

        $this->add_control('hero_slider_items', [
            'label' => esc_html__('Hero Slider Item', 'highlt-core'),
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),

        ]);
        $this->end_controls_section();



        $this->start_controls_section(
            'slider_settings_section',
            [
                'label' => esc_html__('Slider Settings', 'highlt-core'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'items',
            [
                'label' => esc_html__('slidesToShow', 'highlt-core'),
                'type' => Controls_Manager::NUMBER,
                'description' => esc_html__('you can set how many item show in slider', 'highlt-core'),
                'default' => '3',
            ]
        );
        
        $this->add_control(
            'loop',
            [
                'label' => esc_html__('Loop', 'highlt-core'),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__('you can set yes/no to enable/disable', 'highlt-core'),
            ]
        );
        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'highlt-core'),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__('you can set yes/no to enable/disable', 'highlt-core'),
            ]
        );
       
        $this->add_control(
            'speed',
            [
                'label' => esc_html__('Speed', 'highlt-core'),
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

        // Slider Container Styles
        $this->start_controls_section(
            'slider_container_style',
            [
                'label' => esc_html__('Slider Area', 'highlt-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'slider_height',
            [
                'label' => esc_html__('Height', 'highlt-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1200,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'default' => [
                    'unit' => 'vh',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .hero-slider' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'slider_margin',
            [
                'label' => esc_html__('Margin', 'highlt-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .hero-slider-area' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'slider_padding',
            [
                'label' => esc_html__('Padding', 'highlt-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .hero-slider' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'slider_border_radius',
            [
                'label' => esc_html__('Border Radius', 'highlt-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .hero-slider' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Slide Item Styles
        $this->start_controls_section(
            'slide_item_style',
            [
                'label' => esc_html__('Slide Item', 'highlt-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'slide_image_width',
            [
                'label' => esc_html__('Image Width', 'highlt-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-slide img' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .swiper-slide video' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'slide_image_height',
            [
                'label' => esc_html__('Image Height', 'highlt-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ],
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-slide img' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .swiper-slide video' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'slide_image_object_fit',
            [
                'label' => esc_html__('Object Fit', 'highlt-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'cover' => esc_html__('Cover', 'highlt-core'),
                    'contain' => esc_html__('Contain', 'highlt-core'),
                    'fill' => esc_html__('Fill', 'highlt-core'),
                    'scale-down' => esc_html__('Scale Down', 'highlt-core'),
                ],
                'default' => 'cover',
                'selectors' => [
                    '{{WRAPPER}} .swiper-slide img' => 'object-fit: {{VALUE}};',
                    '{{WRAPPER}} .swiper-slide video' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'slide_padding',
            [
                'label' => esc_html__('Padding', 'highlt-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .swiper-slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Thumbnail Container Styles
        $this->start_controls_section(
            'thumbnail_container_style',
            [
                'label' => esc_html__('Thumbnail Container', 'highlt-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'thumb_alignment',
            [
                'label' => esc_html__('Alignment', 'highlt-core'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'highlt-core'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'highlt-core'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'highlt-core'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .hero-slider-thumb .swiper-wrapper' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'thumb_gap',
            [
                'label' => esc_html__('Gap Between Thumbnails', 'highlt-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .hero-slider-thumb .swiper-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'thumb_wrapper_margin',
            [
                'label' => esc_html__('Margin', 'highlt-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .hero-slider-thumb-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'thumb_wrapper_padding',
            [
                'label' => esc_html__('Padding', 'highlt-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .hero-slider-thumb-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Thumbnail Item Styles
        $this->start_controls_section(
            'thumbnail_item_style',
            [
                'label' => esc_html__('Thumbnail Item', 'highlt-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'thumb_width',
            [
                'label' => esc_html__('Width', 'highlt-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 300,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 120,
                ],
                'selectors' => [
                    '{{WRAPPER}} .hero-slider-thumb .swiper-slide' => 'width: {{SIZE}}{{UNIT}} !important; min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'thumb_height',
            [
                'label' => esc_html__('Height', 'highlt-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 300,
                    ]
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 120,
                ],
                'selectors' => [
                    '{{WRAPPER}} .hero-slider-thumb .swiper-slide' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Active Thumbnail Styles
        $this->start_controls_section(
            'active_thumbnail_style',
            [
                'label' => esc_html__('Active Thumbnail', 'highlt-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'active_thumb_border_color',
            [
                'label' => esc_html__('Border Color', 'highlt-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#000',
                'selectors' => [
                    '{{WRAPPER}} .hero-slider-btn-wrap span' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Video Controls Styles
        $this->start_controls_section(
            'video_controls_style',
            [
                'label' => esc_html__('Video Controls', 'highlt-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'video_control_color',
            [
                'label' => esc_html__('Control Color', 'highlt-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} video' => 'filter: hue-rotate(0deg) saturate(1);',
                ],
            ]
        );

        $this->add_control(
            'video_control_bg',
            [
                'label' => esc_html__('Control Background', 'highlt-core'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0, 0, 0, 0.7)',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render Elementor widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $all_hero_slider_items = $settings['hero_slider_items'];
        $rand_numb = rand(333, 999999999);
        //slider settings

        $slider_settings = [
            "loop" => esc_attr($settings['loop']),
            "items" => esc_attr($settings['items'] ?? 1),
            "autoplay" => esc_attr($settings['autoplay']),
            "speed" => esc_attr($settings['speed']['size'] ?? 500),
           

        ]
?>
        <div class="hero-slider-area">
            <div class="swiper hero-slider" data-settings='<?php echo json_encode($slider_settings); ?>'>
                <div class="swiper-wrapper">
                    <?php foreach ($all_hero_slider_items as $item): ?>
                        <div class="swiper-slide">
                            <?php if ($item['enable_video'] === 'yes' && !empty($item['video']['url'])): ?>
                                <video width="100%" height="100%" controls>
                                    <source src="<?php echo esc_url($item['video']['url']); ?>" type="video/mp4">
                                </video>
                            <?php elseif (!empty($item['background_image']['url'])): ?>
                                <img src="<?php echo $item['background_image']['url'] ?>" class="hero-slider-img" />
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="hero-slider-thumb-wrapper">
                <div class="swiper hero-slider-thumb">
                    <div class="swiper-wrapper">
                        <?php foreach ($all_hero_slider_items as $item): ?>
                            <div class="swiper-slide">
                                <?php if ($item['enable_video'] === 'yes' && !empty($item['video']['url']) && !empty($item['video_thumbnail']['url'])): ?>
                                    <img src="<?php echo $item['video_thumbnail']['url']; ?>" alt="">
                                <?php elseif (!empty($item['background_image']['url'])): ?>
                                    <img src="<?php echo $item['background_image']['url']; ?>" alt="">
                                <?php endif; ?>
                                <div class="hero-slider-btn-wrap">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
<?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type(new Highlt_Hero_Slider_Item_Widget());
