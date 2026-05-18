<?php

/**
 * Portfolio Tab Widget — AJAX handler
 * @package Highlt
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Highlt_Portfolio_Tab_Ajax')) {

    class Highlt_Portfolio_Tab_Ajax
    {
        const ACTION = 'highlt_portfolio_tab';
        const NONCE  = 'highlt_core_nonce';

        private static $instance;

        public function __construct()
        {
            add_action('wp_ajax_' . self::ACTION,        array($this, 'handle'));
            add_action('wp_ajax_nopriv_' . self::ACTION, array($this, 'handle'));
        }

        public static function getInstance()
        {
            if (null === self::$instance) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function handle()
        {
            check_ajax_referer(self::NONCE, 'nonce');

            $tab = isset($_POST['tab']) ? sanitize_key($_POST['tab']) : '';
            if (!in_array($tab, array('image', 'video'), true)) {
                wp_send_json_error(array('message' => __('Invalid tab.', 'highlt-core')), 400);
            }

            $category       = isset($_POST['category']) ? absint($_POST['category']) : 0;
            $posts_per_page = isset($_POST['posts_per_page']) ? (int) $_POST['posts_per_page'] : -1;

            $orderby_in = isset($_POST['orderby']) ? sanitize_key($_POST['orderby']) : 'date';
            $orderby    = in_array($orderby_in, array('date', 'title', 'menu_order', 'rand'), true) ? $orderby_in : 'date';

            $order = (isset($_POST['order']) && strtoupper($_POST['order']) === 'ASC') ? 'ASC' : 'DESC';

            $query_args = array(
                'post_type'      => 'portfolio',
                'post_status'    => 'publish',
                'posts_per_page' => $posts_per_page,
                'orderby'        => $orderby,
                'order'          => $order,
                'no_found_rows'  => true,
            );

            if ($category > 0) {
                $query_args['tax_query'] = array(
                    array(
                        'taxonomy' => 'portfolio_cat',
                        'field'    => 'term_id',
                        'terms'    => $category,
                    ),
                );
            }

            $query = new WP_Query($query_args);

            // Bucket posts by category for the requested tab.
            // Structure: [ term_id => [ 'term' => WP_Term, 'items' => [...] ] ]
            $buckets = array();

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $post_id = get_the_ID();
                    $meta    = get_post_meta($post_id, 'highlt_portfolio_options', true);
                    $meta    = is_array($meta) ? $meta : array();

                    if ($tab === 'image') {
                        if (!self::meta_flag_is_on($meta, 'option_image', 'image')) continue;
                        if (!has_post_thumbnail($post_id)) continue;
                        $payload = array('id' => $post_id);
                    } else {
                        if (!self::meta_flag_is_on($meta, 'option_video', 'video')) continue;
                        $url   = !empty($meta['portfolio_video_url'])   ? trim($meta['portfolio_video_url'])   : '';
                        if ($url === '') continue;
                        $title = !empty($meta['portfolio_video_title']) ? trim($meta['portfolio_video_title']) : '';
                        $payload = array('id' => $post_id, 'url' => $url, 'title' => $title);
                    }

                    $terms = get_the_terms($post_id, 'portfolio_cat');
                    if (empty($terms) || is_wp_error($terms)) continue;

                    foreach ($terms as $term) {
                        if ($category > 0 && (int) $term->term_id !== $category) continue;

                        if (!isset($buckets[$term->term_id])) {
                            $buckets[$term->term_id] = array('term' => $term, 'items' => array());
                        }
                        $buckets[$term->term_id]['items'][] = $payload;
                    }
                }
                wp_reset_postdata();
            }

            $html = $this->render_buckets($tab, $buckets);

            wp_send_json_success(array(
                'html'  => $html,
                'count' => array_sum(array_map(function ($b) {
                    return count($b['items']);
                }, $buckets)),
            ));
        }

        private function render_buckets($tab, $buckets)
        {
            if (empty($buckets)) {
                return '<p class="portfolio-empty">' . esc_html__('No portfolio items found.', 'highlt-core') . '</p>';
            }

            ob_start();
            foreach ($buckets as $bucket) :
                $term = $bucket['term'];
                ?>
                <div class="tab-single-section" data-category="<?php echo esc_attr($term->term_id); ?>">
                    <h2 class="section-title highlt-fade-animation"><?php echo esc_html($term->name); ?></h2>
                    <?php if ($tab === 'image') : ?>
                        <div class="portfolio-image-item-wrap highlt-gallery-fade">
                            <?php foreach ($bucket['items'] as $item) : ?>
                                <div class="portfolio-item">
                                    <div>
                                        <?php echo get_the_post_thumbnail($item['id'], 'large', array('alt' => esc_attr(get_the_title($item['id'])))); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <div class="portfolio-video-item-wrap">
                            <?php foreach ($bucket['items'] as $item) : ?>
                                <div class="portfolio-item">
                                    <?php if (self::is_youtube_url($item['url'])) : ?>
                                        <iframe
                                            src="<?php echo esc_url(self::get_youtube_embed_url($item['url'])); ?>"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen
                                            loading="lazy"
                                        ></iframe>
                                    <?php else : ?>
                                        <video controls muted playsinline preload="metadata">
                                            <source src="<?php echo esc_url($item['url']); ?>" type="<?php echo esc_attr(self::guess_video_mime($item['url'])); ?>">
                                            <?php esc_html_e('Your browser does not support the video tag.', 'highlt-core'); ?>
                                        </video>
                                    <?php endif; ?>
                                    <?php if (!empty($item['title'])) : ?>
                                        <h3 class="portfolio-video-title"><?php echo esc_html($item['title']); ?></h3>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach;
            return ob_get_clean();
        }

        private static function meta_flag_is_on($meta, $field_id, $option_key)
        {
            if (empty($meta[$field_id])) {
                return false;
            }
            return in_array($option_key, (array) $meta[$field_id], true);
        }

        private static function is_youtube_url($url) {
            return (bool) preg_match('#(?:youtube\.com/(?:watch\?(?:.*&)?v=|embed/)|youtu\.be/)([A-Za-z0-9_-]{11})#', $url);
        }

        private static function get_youtube_embed_url($url) {
            if (preg_match('#(?:youtube\.com/(?:watch\?(?:.*&)?v=|embed/)|youtu\.be/)([A-Za-z0-9_-]{11})#', $url, $m)) {
                return 'https://www.youtube.com/embed/' . $m[1];
            }
            return '';
        }

        private static function guess_video_mime($url)
        {
            $path = parse_url($url, PHP_URL_PATH);
            $ext  = strtolower(pathinfo($path ? $path : '', PATHINFO_EXTENSION));
            $map  = array(
                'mp4'  => 'video/mp4',
                'm4v'  => 'video/mp4',
                'webm' => 'video/webm',
                'ogv'  => 'video/ogg',
                'mov'  => 'video/quicktime',
            );
            return isset($map[$ext]) ? $map[$ext] : 'video/mp4';
        }
    }

    Highlt_Portfolio_Tab_Ajax::getInstance();
}
