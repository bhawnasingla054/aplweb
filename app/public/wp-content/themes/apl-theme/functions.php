<?php
/**
 * Theme setup and assets.
 *
 * @package APL_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Sets up theme defaults and registers support for WordPress features.
 */
function apl_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support(
        'html5',
        array(
            'script',
            'style',
            'search-form',
            'gallery',
            'caption',
        )
    );
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 80,
            'width'       => 80,
            'flex-height' => true,
            'flex-width'  => true,
        )
    );

    register_nav_menus(
        array(
            'primary' => __('Primary Menu', 'apl-theme'),
        )
    );
}
add_action('after_setup_theme', 'apl_theme_setup');

/**
 * Enqueue theme styles and scripts.
 */
function apl_theme_enqueue_assets() {
    $theme_version = wp_get_theme()->get('Version');

    wp_enqueue_style(
        'apl-reference-style',
        get_template_directory_uri() . '/assets/css/reference.css',
        array(),
        $theme_version
    );

    if (!is_front_page()) {
        wp_enqueue_style(
            'apl-blog-style',
            get_template_directory_uri() . '/assets/css/blog.css',
            array('apl-reference-style'),
            $theme_version
        );
    }

    wp_enqueue_script(
        'apl-reference-script',
        get_template_directory_uri() . '/assets/js/reference.js',
        array(),
        $theme_version,
        true
    );
}
add_action('wp_enqueue_scripts', 'apl_theme_enqueue_assets');

/**
 * Helper to fetch theme mods with a fallback value.
 *
 * @param string $key     Theme mod key.
 * @param mixed  $default Default value if theme mod isn't set.
 *
 * @return mixed
 */
function apl_get_theme_mod($key, $default = '') {
    $value = get_theme_mod($key, null);

    if (null === $value || '' === $value) {
        return $default;
    }

    return $value;
}

/**
 * Helper to fetch the URL of a media attachment stored in a theme mod.
 *
 * @param string $key Theme mod key storing an attachment ID.
 *
 * @return string
 */
function apl_get_media_url($key) {
    $attachment_id = absint(get_theme_mod($key));

    if (!$attachment_id) {
        return '';
    }

    $url = wp_get_attachment_image_url($attachment_id, 'full');

    return $url ? $url : '';
}

/**
 * Helper to decode stored JSON repeater lists.
 *
 * @param string $value JSON string from get_theme_mod.
 *
 * @return array
 */
function apl_decode_repeater_json($value) {
    if (empty($value)) {
        return array();
    }

    $decoded = json_decode($value, true);

    return is_array($decoded) ? $decoded : array();
}

/**
 * Fetch a decoded repeater list directly from a theme mod key.
 *
 * @param string $key Theme mod key.
 *
 * @return array
 */
function apl_get_repeater_items($key) {
    $raw = get_theme_mod($key, '');

    return apl_decode_repeater_json($raw);
}

/**
 * Sanitize sponsor JSON payloads from the Customizer.
 *
 * @param string $value Raw JSON string.
 *
 * @return string
 */
function apl_sanitize_sponsors_json($value) {
    if (empty($value)) {
        return '';
    }

    $items = apl_decode_repeater_json($value);

    if (empty($items)) {
        return '';
    }

    $sanitized = array();

    foreach ($items as $item) {
        if (!is_array($item)) {
            continue;
        }

        $clean = array();

        if (isset($item['id'])) {
            $clean_id = absint($item['id']);
            if ($clean_id) {
                $clean['id'] = $clean_id;
            }
        }

        if (!empty($item['src'])) {
            $clean_src = esc_url_raw($item['src']);
            if ($clean_src) {
                $clean['src'] = $clean_src;
            }
        }

        if (!empty($item['url'])) {
            $clean_url = esc_url_raw($item['url']);
            if ($clean_url) {
                $clean['url'] = $clean_url;
            }
        }

        if (!empty($clean)) {
            $sanitized[] = $clean;
        }
    }

    return !empty($sanitized) ? wp_json_encode($sanitized) : '';
}

/**
 * Sanitize recognition JSON payloads from the Customizer.
 *
 * @param string $value Raw JSON string.
 *
 * @return string
 */
