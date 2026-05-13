<?php

/**
 * Elementor Widget
 * @package Appside
 * @since 1.0.0
 */

namespace Elementor;

class Highlt_Accordion_One extends Widget_Base
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
        return 'highlt-accordion-one-widget';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the widget keywords.
     *
     * @since 1.0.10
     * @access public
     *
     * @return array Widget keywords.
     */

    public function get_keywords()
    {
        return ['ir-tech', 'highlt', 'accordion'];
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
        return esc_html__('Accordion 01', 'highlt-core');
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
        return 'eicon-editor-list-ul';
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
    protected function _register_controls()
    {

        $this->start_controls_section(
            'settings_section',
            [
                'label' => esc_html__('General Settings', 'highlt-core'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new Repeater();

        $repeater->add_control('title', [
            'label'       => esc_html__('Title', 'highlt-core'),
            'type'        => Controls_Manager::TEXT,
            'description' => esc_html__('Enter title', 'highlt-core')
        ]);
        $repeater->add_control('description', [
            'label'       => esc_html__('Description', 'highlt-core'),
            'type'        => Controls_Manager::TEXTAREA,
            'description' => esc_html__('Enter description', 'highlt-core')
        ]);

        $this->add_control('accordion_items', [
            'label'       => esc_html__('Accordion Item', 'highlt-core'),
            'type'        => Controls_Manager::REPEATER,
            'default'     => [
                [
                    'title'        => esc_html__('How can I get started with Highlt Advisors? How do I know if I qualify for your services?', 'highlt-core'),
                    'description' => esc_html__("All investment decisions at Highlt Advisors are made in-house. As an independent investment advisor, we have the flexibility to select the opportunities from the broader investment universe across public equities, private shares, real estate, and mutual funds. Our investment philosophy emphasizes ethical investing, and that our clients' investments align with their values. We carefully screen for and seek to avoid industries such as alcohol, gambling, pornography, tobacco, and war-making.", 'highlt-core'),
                ]
            ],
            'fields'      => $repeater->get_controls()
        ]);
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
        $accordion_items = $settings['accordion_items'];
        $random_number = mt_rand(999, 999999);
?>
        <div class="accordion-wrapper">
            <div id="accordion-<?php echo esc_attr($random_number); ?>">
                <?php
                $a = 0;
                foreach ($accordion_items as $item):
                    $collapse_class = (0 == $a) ? '' : 'collapsed';
                    $show_class = (0 == $a) ? 'show' : '';
                    $aria_expanded = (0 == $a) ? 'true' : 'false';
                    $a++;
                    $random__item_number = mt_rand(999, 999999);
                ?>
                    <div class="card">
                        <div class="card-header" id="headingOne_<?php echo esc_attr($random__item_number); ?>">
                            <h5 class="mb-0">
                                <a class="<?php echo esc_attr($collapse_class); ?>" data-bs-toggle="collapse" role="button" data-bs-target="#collapseOne_<?php echo esc_attr($random__item_number); ?>" aria-expanded="<?php echo esc_attr($aria_expanded); ?>" aria-controls="collapseOne_<?php echo esc_attr($random__item_number); ?>">
                                    <?php echo esc_html($item['title']); ?>
                                    <span class="faq-arrow-wrap"></span>
                                </a>
                            </h5>
                        </div>
                        <div id="collapseOne_<?php echo esc_attr($random__item_number); ?>" class="collapse <?php echo esc_attr($show_class); ?>" data-bs-parent="#accordion-<?php echo esc_attr($random_number); ?>">
                            <div class="card-body">
                                <?php echo esc_html($item['description']); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
<?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type(new Highlt_Accordion_One());
