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

    // Load reference.css (base styles)
    wp_enqueue_style(
        'apl-reference-style',
        get_template_directory_uri() . '/assets/css/reference.css',
        array(),
        $theme_version
    );

    if (is_front_page()) {
        wp_enqueue_style(
            'apl-demo-style',
            get_template_directory_uri() . '/assets/css/demo.css',
            array('apl-reference-style'),
            $theme_version
        );
    }

    // Enqueue blog styles on all non-front pages
    // Load with dependency on reference.css but AFTER it with higher priority
    if (!is_front_page()) {
        wp_enqueue_style(
            'apl-blog-style',
            get_template_directory_uri() . '/assets/css/blog.css',
            array(), // Remove dependency to load independently
            $theme_version . '-' . time(), // Force reload
            'all'
        );

        // Add inline style to increase specificity
        $custom_css = "
            .apl-blog-archive { display: block !important; }
        ";
        wp_add_inline_style('apl-blog-style', $custom_css);
    }

    // Enqueue footer styles on all pages
    wp_enqueue_style(
        'apl-footer-style',
        get_template_directory_uri() . '/assets/css/footer.css',
        array(),
        $theme_version,
        'all'
    );

    wp_enqueue_script(
        'apl-reference-script',
        get_template_directory_uri() . '/assets/js/reference.js',
        array(),
        $theme_version,
        true
    );

    // Enqueue People section assets (front page only)
    if (is_front_page()) {
        wp_enqueue_style(
            'apl-people-style',
            get_template_directory_uri() . '/assets/css/people.css',
            array('apl-reference-style'),
            $theme_version
        );

        wp_enqueue_script(
            'apl-people-script',
            get_template_directory_uri() . '/assets/js/people-toggle.js',
            array(),
            $theme_version,
            true
        );
    }
}
add_action('wp_enqueue_scripts', 'apl_theme_enqueue_assets');

/**
 * Register Custom Post Type: People (Team/Advisors)
 */
function apl_register_people_cpt() {
    // Register Custom Post Type
    register_post_type('apl_person', array(
        'labels' => array(
            'name'               => __('People', 'apl-theme'),
            'singular_name'      => __('Person', 'apl-theme'),
            'add_new'            => __('Add New', 'apl-theme'),
            'add_new_item'       => __('Add New Person', 'apl-theme'),
            'edit_item'          => __('Edit Person', 'apl-theme'),
            'new_item'           => __('New Person', 'apl-theme'),
            'view_item'          => __('View Person', 'apl-theme'),
            'search_items'       => __('Search People', 'apl-theme'),
            'not_found'          => __('No people found', 'apl-theme'),
            'not_found_in_trash' => __('No people found in Trash', 'apl-theme'),
            'menu_name'          => __('People', 'apl-theme'),
        ),
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-groups',
        'supports'            => array('title', 'thumbnail', 'page-attributes'),
        'has_archive'         => false,
        'rewrite'             => false,
        'capability_type'     => 'post',
        'show_in_rest'        => false,
    ));

    // Register Taxonomy: Person Group (Team/Advisors)
    register_taxonomy('apl_person_group', 'apl_person', array(
        'labels' => array(
            'name'          => __('Groups', 'apl-theme'),
            'singular_name' => __('Group', 'apl-theme'),
            'search_items'  => __('Search Groups', 'apl-theme'),
            'all_items'     => __('All Groups', 'apl-theme'),
            'edit_item'     => __('Edit Group', 'apl-theme'),
            'update_item'   => __('Update Group', 'apl-theme'),
            'add_new_item'  => __('Add New Group', 'apl-theme'),
            'menu_name'     => __('Groups', 'apl-theme'),
        ),
        'hierarchical'      => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => false,
        'show_in_rest'      => false,
    ));

    // Register Meta Fields
    register_post_meta('apl_person', 'apl_role', array(
        'type'              => 'string',
        'single'            => true,
        'sanitize_callback' => 'sanitize_text_field',
        'show_in_rest'      => false,
    ));

    register_post_meta('apl_person', 'apl_linkedin', array(
        'type'              => 'string',
        'single'            => true,
        'sanitize_callback' => 'esc_url_raw',
        'show_in_rest'      => false,
    ));
}
add_action('init', 'apl_register_people_cpt');

