<?php
/**
 * Main fallback template for blog listing.
 * This template is used when no more specific template is available.
 *
 * @package APL_Theme
 */

get_header();

// Only show blog content if this is actually a blog-related page
// Otherwise, just show default page content
if (is_home() || is_archive() || is_search() || (is_singular('post'))) {
    // Get CMS settings
    $blog_title = apl_get_theme_mod('apl_blog_archive_title', 'Updates');
    $blog_subtitle = apl_get_theme_mod('apl_blog_archive_subtitle', 'Stay informed with the latest news and insights.');
    $show_categories = apl_get_theme_mod('apl_blog_show_categories', true);
?>

<main class="apl-blog-archive">
    <!-- Hero Section -->
    <div class="apl-blog-hero">
        <div class="apl-blog-hero__content">
            <h1 class="apl-blog-hero__title"><?php echo esc_html($blog_title); ?></h1>
            <?php if ($blog_subtitle) : ?>
                <p class="apl-blog-hero__subtitle"><?php echo esc_html($blog_subtitle); ?></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Category Filter (if enabled) -->
    <?php if ($show_categories) : ?>
        <div class="apl-blog-filters">
            <div class="apl-blog-filters__inner">
                <?php
                $categories = get_categories(array(
                    'orderby' => 'name',
                    'order'   => 'ASC',
                    'hide_empty' => true,
                ));

                if ($categories) :
                    ?>
                    <a href="<?php echo esc_url(get_post_type_archive_link('post')); ?>" class="apl-blog-filter active">
                        All
                    </a>
                    <?php foreach ($categories as $category) : ?>
                        <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="apl-blog-filter">
                            <?php echo esc_html($category->name); ?>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Blog Posts Grid -->
    <?php if (have_posts()) : ?>
        <div class="apl-blog-grid">
            <?php
            $post_index = 0;
            while (have_posts()) :
                the_post();
                $post_index++;
                $is_featured = ($post_index === 1) && !is_paged();

                // Get post metadata
                $categories = get_the_category();
                $primary_category = !empty($categories) ? $categories[0]->name : '';
                ?>

                <article <?php post_class($is_featured ? 'apl-blog-card apl-blog-card--featured' : 'apl-blog-card'); ?>>
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" class="apl-blog-card__image-link">
                            <div class="apl-blog-card__image">
                                <?php
                                $image_size = $is_featured ? 'full' : 'large';
                                the_post_thumbnail($image_size);
                                ?>
                            </div>
                        </a>
                    <?php endif; ?>

                    <div class="apl-blog-card__content">
                        <?php if ($primary_category) : ?>
                            <div class="apl-blog-card__category">
                                <?php echo esc_html(strtoupper($primary_category)); ?>
                            </div>
                        <?php endif; ?>

                        <h2 class="apl-blog-card__title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>

                        <?php if ($is_featured && has_excerpt()) : ?>
                            <div class="apl-blog-card__excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                        <?php endif; ?>

                        <div class="apl-blog-card__meta">
                            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                <?php echo esc_html(get_the_date('F j, Y')); ?>
                            </time>
                        </div>
                    </div>
                </article>

            <?php endwhile; ?>
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
            <p><?php esc_html_e('No posts were found.', 'apl-theme'); ?></p>
        </div>
    <?php endif; ?>
</main>

<?php
} else {
    // For regular pages (Product, Instagram, etc.), show default page content
    ?>
    <main id="site-content" style="min-height: 100vh; padding: 100px 20px;">
        <div style="max-width: 1200px; margin: 0 auto;">
            <?php
            while (have_posts()) {
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>
                <?php
            }
            ?>
        </div>
    </main>
    <?php
}

get_footer();