function apl_sanitize_recognition_json($value) {
    if (empty($value)) {
        return '';
    }

    $items = apl_decode_repeater_json($value);

    if (empty($items)) {
        return '';
    }

    $sanitized = array();

    foreach ($items as $item) {
        if (!is_array($item)) {
            continue;
        }

        $clean = array();

        if (isset($item['id'])) {
            $clean_id = absint($item['id']);
            if ($clean_id) {
                $clean['id'] = $clean_id;
            }
        }

        if (!empty($item['src'])) {
            $clean_src = esc_url_raw($item['src']);
            if ($clean_src) {
                $clean['src'] = $clean_src;
            }
        }

        if (!empty($item['url'])) {
            $clean_url = esc_url_raw($item['url']);
            if ($clean_url) {
                $clean['url'] = $clean_url;
            }
        }

        if (!empty($item['caption'])) {
            $clean['caption'] = sanitize_text_field($item['caption']);
        }

        if (!empty($clean)) {
            $sanitized[] = $clean;
        }
    }

    return !empty($sanitized) ? wp_json_encode($sanitized) : '';
}

/**
 * Sanitize media type selection.
 *
 * @param string $value Raw selection.
 *
 * @return string
 */
function apl_sanitize_media_type($value) {
    $allowed = array('image', 'video');

    return in_array($value, $allowed, true) ? $value : 'image';
}

/**
 * Sanitize customer logos JSON payload.
 *
 * @param string $value Raw JSON string.
 *
 * @return string
 */
function apl_sanitize_customers_json($value) {
    if (empty($value)) {
        return '';
    }

    $items = apl_decode_repeater_json($value);

    if (empty($items)) {
        return '';
    }

    $sanitized = array();

    foreach ($items as $item) {
        if (!is_array($item)) {
            continue;
        }

        $clean = array();

        if (isset($item['id'])) {
            $clean_id = absint($item['id']);
            if ($clean_id) {
                $clean['id'] = $clean_id;
            }
        }

        if (!empty($item['src'])) {
            $clean_src = esc_url_raw($item['src']);
            if ($clean_src) {
                $clean['src'] = $clean_src;
            }
        }

        if (empty($clean['id']) && empty($clean['src'])) {
            continue;
        }

        if (!empty($item['href'])) {
            $clean_href = esc_url_raw($item['href']);
            if ($clean_href) {
                $clean['href'] = $clean_href;
            }
        }

        if (!empty($item['alt'])) {
            $clean['alt'] = sanitize_text_field($item['alt']);
        }

        $sanitized[] = $clean;
    }

    return !empty($sanitized) ? wp_json_encode($sanitized) : '';
}

if (!class_exists('APL_Primary_Nav_Walker')) {
    /**
     * Custom walker used to mirror the original Framer navigation markup.
     */
    class APL_Primary_Nav_Walker extends Walker_Nav_Menu {
        /**
         * Keeps track of the nav item index so we can apply the original container classes.
         *
         * @var int
         */
        protected $item_index = 0;

        /**
         * Predefined container classes pulled from the Framer export.
         *
         * @var array
         */
        protected $container_classes = array(
            'framer-s7qzv8-container',
            'framer-14zw5ms-container',
            'framer-1nhum70-container',
            'framer-1yq0euy-container',
            'framer-3cq2n5-container',
        );

        /**
         * We only need top-level items, so no submenu wrappers are rendered.
         */
        public function start_lvl(&$output, $depth = 0, $args = null) {}

        /**
         * We only need top-level items, so no submenu wrappers are rendered.
         */
        public function end_lvl(&$output, $depth = 0, $args = null) {}

        /**
         * Starts the output for a single nav menu item.
         */
        public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
            $container_class = $this->container_classes[$this->item_index] ?? $this->container_classes[0];
            $this->item_index++;

            $title = apply_filters('the_title', $item->title, $item->ID);
            $href  = !empty($item->url) ? $item->url : '#';

            $attributes  = '';
            $attributes .= !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
            $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';

            $rel = $item->xfn;
            if ('_blank' === $item->target && empty($rel)) {
                $rel = 'noopener';
            }
            $attributes .= !empty($rel) ? ' rel="' . esc_attr($rel) . '"' : '';

            $output .= '<div class="' . esc_attr($container_class) . '" style="opacity: 1;">';
            $output .= '<a class="framer-CUI1w framer-B5cGT framer-14ejuv9 framer-v-14ejuv9 framer-1bo981q" data-framer-name="Desktop" data-highlight="true" href="' . esc_url($href) . '"' . $attributes . ' tabindex="0" style="opacity: 1;">';
            $output .= '<div class="framer-1e5w6lt" data-framer-name="Container" style="background-color: rgba(0, 0, 0, 0); border-radius: 8px; opacity: 1;">';
            $output .= '<div class="framer-ufbnrn" data-framer-name="' . esc_attr($title) . '" data-framer-component-type="RichTextContainer" style="--extracted-r6o4lv: var(--token-0fb69f39-a3d4-4f91-b331-03e865b0d890, rgb(255, 255, 255)); --framer-paragraph-spacing: 0px; transform: none; opacity: 1;">';
            $output .= '<p class="framer-text framer-styles-preset-hgxetd" data-styles-preset="A6L_9fNs7" style="--framer-text-color: var(--extracted-r6o4lv, var(--token-0fb69f39-a3d4-4f91-b331-03e865b0d890, rgb(255, 255, 255)));">' . esc_html($title) . '</p>';
            $output .= '</div></div></a></div>';
        }

        /**
         * Closes the nav menu item output.
         */
        public function end_el(&$output, $item, $depth = 0, $args = null) {
            // All of the markup is closed in start_el.
        }
    }
}

