<?php

/**
 * Elementor Highit Button Widget
 * @package Highit
 * @since 1.0.0
 */

namespace Elementor;

class Highit_Button_Widget extends Widget_Base
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
        return 'highit-button-widget';
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
        return esc_html__('Highit Button', 'highit-core');
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
        return 'eicon-button';
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
            'content_section',
            [
                'label' => esc_html__('Highit Button Content', 'highit-core'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'highit-core'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Click Here', 'highit-core'),
                'placeholder' => esc_html__('Enter button text', 'highit-core'),
            ]
        );

        $this->add_control(
            'button_link',
            [
                'label' => esc_html__('Button Link', 'highit-core'),
                'type' => Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'highit-core'),
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'show_external' => true,
            ]
        );

        $this->add_control(
            'show_icon',
            [
                'label' => esc_html__('Show Icon', 'highit-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'highit-core'),
                'label_off' => esc_html__('No', 'highit-core'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'button_icon',
            [
                'label' => esc_html__('Button Icon', 'highit-core'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-arrow-right',
                    'library' => 'solid',
                ],
                'condition' => [
                    'show_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'icon_position',
            [
                'label' => esc_html__('Icon Position', 'highit-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'left' => esc_html__('Before Text', 'highit-core'),
                    'right' => esc_html__('After Text', 'highit-core'),
                ],
                'condition' => [
                    'show_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'icon_spacing',
            [
                'label' => esc_html__('Icon Spacing', 'highit-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 8,
                ],
                'selectors' => [
                    '{{WRAPPER}} .primary-btn .icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .primary-btn .icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                  ],
                'condition' => [
                    'show_icon' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_align',
            [
                'label' => esc_html__('Alignment', 'highit-core'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'highit-core'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'highit-core'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'highit-core'),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__('Justified', 'highit-core'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => 'left',
                'prefix_class' => 'primary-btn-align-',
                'selectors' => [
                    '{{WRAPPER}} .primary-btn-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Highit Button Style', 'highit-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs(
            'button_style_tabs'
        );

        // Normal Tab
        $this->start_controls_tab(
            'button_normal_tab',
            [
                'label' => esc_html__('Normal', 'highit-core'),
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => esc_html__('Typography', 'highit-core'),
                'selector' => '{{WRAPPER}} .primary-btn',
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__('Text Color', 'highit-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .primary-btn' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .primary-btn svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .primary-btn svg path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .primary-btn svg rect' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .primary-btn svg circle' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .primary-btn svg polygon' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_icon_color',
            [
                'label' => esc_html__('Icon Color', 'highit-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .primary-btn i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .primary-btn svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .primary-btn svg path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .primary-btn svg rect' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .primary-btn svg circle' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .primary-btn svg polygon' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'show_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'button_svg_stroke_color',
            [
                'label' => esc_html__('SVG Stroke Color', 'highit-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .primary-btn svg' => 'stroke: {{VALUE}};',
                    '{{WRAPPER}} .primary-btn svg path' => 'stroke: {{VALUE}};',
                    '{{WRAPPER}} .primary-btn svg rect' => 'stroke: {{VALUE}};',
                    '{{WRAPPER}} .primary-btn svg circle' => 'stroke: {{VALUE}};',
                    '{{WRAPPER}} .primary-btn svg polygon' => 'stroke: {{VALUE}};',
                ],
                'condition' => [
                    'show_icon' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'button_background',
                'label' => esc_html__('Background', 'highit-core'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .primary-btn',
                'exclude' => ['image'],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'label' => esc_html__('Border', 'highit-core'),
                'selector' => '{{WRAPPER}} .primary-btn',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'highit-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .primary-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'highit-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .primary-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_width',
            [
                'label' => esc_html__('Width', 'highit-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .primary-btn' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_height',
            [
                'label' => esc_html__('Height', 'highit-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 20,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .primary-btn' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'highit-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em'],
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0.1,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 16,
                ],
                'selectors' => [
                    '{{WRAPPER}} .primary-btn i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .primary-btn svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_icon' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'label' => esc_html__('Box Shadow', 'highit-core'),
                'selector' => '{{WRAPPER}} .primary-btn',
            ]
        );

        $this->end_controls_tab();

        // Hover Tab
        $this->start_controls_tab(
            'button_hover_tab',
            [
                'label' => esc_html__('Hover', 'highit-core'),
            ]
        );

        $this->add_control(
            'button_hover_text_color',
            [
                'label' => esc_html__('Text Color', 'highit-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .primary-btn:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_icon_color',
            [
                'label' => esc_html__('Icon Color', 'highit-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .primary-btn:hover i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .primary-btn:hover svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .primary-btn:hover svg path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .primary-btn:hover svg rect' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .primary-btn:hover svg circle' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .primary-btn:hover svg polygon' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'show_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'button_hover_svg_stroke_color',
            [
                'label' => esc_html__('SVG Stroke Color', 'highit-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .primary-btn:hover svg' => 'stroke: {{VALUE}};',
                    '{{WRAPPER}} .primary-btn:hover svg path' => 'stroke: {{VALUE}};',
                    '{{WRAPPER}} .primary-btn:hover svg rect' => 'stroke: {{VALUE}};',
                    '{{WRAPPER}} .primary-btn:hover svg circle' => 'stroke: {{VALUE}};',
                    '{{WRAPPER}} .primary-btn:hover svg polygon' => 'stroke: {{VALUE}};',
                ],
                'condition' => [
                    'show_icon' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'button_hover_background',
                'label' => esc_html__('Background', 'highit-core'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .primary-btn:hover',
                'exclude' => ['image'],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'highit-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .primary-btn:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_hover_box_shadow',
                'label' => esc_html__('Box Shadow', 'highit-core'),
                'selector' => '{{WRAPPER}} .primary-btn:hover',
            ]
        );

        $this->add_control(
            'button_hover_transition',
            [
                'label' => esc_html__('Transition Duration', 'highit-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['ms', 's'],
                'range' => [
                    'ms' => [
                        'min' => 0,
                        'max' => 2000,
                        'step' => 50,
                    ],
                    's' => [
                        'min' => 0,
                        'max' => 2,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'ms',
                    'size' => 300,
                ],
                'selectors' => [
                    '{{WRAPPER}} .primary-btn' => 'transition: all {{SIZE}}{{UNIT}} ease;',
                    '{{WRAPPER}} .primary-btn svg' => 'transition: all {{SIZE}}{{UNIT}} ease;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

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
        
        $this->add_render_attribute('button_wrapper', 'class', 'primary-btn-wrapper');
        $this->add_render_attribute('button', 'class', 'primary-btn');
        
        if (!empty($settings['button_link']['url'])) {
            $this->add_link_attributes('button', $settings['button_link']);
        }

        $tag = !empty($settings['button_link']['url']) ? 'a' : 'button';
        
        ?>
        <div <?php echo $this->get_render_attribute_string('button_wrapper'); ?>>
            <<?php echo $tag; ?> <?php echo $this->get_render_attribute_string('button'); ?>>
                <?php if ($settings['show_icon'] === 'yes' && $settings['icon_position'] === 'left') : ?>
                    <span class="icon-left">
                        <?php Icons_Manager::render_icon($settings['button_icon'], ['aria-hidden' => 'true']); ?>
                    </span>
                <?php endif; ?>
                
                <?php if (!empty($settings['button_text'])) : ?>
                    <span class="button-text"><?php echo esc_html($settings['button_text']); ?></span>
                <?php endif; ?>
                
                <?php if ($settings['show_icon'] === 'yes' && $settings['icon_position'] === 'right') : ?>
                    <span class="icon-right">
                        <?php Icons_Manager::render_icon($settings['button_icon'], ['aria-hidden' => 'true']); ?>
                    </span>
                <?php endif; ?>
            </<?php echo $tag; ?>>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type(new Highit_Button_Widget());