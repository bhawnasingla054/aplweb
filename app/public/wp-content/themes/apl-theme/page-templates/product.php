<?php
/**
 * Template Name: Product Page
 *
 * @package APL_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main class="apl-product" id="apl-product">
    <?php
    $hero_subtitle = '';
    if (has_excerpt()) {
        $hero_subtitle = wpautop(get_the_excerpt());
    } else {
        $fallback_subtitle = get_theme_mod('product_subtitle', '');
        if (!empty($fallback_subtitle)) {
            $hero_subtitle = '<p>' . esc_html($fallback_subtitle) . '</p>';
        }
    }

    $primary_cta_label   = get_theme_mod('product_primary_cta_label', 'Book a Demo');
    $secondary_cta_label = get_theme_mod('product_secondary_cta_label', 'See features');
    ?>

    <section class="apl-product__hero" id="top">
        <div class="apl-product__hero-inner">
            <div class="apl-product__hero-text">
                <h1 class="apl-product__hero-title"><?php the_title(); ?></h1>

                <div class="apl-product__hero-subtitle">
                    <?php
                    if (!empty($hero_subtitle)) {
                        echo wp_kses_post($hero_subtitle);
                    } else {
                        // TODO: Replace placeholder copy with actual marketing text.
                        echo '<p>Share a concise reason why SAiGE is the product teams have been waiting for.</p>';
                    }
                    ?>
                </div>

                <div class="apl-product__hero-ctas">
                    <a class="apl-product__btn apl-product__btn--primary" href="#book-demo"><?php echo esc_html($primary_cta_label); ?></a>
                    <a class="apl-product__btn apl-product__btn--ghost" href="#how"><?php echo esc_html($secondary_cta_label); ?></a>
                </div>
            </div>

            <div class="apl-product__hero-media-wrap">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="apl-product__hero-media">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php else : ?>
                    <div class="apl-product__hero-placeholder" aria-hidden="true"></div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="apl-product__demo-strip">
        <div class="apl-product__demo-strip-inner">
            <p class="apl-product__demo-strip-text">Ready to see SAiGE in action?</p>
            <a class="apl-product__btn apl-product__btn--primary" href="#book-demo">Book a Demo</a>
        </div>
    </section>

    <?php
    $problem_blocks = array();

    for ($i = 1; $i <= 4; $i++) {
        $enabled = (bool) get_theme_mod("product_problem_{$i}_enabled", false);
        if (!$enabled) {
            continue;
        }

        $block_title = get_theme_mod("product_problem_{$i}_title", '');
        $block_text  = get_theme_mod("product_problem_{$i}_text", '');
        $block_img   = apl_get_media_url("product_problem_{$i}_image");
        $bullets     = array_filter(
            array(
                get_theme_mod("product_problem_{$i}_bullet_1", ''),
                get_theme_mod("product_problem_{$i}_bullet_2", ''),
                get_theme_mod("product_problem_{$i}_bullet_3", ''),
            ),
            function ($value) {
                return '' !== trim($value);
            }
        );

        if (empty($block_title) && empty($block_img)) {
            continue;
        }

        $problem_blocks[] = array(
            'title'   => $block_title,
            'text'    => $block_text,
            'image'   => $block_img,
            'bullets' => $bullets,
        );
    }
    ?>

    <?php
    $problem_section_title    = get_theme_mod('product_problem_section_title', __('What problem we are solving', 'apl-theme'));
    $problem_section_subtitle = get_theme_mod('product_problem_section_subtitle', '');
    ?>

    <?php if (!empty($problem_blocks)) : ?>
        <section class="apl-product__problem" id="problem">
            <div class="apl-product__container">
                <?php if (!empty($problem_section_title) || !empty($problem_section_subtitle)) : ?>
                    <div class="apl-product__section-heading">
                        <?php if (!empty($problem_section_title)) : ?>
                            <h2 class="apl-product__section-title"><?php echo esc_html($problem_section_title); ?></h2>
                        <?php endif; ?>
                        <?php if (!empty($problem_section_subtitle)) : ?>
                            <p class="apl-product__section-subtitle"><?php echo esc_html($problem_section_subtitle); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <div class="apl-problem">
                    <?php foreach ($problem_blocks as $index => $block) : ?>
                        <?php
                        $has_image  = !empty($block['image']);
                        $layout_mod = ($index % 2 === 1) ? ' apl-problem__item--reverse' : '';
                        ?>
                        <article class="apl-problem__item<?php echo esc_attr($layout_mod); ?>">
                            <?php if ($has_image) : ?>
                                <div class="apl-problem__media">
                                    <img src="<?php echo esc_url($block['image']); ?>" alt="<?php echo esc_attr($block['title']); ?>">
                                </div>
                            <?php endif; ?>

                            <div class="apl-problem__content">
                                <?php if (!empty($block['title'])) : ?>
                                    <h3><?php echo esc_html($block['title']); ?></h3>
                                <?php endif; ?>

                                <?php if (!empty($block['text'])) : ?>
                                    <p><?php echo esc_html($block['text']); ?></p>
                                <?php endif; ?>

                                <?php if (!empty($block['bullets'])) : ?>
                                    <ul>
                                        <?php foreach ($block['bullets'] as $bullet) : ?>
                                            <li><?php echo esc_html($bullet); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section class="apl-product__how"></section>
    <section class="apl-product__benefits"></section>
    <section class="apl-product__blogs"></section>
    <section class="apl-product__cta"></section>
    <section class="apl-product__book-demo" id="book-demo"></section>
</main>

<?php
get_footer();
