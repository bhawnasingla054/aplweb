<?php
/**
 * Single post template (Apple Newsroom inspired).
 *
 * @package APL_Theme
 */

get_header();
?>

<?php
if (have_posts()) :
    while (have_posts()) :
        the_post();

        // Get post metadata
        $categories = get_the_category();
        $primary_category = !empty($categories) ? $categories[0]->name : '';
        $page_for_posts = get_option('page_for_posts');
        $back_url = $page_for_posts ? get_permalink($page_for_posts) : home_url('/blog');
        ?>

        <article <?php post_class('apl-blog-single'); ?>>
            <!-- Header Section -->
            <header class="apl-blog-single__header">
                <div class="apl-blog-single__header-inner">
                    <!-- Back Link -->
                    <a class="apl-blog-single__back" href="<?php echo esc_url($back_url); ?>">
                        ← <?php esc_html_e('Back to Blogs', 'apl-theme'); ?>
                    </a>

                    <!-- Category Badge -->
                    <?php if ($primary_category) : ?>
                        <div class="apl-blog-single__category">
                            <?php echo esc_html(strtoupper($primary_category)); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Title -->
                    <h1 class="apl-blog-single__title"><?php the_title(); ?></h1>

                    <!-- Meta Info -->
                    <div class="apl-blog-single__meta">
                        <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                            <?php echo esc_html(get_the_date('F j, Y')); ?>
                        </time>
                    </div>
                </div>
            </header>

            <!-- Content Container -->
            <div class="apl-blog-single__content">
                <div class="apl-blog-single__content-inner">
                    <!-- Featured Image -->
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="apl-blog-single__featured-image">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Article Content -->
                    <div class="apl-blog-single__article">
                        <?php
                        the_content();

                        wp_link_pages(array(
                            'before'      => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'apl-theme') . '</span>',
                            'after'       => '</div>',
                            'link_before' => '<span>',
                            'link_after'  => '</span>',
                        ));
                        ?>
                    </div>

                    <?php
                    $blog_page_id     = get_option('page_for_posts');
                    $blog_archive_url = $blog_page_id ? get_permalink($blog_page_id) : home_url('/blog/');
                    $articles_query   = new WP_Query(
                        array(
                            'post_type'           => 'post',
                            'post_status'         => 'publish',
                            'posts_per_page'      => 3,
                            'ignore_sticky_posts' => true,
                            'post__not_in'        => array(get_the_ID()),
                        )
                    );

                    if ($articles_query->have_posts()) :
                        ?>
                        <section class="apl-blog-single__articles" id="latest-articles">
                            <div class="apl-blog-single__articles-wrap">
                                <div class="apl-articles__header">
                                    <h2 class="apl-articles__title"><?php esc_html_e('Read all articles', 'apl-theme'); ?></h2>
                                    <?php if (!empty($blog_archive_url)) : ?>
                                        <a class="apl-articles__all" href="<?php echo esc_url($blog_archive_url); ?>"><?php esc_html_e('View all', 'apl-theme'); ?></a>
                                    <?php endif; ?>
                                </div>

                                <div class="apl-articles__grid">
                                    <?php
                                    while ($articles_query->have_posts()) :
                                        $articles_query->the_post();
                                        $article_categories = get_the_category();
                                        $article_category   = !empty($article_categories) ? $article_categories[0]->name : __('Insights', 'apl-theme');
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
                                                <span class="apl-article-card__meta"><?php echo esc_html($article_category); ?></span>
                                                <h3 class="apl-article-card__heading"><?php the_title(); ?></h3>
                                            </div>
                                        </a>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                        </section>
                        <?php
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>
        </article>

    <?php
    endwhile;
else :
    ?>
    <div class="apl-blog-empty">
        <h2><?php esc_html_e('Post Not Found', 'apl-theme'); ?></h2>
        <p><?php esc_html_e('The post you are looking for could not be found.', 'apl-theme'); ?></p>
    </div>
<?php endif; ?>

<?php
get_footer();
