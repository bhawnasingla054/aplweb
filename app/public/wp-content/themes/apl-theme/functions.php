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

    wp_enqueue_script(
        'apl-reference-script',
        get_template_directory_uri() . '/assets/js/reference.js',
        array(),
        $theme_version,
        true
    );
}
add_action('wp_enqueue_scripts', 'apl_theme_enqueue_assets');

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
