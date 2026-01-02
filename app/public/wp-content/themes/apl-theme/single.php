<?php
/**
 * Template for individual blog posts.
 *
 * @package APL_Theme
 */

get_header();
?>

<main class="apl-blog">
    <?php
    if (have_posts()) :
        while (have_posts()) :
            the_post();
            $page_for_posts = get_option('page_for_posts');
            $back_url       = $page_for_posts ? get_permalink($page_for_posts) : home_url('/');
            ?>
            <a class="apl-blog-single__back" href="<?php echo esc_url($back_url); ?>">
                ← <?php esc_html_e('Back to Blog', 'apl-theme'); ?>
            </a>

            <h1 class="apl-blog__title"><?php the_title(); ?></h1>

            <div class="apl-blog-single__meta">
                <?php
                printf(
                    /* translators: 1: post date, 2: post author */
                    esc_html__('Posted on %1$s by %2$s', 'apl-theme'),
                    esc_html(get_the_date()),
                    esc_html(get_the_author())
                );
                ?>
            </div>

            <?php if (has_post_thumbnail()) : ?>
                <div class="apl-blog-single__featured">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>

            <div class="apl-blog-single__content">
                <?php the_content(); ?>
            </div>

            <div class="apl-blog-single__terms">
                <?php
                $categories = get_the_category_list(', ');
                if ($categories) {
                    printf(
                        '<p><strong>%1$s</strong> %2$s</p>',
                        esc_html__('Categories:', 'apl-theme'),
                        wp_kses_post($categories)
                    );
                }

                $tags = get_the_tag_list('', ', ');
                if ($tags) {
                    printf(
                        '<p><strong>%1$s</strong> %2$s</p>',
                        esc_html__('Tags:', 'apl-theme'),
                        wp_kses_post($tags)
                    );
                }
                ?>
            </div>
            <?php
        endwhile;
    else :
        ?>
        <div class="apl-blog-empty">
            <p><?php esc_html_e('This post could not be found.', 'apl-theme'); ?></p>
        </div>
    <?php endif; ?>
</main>

<?php
get_footer();