/**
 * Add metabox for Person meta fields (Role + LinkedIn)
 */
function apl_person_metabox() {
    add_meta_box(
        'apl_person_details',
        __('Person Details', 'apl-theme'),
        'apl_person_metabox_callback',
        'apl_person',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'apl_person_metabox');

/**
 * Metabox callback to render fields
 */
function apl_person_metabox_callback($post) {
    wp_nonce_field('apl_person_meta', 'apl_person_meta_nonce');

    $role = get_post_meta($post->ID, 'apl_role', true);
    $linkedin = get_post_meta($post->ID, 'apl_linkedin', true);
    ?>
    <p>
        <label for="apl_role"><strong><?php _e('Role/Title:', 'apl-theme'); ?></strong></label><br>
        <input type="text" id="apl_role" name="apl_role" value="<?php echo esc_attr($role); ?>" style="width: 100%; max-width: 500px;" placeholder="e.g., CEO, Advisor, Engineer">
    </p>
    <p>
        <label for="apl_linkedin"><strong><?php _e('LinkedIn URL:', 'apl-theme'); ?></strong></label><br>
        <input type="url" id="apl_linkedin" name="apl_linkedin" value="<?php echo esc_url($linkedin); ?>" style="width: 100%; max-width: 500px;" placeholder="https://linkedin.com/in/username">
    </p>
    <?php
}

/**
 * Save metabox data
 */
function apl_save_person_meta($post_id) {
    // Check nonce
    if (!isset($_POST['apl_person_meta_nonce']) || !wp_verify_nonce($_POST['apl_person_meta_nonce'], 'apl_person_meta')) {
        return;
    }

    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save role
    if (isset($_POST['apl_role'])) {
        update_post_meta($post_id, 'apl_role', sanitize_text_field($_POST['apl_role']));
    }

    // Save LinkedIn
    if (isset($_POST['apl_linkedin'])) {
        update_post_meta($post_id, 'apl_linkedin', esc_url_raw($_POST['apl_linkedin']));
    }
}
add_action('save_post_apl_person', 'apl_save_person_meta');

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
 * Sanitize checkbox values.
 *
 * @param mixed $value Input value.
 *
 * @return bool
 */
function apl_sanitize_checkbox($value) {
    return (bool) $value;
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

    $wp_customize->add_section(
        'apl_home_demo',
        array(
            'title'    => __('Homepage – Demo', 'apl-theme'),
            'priority' => 35,
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

    // ========================================
    // SECTION: Homepage – Demo
    // ========================================
    $wp_customize->add_setting(
        'apl_demo_enabled',
        array(
            'default'           => true,
            'sanitize_callback' => 'apl_sanitize_checkbox',
        )
    );

    $wp_customize->add_control(
        'apl_demo_enabled',
        array(
            'label'   => __('Enable Demo Section', 'apl-theme'),
            'section' => 'apl_home_demo',
            'type'    => 'checkbox',
        )
    );

    $wp_customize->add_setting(
        'apl_demo_title',
        array(
            'default'           => 'Book a Demo',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'apl_demo_title',
        array(
            'label'   => __('Demo Title', 'apl-theme'),
            'section' => 'apl_home_demo',
            'type'    => 'text',
        )
    );

    $wp_customize->add_setting(
        'apl_demo_subtitle',
        array(
            'default'           => 'Tell us what interests you and we’ll arrange a personalized demo.',
            'sanitize_callback' => 'sanitize_textarea_field',
        )
    );

    $wp_customize->add_control(
        'apl_demo_subtitle',
        array(
            'label'   => __('Demo Subtitle', 'apl-theme'),
            'section' => 'apl_home_demo',
            'type'    => 'textarea',
        )
    );

    $wp_customize->add_setting(
        'apl_demo_recipient_email',
        array(
            'default'           => get_option('admin_email'),
            'sanitize_callback' => 'sanitize_email',
        )
    );

    $wp_customize->add_control(
        'apl_demo_recipient_email',
        array(
            'label'   => __('Recipient Email', 'apl-theme'),
            'section' => 'apl_home_demo',
            'type'    => 'email',
        )
    );

    $wp_customize->add_setting(
        'apl_demo_subject',
        array(
            'default'           => 'Request for Demo: SAiGE',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'apl_demo_subject',
        array(
            'label'   => __('Email Subject', 'apl-theme'),
            'section' => 'apl_home_demo',
            'type'    => 'text',
        )
    );

    $wp_customize->add_setting(
        'apl_demo_button_label',
        array(
            'default'           => 'Send Request',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'apl_demo_button_label',
        array(
            'label'   => __('Button Label', 'apl-theme'),
            'section' => 'apl_home_demo',
            'type'    => 'text',
        )
    );

    $wp_customize->add_setting(
        'apl_demo_success_message',
        array(
            'default'           => 'Thanks — we’ll reach out shortly.',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'apl_demo_success_message',
        array(
            'label'   => __('Success Message', 'apl-theme'),
            'section' => 'apl_home_demo',
            'type'    => 'text',
        )
    );

    $wp_customize->add_setting(
        'apl_demo_error_message',
        array(
            'default'           => 'Please fill required fields and try again.',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'apl_demo_error_message',
        array(
            'label'   => __('Error Message', 'apl-theme'),
            'section' => 'apl_home_demo',
            'type'    => 'text',
        )
    );

    $wp_customize->add_setting(
        'apl_demo_media',
        array(
            'sanitize_callback' => 'absint',
        )
    );

    $wp_customize->add_control(
        new $media_control_class(
            $wp_customize,
            'apl_demo_media',
            array(
                'label'     => __('Demo Media', 'apl-theme'),
                'section'   => 'apl_home_demo',
                'mime_type' => 'image',
            )
        )
    );

    $wp_customize->add_setting(
        'apl_demo_carousel_heading',
        array(
            'default'           => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        'apl_demo_carousel_heading',
        array(
            'label'       => __('Carousel Heading', 'apl-theme'),
            'description' => __('Optional. Leave blank to hide the heading above the demo carousel.', 'apl-theme'),
            'section'     => 'apl_home_demo',
            'type'        => 'text',
        )
    );

    for ($i = 1; $i <= 4; $i++) {
        $wp_customize->add_setting(
            "apl_demo_slide{$i}_title",
            array(
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field',
            )
        );

        $wp_customize->add_control(
            "apl_demo_slide{$i}_title",
            array(
                'label'   => sprintf(__('Slide %d Title', 'apl-theme'), $i),
                'section' => 'apl_home_demo',
                'type'    => 'text',
            )
        );

        $wp_customize->add_setting(
            "apl_demo_slide{$i}_body",
            array(
                'default'           => '',
                'sanitize_callback' => 'sanitize_textarea_field',
            )
        );

        $wp_customize->add_control(
            "apl_demo_slide{$i}_body",
            array(
                'label'   => sprintf(__('Slide %d Description', 'apl-theme'), $i),
                'section' => 'apl_home_demo',
                'type'    => 'textarea',
            )
        );

        $wp_customize->add_setting(
            "apl_demo_slide{$i}_image",
            array(
                'sanitize_callback' => 'absint',
            )
        );

        $wp_customize->add_control(
            new $media_control_class(
                $wp_customize,
                "apl_demo_slide{$i}_image",
                array(
                    'label'     => sprintf(__('Slide %d Image', 'apl-theme'), $i),
                    'section'   => 'apl_home_demo',
                    'mime_type' => 'image',
                )
            )
        );
    }

    // ========================================
    // SECTION: Homepage – People (Team/Advisors)
    // ========================================
    $wp_customize->add_section('apl_people_section', array(
        'title'    => __('Homepage – People', 'apl-theme'),
        'priority' => 42,
    ));

    // People Section Title
    $wp_customize->add_setting('apl_people_title', array(
        'default'           => 'Team',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('apl_people_title', array(
        'label'   => __('Section Title', 'apl-theme'),
        'section' => 'apl_people_section',
        'type'    => 'text',
    ));

    // Enable Advisors Toggle
    $wp_customize->add_setting('apl_people_enable_advisors', array(
        'default'           => false,
        'sanitize_callback' => 'rest_sanitize_boolean',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('apl_people_enable_advisors', array(
        'label'   => __('Enable Advisors Tab', 'apl-theme'),
        'section' => 'apl_people_section',
        'type'    => 'checkbox',
    ));

    // Default Tab Selection
    $wp_customize->add_setting('apl_people_default_tab', array(
        'default'           => 'advisors',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('apl_people_default_tab', array(
        'label'   => __('Default Tab', 'apl-theme'),
        'section' => 'apl_people_section',
        'type'    => 'select',
        'choices' => array(
            'advisors' => __('Advisors', 'apl-theme'),
            'team'     => __('Team', 'apl-theme'),
        ),
    ));

    // ========================================
    // SECTION: Blog Settings
    // ========================================
    $wp_customize->add_section('apl_blog_settings', array(
        'title'    => __('Blog Settings', 'apl-theme'),
        'priority' => 50,
    ));

    // Blog Archive Title
    $wp_customize->add_setting('apl_blog_archive_title', array(
        'default'           => 'Updates',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('apl_blog_archive_title', array(
        'label'   => __('Blog Archive Title', 'apl-theme'),
        'section' => 'apl_blog_settings',
        'type'    => 'text',
    ));

    // Blog Archive Subtitle
    $wp_customize->add_setting('apl_blog_archive_subtitle', array(
        'default'           => 'Stay informed with the latest news and insights.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('apl_blog_archive_subtitle', array(
        'label'   => __('Blog Archive Subtitle', 'apl-theme'),
        'section' => 'apl_blog_settings',
        'type'    => 'textarea',
    ));

    // Show Categories Filter
    $wp_customize->add_setting('apl_blog_show_categories', array(
        'default'           => true,
        'sanitize_callback' => 'rest_sanitize_boolean',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('apl_blog_show_categories', array(
        'label'   => __('Show Category Filter', 'apl-theme'),
        'section' => 'apl_blog_settings',
        'type'    => 'checkbox',
    ));

    // Posts Per Page
    $wp_customize->add_setting('apl_blog_posts_per_page', array(
        'default'           => get_option('posts_per_page', 10),
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('apl_blog_posts_per_page', array(
        'label'       => __('Posts Per Page', 'apl-theme'),
        'description' => __('Number of blog posts to show per page', 'apl-theme'),
        'section'     => 'apl_blog_settings',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 1,
            'max'  => 50,
            'step' => 1,
        ),
    ));

    // ========================================
    // SECTION: Footer Settings
    // ========================================
    $wp_customize->add_section('apl_footer_settings', array(
        'title'    => __('Footer Settings', 'apl-theme'),
        'priority' => 60,
    ));

    // Company Name
    $wp_customize->add_setting('apl_footer_company_name', array(
        'default'           => 'Accretion',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('apl_footer_company_name', array(
        'label'   => __('Company Name', 'apl-theme'),
        'section' => 'apl_footer_settings',
        'type'    => 'text',
    ));

    // Company Tagline
    $wp_customize->add_setting('apl_footer_tagline', array(
        'default'           => 'Empowering innovation through intelligent solutions',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('apl_footer_tagline', array(
        'label'   => __('Tagline', 'apl-theme'),
        'section' => 'apl_footer_settings',
        'type'    => 'text',
    ));

    // Social Links
    $wp_customize->add_setting('apl_footer_twitter', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('apl_footer_twitter', array(
        'label'   => __('Twitter URL', 'apl-theme'),
        'section' => 'apl_footer_settings',
        'type'    => 'url',
    ));

    $wp_customize->add_setting('apl_footer_linkedin', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('apl_footer_linkedin', array(
        'label'   => __('LinkedIn URL', 'apl-theme'),
        'section' => 'apl_footer_settings',
        'type'    => 'url',
    ));

    $wp_customize->add_setting('apl_footer_github', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('apl_footer_github', array(
        'label'   => __('GitHub URL', 'apl-theme'),
        'section' => 'apl_footer_settings',
        'type'    => 'url',
    ));

    $wp_customize->add_setting('apl_footer_instagram', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('apl_footer_instagram', array(
        'label'   => __('Instagram URL', 'apl-theme'),
        'section' => 'apl_footer_settings',
        'type'    => 'url',
    ));

    // Copyright Text
    $wp_customize->add_setting('apl_footer_copyright', array(
        'default'           => '© 2025 Accretion. All rights reserved.',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('apl_footer_copyright', array(
        'label'   => __('Copyright Text', 'apl-theme'),
        'section' => 'apl_footer_settings',
        'type'    => 'text',
    ));

    // Built With Text
    $wp_customize->add_setting('apl_footer_built_text', array(
        'default'           => 'Built with WordPress',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('apl_footer_built_text', array(
        'label'   => __('Built With Text', 'apl-theme'),
        'section' => 'apl_footer_settings',
        'type'    => 'text',
    ));

    // Built With URL
    $wp_customize->add_setting('apl_footer_built_url', array(
        'default'           => 'https://wordpress.org',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('apl_footer_built_url', array(
        'label'   => __('Built With URL', 'apl-theme'),
        'section' => 'apl_footer_settings',
        'type'    => 'url',
    ));
}
add_action('customize_register', 'apl_customize_register');

/**
 * Apply custom posts per page for blog archives.
 */
function apl_blog_posts_per_page($query) {
    if (!is_admin() && $query->is_main_query() && (is_home() || is_archive())) {
        $posts_per_page = apl_get_theme_mod('apl_blog_posts_per_page', get_option('posts_per_page', 10));
        $query->set('posts_per_page', absint($posts_per_page));
    }
}
add_action('pre_get_posts', 'apl_blog_posts_per_page');

/**
 * Handle demo form submissions.
 */
function apl_handle_demo_request() {
    $error_redirect = home_url('/?demo=error#demo');

    if (!isset($_POST['apl_demo_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['apl_demo_nonce'])), 'apl_demo_request')) {
        wp_safe_redirect($error_redirect);
        exit;
    }

    $name    = isset($_POST['demo_name']) ? sanitize_text_field(wp_unslash($_POST['demo_name'])) : '';
    $email   = isset($_POST['demo_email']) ? sanitize_email(wp_unslash($_POST['demo_email'])) : '';
    $company = isset($_POST['demo_company']) ? sanitize_text_field(wp_unslash($_POST['demo_company'])) : '';
    $role    = isset($_POST['demo_role']) ? sanitize_text_field(wp_unslash($_POST['demo_role'])) : '';
    $message = isset($_POST['demo_message']) ? sanitize_textarea_field(wp_unslash($_POST['demo_message'])) : '';

    if (empty($name) || empty($email) || !is_email($email)) {
        wp_safe_redirect($error_redirect);
        exit;
    }

    $recipient = apl_get_theme_mod('apl_demo_recipient_email', get_option('admin_email'));
    $recipient = sanitize_email($recipient);
    if (empty($recipient) || !is_email($recipient)) {
        $recipient = get_option('admin_email');
    }

    $subject_base = apl_get_theme_mod('apl_demo_subject', 'Request for Demo: SAiGE');
    $subject_base = sanitize_text_field($subject_base);
    $subject      = $subject_base;

    if (!empty($name)) {
        $subject .= ' — ' . $name;
        if (!empty($company)) {
            $subject .= ' (' . $company . ')';
        }
    }

    $body_lines = array(
        'Demo request received from ' . get_bloginfo('name'),
        '',
        'Name: ' . $name,
        'Email: ' . $email,
        'Company: ' . $company,
        'Role: ' . $role,
        'Message:',
        $message,
        '',
        'Site: ' . home_url('/'),
        'Time: ' . current_time('mysql'),
    );

    $headers = array();
    if (!empty($email) && !empty($name)) {
        $headers[] = 'Reply-To: ' . sprintf('%s <%s>', $name, $email);
    }

    wp_mail($recipient, $subject, implode("\n", $body_lines), $headers);

    wp_safe_redirect(home_url('/?demo=sent#demo'));
    exit;
}
add_action('admin_post_nopriv_apl_demo_request', 'apl_handle_demo_request');
add_action('admin_post_apl_demo_request', 'apl_handle_demo_request');
