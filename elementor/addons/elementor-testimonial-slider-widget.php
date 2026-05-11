<?php

/**
 * Elementor Widget
 * @package Highit
 * @since 1.0.0
 */

namespace Elementor;

class Highit_Testimonial_Slider_Item_Widget extends Widget_Base
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
        return 'highit-testimonial-single-item-widget';
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
        return esc_html__('Testimonial Slider', 'highit-core');
    }

    public function get_keywords()
    {
        return ['Testimonial Slider', 'slider'];
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
            'client_image',
            [
                'label' => esc_html__('Client Image', 'highit-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $repeater->add_control(
            'client_name',
            [
                'label' => esc_html__('Client Name', 'highit-core'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('What We Do', 'highit-core'),
            ]
        );

        $repeater->add_control(
            'client_designation',
            [
                'label' => esc_html__('Client Designation', 'highit-core'),
                'type' => Controls_Manager::TEXT,
                'description' => esc_html__('enter client designation.', 'highit-core'),
                'default' => esc_html__('Top Packages', 'highit-core'),
            ]
        );

        $this->add_control('hero_slider_items', [
            'label' => esc_html__('Testimonial Slider Item', 'highit-core'),
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
            "speed" => esc_attr($settings['speed']['size'] ?? 500)


        ]
?>
        <div class="testimonial-slider-area">
            <div class="swiper testimonial-slider" data-settings='<?php echo json_encode($slider_settings); ?>'>
                <div class="swiper-wrapper">
                    <?php foreach ($all_hero_slider_items as $item): ?>
                        <div class="swiper-slide">
                            <div class="testimonial-slider-content">
                                <img src="<?php echo $item['client_image']['url']; ?>" alt="">
                                <h3><?php echo $item['client_name'] ?></h3>
                                <p><?php echo $item['client_designation'] ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="slider-nav-wrapper">
                    <div class="swiper-button-prev slider-nav-arrow nav-prev">
                        <?php echo highit_get_svg_icon('left_arrow'); ?>
                    </div>
                    <div class="swiper-button-next slider-nav-arrow nav-next">
                        <?php echo highit_get_svg_icon('right_arrow'); ?>
                    </div>
                </div>
            </div>
        </div>



<?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type(new Highit_Testimonial_Slider_Item_Widget());
