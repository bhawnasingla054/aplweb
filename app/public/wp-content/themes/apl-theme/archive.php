<?php
/**
 * Archive template for blog posts (Dreelio-inspired design).
 *
 * @package APL_Theme
 */

get_header();

// Get CMS settings
$blog_title = apl_get_theme_mod('apl_blog_archive_title', 'Updates');
$blog_subtitle = apl_get_theme_mod('apl_blog_archive_subtitle', 'Stay informed with the latest news and insights.');
$show_categories = apl_get_theme_mod('apl_blog_show_categories', true);

// Determine archive title
if (is_category() || is_tag()) {
    $archive_title = single_term_title('', false);
} elseif (is_date()) {
    $archive_title = get_the_date('F Y');
} else {
    $archive_title = $blog_title;
}
?>

<main class="apl-blog-archive">
    <!-- Hero Section with Category Tabs -->
    <div class="apl-blog-hero">
        <div class="apl-blog-hero__content">
            <!-- Category Tabs (if enabled) -->
            <?php if ($show_categories && !is_date()) : ?>
                <div class="apl-blog-categories">
                    <?php
                    $categories = get_categories(array(
                        'orderby' => 'name',
                        'order'   => 'ASC',
                        'hide_empty' => true,
                    ));

                    if ($categories) :
                        ?>
                        <a href="<?php echo esc_url(get_post_type_archive_link('post')); ?>" class="apl-blog-category <?php echo (!is_category()) ? 'active' : ''; ?>">
                            BLOG
                        </a>
                        <?php foreach ($categories as $category) :
                            $is_current_cat = is_category($category->term_id);
                        ?>
                            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="apl-blog-category <?php echo $is_current_cat ? 'active' : ''; ?>">
                                <?php echo esc_html(strtoupper($category->name)); ?>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <h1 class="apl-blog-hero__title"><?php echo esc_html($archive_title); ?></h1>
            <?php if ($blog_subtitle && !is_category() && !is_tag() && !is_date()) : ?>
                <p class="apl-blog-hero__subtitle"><?php echo esc_html($blog_subtitle); ?></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Blog Posts Grid -->
    <?php if (have_posts()) : ?>
        <div class="apl-blog-container">
            <!-- Regular Grid Posts (no featured post on archive pages) -->
            <div class="apl-blog-grid">
            <?php
            while (have_posts()) :
                the_post();
                $categories = get_the_category();
                $primary_category = !empty($categories) ? $categories[0]->name : '';
                ?>

                <article <?php post_class('apl-blog-card'); ?>>
                    <div class="apl-blog-card__container">
                        <?php if (has_post_thumbnail()) : ?>
                            <a href="<?php the_permalink(); ?>" class="apl-blog-card__image-link">
                                <div class="apl-blog-card__image">
                                    <?php the_post_thumbnail('medium_large'); ?>
                                </div>
                            </a>
                        <?php endif; ?>

                        <div class="apl-blog-card__content">
                            <h3 class="apl-blog-card__title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>

                            <div class="apl-blog-card__meta">
                                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>" class="apl-blog-card__date">
                                    <?php echo esc_html(get_the_date('F j, Y')); ?>
                                </time>
                                <?php if ($primary_category) : ?>
                                    <span class="apl-blog-card__badge"><?php echo esc_html(strtoupper($primary_category)); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </article>

            <?php endwhile; ?>
            </div>
        </div>

        <!-- Pagination -->
        <?php if (get_the_posts_pagination()) : ?>
            <div class="apl-blog-pagination">
                <?php
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => '←',
                    'next_text' => '→',
                    'screen_reader_text' => __('Posts navigation', 'apl-theme'),
                ));
                ?>
            </div>
        <?php endif; ?>

    <?php else : ?>
        <div class="apl-blog-empty">
            <h2><?php esc_html_e('Nothing Found', 'apl-theme'); ?></h2>
            <p><?php esc_html_e('No posts were found in this archive.', 'apl-theme'); ?></p>
        </div>
    <?php endif; ?>
</main>

<?php
get_footer();
