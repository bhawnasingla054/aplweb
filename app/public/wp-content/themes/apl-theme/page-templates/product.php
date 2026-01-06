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

    <?php
    $blog_page_id     = get_option('page_for_posts');
    $blog_archive_url = $blog_page_id ? get_permalink($blog_page_id) : home_url('/blog/');
    $articles_query   = new WP_Query(
        array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => 3,
            'ignore_sticky_posts' => true,
        )
    );
    ?>

    <?php if ($articles_query->have_posts()) : ?>
        <section class="apl-product__blogs" id="latest-articles">
            <div class="apl-product__articles-wrap">
                <div class="apl-articles__header">
                    <?php
                    $articles_title = get_theme_mod('product_articles_title', __('Read all articles', 'apl-theme'));
                    ?>
                    <h2 class="apl-articles__title"><?php echo esc_html(!empty($articles_title) ? $articles_title : __('Read all articles', 'apl-theme')); ?></h2>
                    <?php if (!empty($blog_archive_url)) : ?>
                        <a class="apl-articles__all" href="<?php echo esc_url($blog_archive_url); ?>"><?php esc_html_e('View all', 'apl-theme'); ?></a>
                    <?php endif; ?>
                </div>
                <div class="apl-articles__grid">
                    <?php
                    while ($articles_query->have_posts()) :
                        $articles_query->the_post();
                        $categories = get_the_category();
                        $category   = !empty($categories) ? $categories[0]->name : __('Insights', 'apl-theme');
                        ?>
                        <a class="apl-article-card" href="<?php the_permalink(); ?>">
                            <div class="apl-article-card__media">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('large'); ?>
                                <?php else : ?>
                                    <div class="apl-article-card__media-placeholder" aria-hidden="true"></div>
                                <?php endif; ?>
                            </div>
                            <div class="apl-article-card__body">
                                <span class="apl-article-card__meta"><?php echo esc_html($category); ?></span>
                                <h3 class="apl-article-card__heading"><?php the_title(); ?></h3>
                            </div>
                        </a>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
        <?php wp_reset_postdata(); ?>
    <?php endif; ?>

    <?php
    $demo_enabled = (bool) get_theme_mod('product_demo_enabled', false);
    if ($demo_enabled) {
        $demo_title      = get_theme_mod('product_demo_title', '');
        $demo_subtitle   = get_theme_mod('product_demo_subtitle', '');
        $demo_cta_label  = get_theme_mod('product_demo_cta_label', __('Book a Demo', 'apl-theme'));
        $demo_cta_url    = get_theme_mod('product_demo_cta_url', '#book-demo');
        $demo_points     = array_filter(
            array(
                get_theme_mod('product_demo_point_1', ''),
                get_theme_mod('product_demo_point_2', ''),
                get_theme_mod('product_demo_point_3', ''),
            ),
            function ($value) {
                return '' !== trim($value);
            }
        );
        $demo_images = array();
        for ($i = 1; $i <= 3; $i++) {
            $image_url = apl_get_media_url("product_demo_img_{$i}");
            if (!$image_url) {
                continue;
            }

            $demo_images[] = array(
                'url' => $image_url,
                'alt' => get_theme_mod("product_demo_img_{$i}_alt", sprintf(__('Demo image %d', 'apl-theme'), $i)),
            );
        }

        $has_visual = !empty($demo_images);
        $has_copy   = !empty($demo_title) || !empty($demo_subtitle);

        if ($has_visual || $has_copy) :
            ?>
            <section class="apl-product__demo-cta" id="try-demo">
                <div class="apl-product__demo-cta-inner">
                    <div class="apl-demo-cta__left">
                        <div class="apl-demo-cta__copy">
                            <?php if (!empty($demo_title)) : ?>
                                <h2 class="apl-demo-cta__title"><?php echo esc_html($demo_title); ?></h2>
                            <?php endif; ?>
                            <?php if (!empty($demo_subtitle)) : ?>
                                <p class="apl-demo-cta__subtitle"><?php echo esc_html($demo_subtitle); ?></p>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($demo_cta_label) && !empty($demo_cta_url)) : ?>
                            <div class="apl-demo-cta__actions">
                                <a class="apl-product__btn apl-product__btn--primary" href="<?php echo esc_url($demo_cta_url); ?>">
                                    <?php echo esc_html($demo_cta_label); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($demo_points)) : ?>
                            <ul class="apl-demo-cta__points">
                                <?php foreach ($demo_points as $point) : ?>
                                    <li><?php echo esc_html($point); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>

                    <?php if ($has_visual) : ?>
                        <div class="apl-demo-cta__right">
                            <div class="apl-demo-cta__stack">
                                <?php
                                $card_classes = array(
                                    'apl-demo-cta__card--front',
                                    'apl-demo-cta__card--mid',
                                    'apl-demo-cta__card--back',
                                );
                                foreach ($demo_images as $index => $image) :
                                    $card_class = isset($card_classes[$index]) ? $card_classes[$index] : $card_classes[0];
                                    ?>
                                    <div class="apl-demo-cta__card <?php echo esc_attr($card_class); ?>">
                                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
            <?php
        endif;
    }
    ?>

    <section class="apl-product__how"></section>
    <section class="apl-product__benefits"></section>
    <section class="apl-product__cta"></section>
    <section class="apl-product__book-demo" id="book-demo"></section>
</main>

<?php
get_footer();