/**
 * Helper that prints the Framer-styled primary menu via wp_nav_menu().
 */
function apl_theme_render_primary_menu() {
    if (!has_nav_menu('primary')) {
        return;
    }

    wp_nav_menu(
        array(
            'theme_location' => 'primary',
            'container'      => false,
            'fallback_cb'    => false,
            'menu_class'     => 'framer-a2v6y5',
            'items_wrap'     => '<div class="%2$s" data-framer-name="Navigation Links" style="opacity: 1;">%3$s</div>',
            'depth'          => 1,
            'walker'         => new APL_Primary_Nav_Walker(),
        )
    );
}

/**
 * Registers Customizer settings for the homepage hero.
 *
 * @param WP_Customize_Manager $wp_customize Customize object.
 */
function apl_customize_register($wp_customize) {
    $wp_customize->add_section(
        'apl_home_cms',
        array(
            'title'    => __('Home (CMS)', 'apl-theme'),
            'priority' => 30,
        )
    );

    $settings = array(
        'apl_home_hero_badge_label' => array(
            'label'             => __('Hero Badge Label', 'apl-theme'),
            'default'           => 'NEW',
            'sanitize_callback' => 'sanitize_text_field',
            'type'              => 'text',
        ),
        'apl_home_hero_badge_text' => array(
            'label'             => __('Hero Badge Text', 'apl-theme'),
            'default'           => 'Now with brand new AI integration',
            'sanitize_callback' => 'sanitize_text_field',
            'type'              => 'text',
        ),
        'apl_home_hero_heading' => array(
            'label'             => __('Hero Heading', 'apl-theme'),
            'default'           => 'All your work pulled into one powerful place',
            'sanitize_callback' => 'sanitize_text_field',
            'type'              => 'text',
        ),
        'apl_home_hero_subheading' => array(
            'label'             => __('Hero Subheading', 'apl-theme'),
            'default'           => 'Organize tasks and projects in one connected, accessible platform.',
            'sanitize_callback' => 'sanitize_textarea_field',
            'type'              => 'textarea',
        ),
        'apl_home_hero_cta_text' => array(
            'label'             => __('Hero CTA Text', 'apl-theme'),
            'default'           => 'Get started',
            'sanitize_callback' => 'sanitize_text_field',
            'type'              => 'text',
        ),
        'apl_home_hero_cta_url' => array(
            'label'             => __('Hero CTA URL', 'apl-theme'),
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
            'type'              => 'url',
        ),
        'apl_home_overview_title' => array(
            'label'             => __('Overview Title', 'apl-theme'),
            'default'           => 'A complete product overview',
            'sanitize_callback' => 'sanitize_text_field',
            'type'              => 'text',
        ),
        'apl_home_overview_body' => array(
            'label'             => __('Overview Body', 'apl-theme'),
            'default'           => 'Explore how every workflow, integration, and dashboard works together to support your team.',
            'sanitize_callback' => 'sanitize_textarea_field',
            'type'              => 'textarea',
        ),
        'apl_home_cap1_title' => array(
            'label'             => __('Capability 1 Title', 'apl-theme'),
            'default'           => 'Unified tasks',
            'sanitize_callback' => 'sanitize_text_field',
            'type'              => 'text',
        ),
        'apl_home_cap1_body' => array(
            'label'             => __('Capability 1 Body', 'apl-theme'),
            'default'           => 'Keep every deliverable organized, searchable, and up to date in one space.',
            'sanitize_callback' => 'sanitize_textarea_field',
            'type'              => 'textarea',
        ),
        'apl_home_cap2_title' => array(
            'label'             => __('Capability 2 Title', 'apl-theme'),
            'default'           => 'Automated reporting',
            'sanitize_callback' => 'sanitize_text_field',
            'type'              => 'text',
        ),
        'apl_home_cap2_body' => array(
            'label'             => __('Capability 2 Body', 'apl-theme'),
            'default'           => 'See progress at a glance with dashboards that refresh the moment work changes.',
            'sanitize_callback' => 'sanitize_textarea_field',
            'type'              => 'textarea',
        ),
        'apl_home_cap3_title' => array(
            'label'             => __('Capability 3 Title', 'apl-theme'),
            'default'           => 'Powerful collaboration',
            'sanitize_callback' => 'sanitize_text_field',
            'type'              => 'text',
        ),
        'apl_home_cap3_body' => array(
            'label'             => __('Capability 3 Body', 'apl-theme'),
            'default'           => 'Comment, assign, and approve without leaving the canvas or losing context.',
            'sanitize_callback' => 'sanitize_textarea_field',
            'type'              => 'textarea',
        ),
        'apl_home_cap4_title' => array(
            'label'             => __('Capability 4 Title', 'apl-theme'),
            'default'           => 'Enterprise-grade security',
            'sanitize_callback' => 'sanitize_text_field',
            'type'              => 'text',
        ),
        'apl_home_cap4_body' => array(
            'label'             => __('Capability 4 Body', 'apl-theme'),
            'default'           => 'Granular permissions and audit-ready logs keep sensitive work protected.',
            'sanitize_callback' => 'sanitize_textarea_field',
            'type'              => 'textarea',
        ),
    );

    $settings['apl_home_cred_title'] = array(
        'label'             => __('Credibility: Title', 'apl-theme'),
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'type'              => 'text',
    );

    $settings['apl_home_cred_subtitle'] = array(
        'label'             => __('Credibility: Subtitle', 'apl-theme'),
        'default'           => '',
        'sanitize_callback' => 'sanitize_textarea_field',
        'type'              => 'textarea',
    );

    for ($i = 1; $i <= 4; $i++) {
        $settings["apl_home_sponsor{$i}_url"] = array(
            'label'             => sprintf(__('Sponsor %d: Link', 'apl-theme'), $i),
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'type'              => 'url',
        );
    }

    for ($i = 1; $i <= 3; $i++) {
        $settings["apl_home_rec{$i}_url"] = array(
            'label'             => sprintf(__('Recognition %d: Link', 'apl-theme'), $i),
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'type'              => 'url',
        );

        $settings["apl_home_rec{$i}_caption"] = array(
            'label'             => sprintf(__('Recognition %d: Caption', 'apl-theme'), $i),
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'type'              => 'text',
        );
    }

    for ($i = 1; $i <= 4; $i++) {
        $settings["apl_home_opt{$i}_title"] = array(
            'label'             => sprintf(__('Optional Card %d: Title', 'apl-theme'), $i),
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
            'type'              => 'text',
        );

        $settings["apl_home_opt{$i}_body"] = array(
            'label'             => sprintf(__('Optional Card %d: Body', 'apl-theme'), $i),
            'default'           => '',
            'sanitize_callback' => 'sanitize_textarea_field',
            'type'              => 'textarea',
        );
    }

    $settings['apl_home_sponsors_json'] = array(
        'label'             => __('Sponsors JSON (override)', 'apl-theme'),
        'default'           => '',
        'sanitize_callback' => 'apl_sanitize_sponsors_json',
        'type'              => 'textarea',
    );

    $settings['apl_home_recognition_json'] = array(
        'label'             => __('Recognition JSON (override)', 'apl-theme'),
        'default'           => '',
        'sanitize_callback' => 'apl_sanitize_recognition_json',
        'type'              => 'textarea',
    );

    $settings['apl_home_product_media_type'] = array(
        'label'             => __('Product Media Type', 'apl-theme'),
        'default'           => 'image',
        'sanitize_callback' => 'apl_sanitize_media_type',
        'type'              => 'select',
        'choices'           => array(
            'image' => __('Image', 'apl-theme'),
            'video' => __('Video', 'apl-theme'),
        ),
    );

    // Media Upload Controls (NEW)
    $settings['apl_home_product_image_id'] = array(
        'label'             => __('Product Image Upload', 'apl-theme'),
        'default'           => '',
        'sanitize_callback' => 'absint',
        'type'              => 'media',
        'mime_type'         => 'image',
    );

    $settings['apl_home_product_video_id'] = array(
        'label'             => __('Product Video Upload', 'apl-theme'),
        'default'           => '',
        'sanitize_callback' => 'absint',
        'type'              => 'media',
        'mime_type'         => 'video',
    );

    $settings['apl_home_product_media_url'] = array(
        'label'             => __('External Media URL (fallback)', 'apl-theme'),
        'description'       => __('Used only if no upload is selected above', 'apl-theme'),
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'type'              => 'url',
    );

    $settings['apl_home_product_media_alt'] = array(
        'label'             => __('Product Image Alt Text', 'apl-theme'),
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'type'              => 'text',
    );

    $settings['apl_home_product_poster_id'] = array(
        'label'             => __('Video Poster Image Upload', 'apl-theme'),
        'description'       => __('Thumbnail shown before video plays', 'apl-theme'),
        'default'           => '',
        'sanitize_callback' => 'absint',
        'type'              => 'media',
        'mime_type'         => 'image',
    );

    $settings['apl_home_trusted_title'] = array(
        'label'             => __('Trusted Block Title', 'apl-theme'),
        'default'           => 'Trusted by teams everywhere',
        'sanitize_callback' => 'sanitize_text_field',
        'type'              => 'text',
    );

    $settings['apl_home_trusted_subtitle'] = array(
        'label'             => __('Trusted Block Subtitle', 'apl-theme'),
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
        'type'              => 'text',
    );

    $settings['apl_home_customers_json'] = array(
        'label'             => __('Customer Logos JSON', 'apl-theme'),
        'default'           => '',
        'sanitize_callback' => 'apl_sanitize_customers_json',
        'type'              => 'textarea',
    );

    foreach ($settings as $setting_key => $args) {
        $wp_customize->add_setting(
            $setting_key,
            array(
                'default'           => $args['default'],
                'sanitize_callback' => $args['sanitize_callback'],
            )
        );

        $control_args = array(
            'label'   => $args['label'],
            'section' => 'apl_home_cms',
            'settings'=> $setting_key,
        );

        if ('textarea' === $args['type']) {
            $wp_customize->add_control(
                $setting_key,
                array_merge(
                    $control_args,
                    array(
                        'type' => 'textarea',
                    )
                )
            );
        } elseif ('url' === $args['type']) {
            $wp_customize->add_control(
                $setting_key,
                array_merge(
                    $control_args,
                    array(
                        'type' => 'url',
                    )
                )
            );
        } elseif ('select' === $args['type']) {
            $wp_customize->add_control(
                $setting_key,
                array_merge(
                    $control_args,
                    array(
                        'type'    => 'select',
                        'choices' => isset($args['choices']) ? $args['choices'] : array(),
                    )
                )
            );
        } elseif ('media' === $args['type']) {
            $wp_customize->add_control(
                new WP_Customize_Media_Control(
                    $wp_customize,
                    $setting_key,
                    array_merge(
                        $control_args,
                        array(
                            'mime_type' => isset($args['mime_type']) ? $args['mime_type'] : 'image',
                            'description' => isset($args['description']) ? $args['description'] : '',
                        )
                    )
                )
            );
        } else {
            $wp_customize->add_control(
                $setting_key,
                array_merge(
                    $control_args,
                    array(
                        'type' => 'text',
                    )
                )
            );
        }
    }

    $media_control_class = class_exists('WP_Customize_Media_Control') ? 'WP_Customize_Media_Control' : 'WP_Customize_Image_Control';

    for ($i = 1; $i <= 4; $i++) {
        $setting_id = "apl_home_sponsor{$i}_img";

        $wp_customize->add_setting(
            $setting_id,
            array(
                'sanitize_callback' => 'absint',
            )
        );

        $wp_customize->add_control(
            new $media_control_class(
                $wp_customize,
                $setting_id,
                array(
                    'label'     => sprintf(__('Sponsor %d: Logo', 'apl-theme'), $i),
                    'section'   => 'apl_home_cms',
                    'mime_type' => 'image',
                )
            )
        );
    }

    for ($i = 1; $i <= 3; $i++) {
        $setting_id = "apl_home_rec{$i}_img";

        $wp_customize->add_setting(
            $setting_id,
            array(
                'sanitize_callback' => 'absint',
            )
        );

        $wp_customize->add_control(
            new $media_control_class(
                $wp_customize,
                $setting_id,
                array(
                    'label'     => sprintf(__('Recognition %d: Image', 'apl-theme'), $i),
                    'section'   => 'apl_home_cms',
                    'mime_type' => 'image',
                )
            )
        );
    }
}
add_action('customize_register', 'apl_customize_register');
