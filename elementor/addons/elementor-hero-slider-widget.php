<?php

/**
 * Elementor Widget
 * @package Highit
 * @since 1.0.0
 */

namespace Elementor;

class Highit_Hero_Slider_Item_Widget extends Widget_Base
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
        return 'highit-hero-single-item-widget';
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
        return esc_html__('Hero Slider', 'highit-core');
    }

    public function get_keywords()
    {
        return ['highit Hero Slider', 'slider'];
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
        return ['highit_widgets'];
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
                'label' => esc_html__('General Settings', 'highit-core'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();
        $repeater->add_control(
            'background_image',
            [
                'label' => esc_html__('Background Image', 'highit-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $repeater->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'highit-core'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__('What We Do', 'highit-core'),
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'highit-core'),
                'type' => Controls_Manager::TEXTAREA,
                'description' => esc_html__('enter  description.', 'highit-core'),
                'default' => esc_html__('Top Packages', 'highit-core'),
            ]
        );
        $repeater->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'highit-core'),
                'type' => Controls_Manager::TEXTAREA,
                'description' => esc_html__('enter  button text.', 'highit-core'),
                'default' => esc_html__('Get Started', 'highit-core'),
            ]
        );

        $repeater->add_control(
            'button_url',
            [
                'label' => esc_html__('Button URL', 'highit-core'),
                'type' => Controls_Manager::TEXTAREA,
                'description' => esc_html__('enter  button url.', 'highit-core'),
                'default' => esc_html__('#', 'highit-core'),
            ]
        );  

        $this->add_control('hero_slider_items', [
            'label' => esc_html__('Hero Slider Item', 'highit-core'),
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),

        ]);
        $this->end_controls_section();



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
                'label' => esc_html__('slidesToShow', 'highit-core'),
                'type' => Controls_Manager::NUMBER,
                'description' => esc_html__('you can set how many item show in slider', 'highit-core'),
                'default' => '3',
            ]
        );
        
        $this->add_control(
            'loop',
            [
                'label' => esc_html__('Loop', 'highit-core'),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__('you can set yes/no to enable/disable', 'highit-core'),
            ]
        );
        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'highit-core'),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__('you can set yes/no to enable/disable', 'highit-core'),
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
                        <div class="swiper-slide" style="background-image:url(<?php echo $item['background_image']['url'] ?>)">
                            <div class="hero-overlay"></div>
                            <div class="container">
                                <div class="hero-slider-content">
                                    <div class="slider-left-content">
                                        <p class="hero-slide-description"><?php echo $item['description'] ?></p>
                                        <h2 class="hero-slide-title"><?php echo $item['title'] ?></h2>
                                        <a href="<?php echo $item['button_url'] ?>" class="primary-btn"><?php echo $item['button_text'] ?> <?php echo highit_get_svg_icon('right_arrow') ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="hero-slider-thumb-wrapper">
                <div class="swiper hero-slider-thumb">
                    <div class="swiper-wrapper">
                        <?php foreach ($all_hero_slider_items as $item): ?>
                            <div class="swiper-slide">
                                <img src="<?php echo $item['background_image']['url']; ?>" alt="">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                                        
            </div>
        </div>



<?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type(new Highit_Hero_Slider_Item_Widget());
