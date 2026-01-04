<?php
/**
 * Template for the blog posts page (Dreelio-inspired design).
 * This is the main blog listing page.
 *
 * @package APL_Theme
 */

get_header();

// Get CMS settings
$blog_title = apl_get_theme_mod('apl_blog_archive_title', 'Updates');
$blog_subtitle = apl_get_theme_mod('apl_blog_archive_subtitle', 'Stay informed with the latest news and insights.');
$show_categories = apl_get_theme_mod('apl_blog_show_categories', true);
?>

<main class="apl-blog-archive">
    <!-- Hero Section with Category Tabs -->
    <div class="apl-blog-hero">
        <div class="apl-blog-hero__content">
            <!-- Category Tabs (if enabled) -->
            <?php if ($show_categories) : ?>
                <div class="apl-blog-categories">
                    <?php
                    $categories = get_categories(array(
                        'orderby' => 'name',
                        'order'   => 'ASC',
                        'hide_empty' => true,
                    ));

                    if ($categories) :
                        ?>
                        <a href="<?php echo esc_url(get_post_type_archive_link('post')); ?>" class="apl-blog-category active">
                            BLOG
                        </a>
                        <?php foreach ($categories as $category) : ?>
                            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="apl-blog-category">
                                <?php echo esc_html(strtoupper($category->name)); ?>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <h1 class="apl-blog-hero__title"><?php echo esc_html($blog_title); ?></h1>
            <?php if ($blog_subtitle) : ?>
                <p class="apl-blog-hero__subtitle"><?php echo esc_html($blog_subtitle); ?></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Blog Posts Grid -->
    <?php if (have_posts()) : ?>
        <div class="apl-blog-container">
            <?php
            $post_index = 0;
            $posts_array = array();

            // Collect all posts
            while (have_posts()) :
                the_post();
                $posts_array[] = get_post();
            endwhile;

            // Reset post data
            rewind_posts();

            // Display featured post (first post)
            if (!empty($posts_array) && !is_paged()) :
                $featured_post = $posts_array[0];
                setup_postdata($featured_post);
                $categories = get_the_category($featured_post->ID);
                $primary_category = !empty($categories) ? $categories[0]->name : '';
                ?>

                <article class="apl-blog-featured">
                    <div class="apl-blog-featured__card">
                        <?php if (has_post_thumbnail($featured_post->ID)) : ?>
                            <a href="<?php echo get_permalink($featured_post->ID); ?>" class="apl-blog-featured__image-link">
                                <div class="apl-blog-featured__image">
                                    <?php echo get_the_post_thumbnail($featured_post->ID, 'large'); ?>
                                    <span class="apl-blog-featured__badge-overlay">MUST READ</span>
                                </div>
                            </a>
                        <?php endif; ?>

                        <div class="apl-blog-featured__content">
                            <h2 class="apl-blog-featured__title">
                                <a href="<?php echo get_permalink($featured_post->ID); ?>"><?php echo get_the_title($featured_post->ID); ?></a>
                            </h2>

                            <?php
                            // Get excerpt - if manual excerpt doesn't exist, WordPress will auto-generate from content
                            $excerpt = get_the_excerpt($featured_post->ID);
                            if ($excerpt) :
                                // Limit to approximately 20 words (about 2 lines)
                                $words = explode(' ', $excerpt);
                                $excerpt_limited = implode(' ', array_slice($words, 0, 20));
                                if (count($words) > 20) {
                                    $excerpt_limited .= '...';
                                }
                            ?>
                                <p class="apl-blog-featured__excerpt">
                                    <?php echo $excerpt_limited; ?>
                                </p>
                            <?php endif; ?>

                            <div class="apl-blog-featured__meta">
                                <time datetime="<?php echo esc_attr(get_the_date('c', $featured_post->ID)); ?>" class="apl-blog-featured__date">
                                    <?php echo esc_html(get_the_date('F j, Y', $featured_post->ID)); ?>
                                </time>
                                <span class="apl-blog-featured__label">FEATURED</span>
                            </div>
                        </div>
                    </div>
                </article>

                <?php wp_reset_postdata(); ?>
            <?php endif; ?>

            <!-- Regular Grid Posts -->
            <div class="apl-blog-grid">
            <?php
            // Skip first post if not paged
            $start_index = (!is_paged()) ? 1 : 0;
            for ($i = $start_index; $i < count($posts_array); $i++) :
                $post = $posts_array[$i];
                setup_postdata($post);
                $categories = get_the_category($post->ID);
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

            <?php
            endfor;
            wp_reset_postdata();
            ?>
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
            <p><?php esc_html_e('No posts were found.', 'apl-theme'); ?></p>
        </div>
    <?php endif; ?>
</main>

<?php
get_footer();
