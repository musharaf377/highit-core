<?php

/**
 * Elementor Widget
 * @package Highlt
 * @since 1.0.0
 */

namespace Elementor;

class Highlt_Portfolio_Tab_Widget extends Widget_Base
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
        return 'highlt-portfolio-tab-widget';
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
        return esc_html__('Portfolio Tab', 'highlt-core');
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
        return 'eicon-slider-album';
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
    }

    /**
     * Render Elementor widget output on the frontend.
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

?>
        <div class="portfolio-tab-area">
            <div class="section-header">
                <!-- Main Tabs -->
                <nav class="tabs-nav">
                    <button class="tab-btn active" data-target="images-tab">Images</button>
                    <button class="tab-btn" data-target="videos-tab">Videos</button>
                </nav>
            </div>

            <!-- Content Area -->
            <div class="content-area">

                <!-- IMAGES SECTION (Default Active) -->
                <div id="images-tab" class="tab-content active">

                    <!-- Music Item -->
                    <div class="tab-single-section">
                        <h2 class="section-title">Music</h2>
                        <div class="portfolio-image-item-wrap">
                            <div class="portfolio-item">
                                <img src="https://picsum.photos/seed/music1/600/450" alt="Music Stage">
                            </div>
                            <div class="portfolio-item">
                                <img src="https://picsum.photos/seed/music1/600/450" alt="Music Stage">
                            </div>
                            <div class="portfolio-item">
                                <img src="https://picsum.photos/seed/music1/600/450" alt="Music Stage">
                            </div>
                            <div class="portfolio-item">
                                <img src="https://picsum.photos/seed/music1/600/450" alt="Music Stage">
                            </div>
                            <div class="portfolio-item">
                                <img src="https://picsum.photos/seed/music1/600/450" alt="Music Stage">
                            </div>
                            <div class="portfolio-item">
                                <img src="https://picsum.photos/seed/music1/600/450" alt="Music Stage">
                            </div>
                        </div>
                        <div class="portfolio-video-item-wrap">
                            <div class="portfolio-item">
                                <video>
                                    <source src="https://assets.musemind.agency/xeno/Composition%207.webm" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                            <div class="portfolio-item">
                                <video>
                                    <source src="https://assets.musemind.agency/xeno/Composition%207.webm" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                            <div class="portfolio-item">
                                <video>
                                    <source src="https://assets.musemind.agency/xeno/Composition%207.webm" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                            <div class="portfolio-item">
                                <video>
                                    <source src="https://assets.musemind.agency/xeno/Composition%207.webm" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type(new Highlt_Portfolio_Tab_Widget());
