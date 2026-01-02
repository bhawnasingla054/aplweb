<?php
/**
 * Search results template.
 *
 * @package APL_Theme
 */

get_header();

$search_title = sprintf(
    /* translators: %s: search query */
    __('Search Results for “%s”', 'apl-theme'),
    get_search_query()
);
?>

<main class="apl-blog">
    <h1 class="apl-blog__title"><?php echo esc_html($search_title); ?></h1>

    <?php if (have_posts()) : ?>
        <div class="apl-blog__posts">
            <?php
            while (have_posts()) :
                the_post();
                ?>
                <article <?php post_class('apl-blog-card'); ?>>
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="apl-blog-card__image">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('large'); ?>
                            </a>
                        </div>
                    <?php endif; ?>

                    <h2 class="apl-blog-card__title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>

                    <div class="apl-blog-card__meta">
                        <?php echo esc_html(get_the_date()); ?>
                    </div>

                    <div class="apl-blog-card__excerpt">
                        <?php the_excerpt(); ?>
                    </div>

                    <a class="apl-blog-card__read-more" href="<?php the_permalink(); ?>">
                        <?php esc_html_e('Read more →', 'apl-theme'); ?>
                    </a>
                </article>
                <?php
            endwhile;
            ?>
        </div>

        <div class="apl-blog-pagination">
            <div>
                <?php previous_posts_link(__('← Newer Results', 'apl-theme')); ?>
            </div>
            <div>
                <?php next_posts_link(__('Older Results →', 'apl-theme')); ?>
            </div>
        </div>
    <?php else : ?>
        <div class="apl-blog-empty">
            <p><?php esc_html_e('No results matched your search terms.', 'apl-theme'); ?></p>
            <?php get_search_form(); ?>
        </div>
    <?php endif; ?>
</main>

<?php
get_footer();
