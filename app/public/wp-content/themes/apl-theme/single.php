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

                    <!-- Related Posts Section -->
                    <?php
                    // Get 4 most recent posts excluding current post
                    $related_args = array(
                        'post__not_in'        => array(get_the_ID()),
                        'posts_per_page'      => 4,
                        'orderby'             => 'date',
                        'order'               => 'DESC',
                        'ignore_sticky_posts' => 1,
                    );
                    $related_query = new WP_Query($related_args);

                    if ($related_query->have_posts()) :
                        ?>
                        <div class="apl-blog-single__related">
                            <h3 class="apl-blog-single__related-title"><?php esc_html_e('You may also like', 'apl-theme'); ?></h3>
                            <div class="apl-blog-single__related-grid">
                                <?php
                                while ($related_query->have_posts()) :
                                    $related_query->the_post();
                                    $related_cats = get_the_category();
                                    $related_category = !empty($related_cats) ? $related_cats[0]->name : '';
                                    ?>
                                    <article class="apl-blog-related-card">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <a href="<?php the_permalink(); ?>" class="apl-blog-related-card__image">
                                                <?php the_post_thumbnail('medium'); ?>
                                            </a>
                                        <?php endif; ?>

                                        <div class="apl-blog-related-card__content">
                                            <?php if ($related_category) : ?>
                                                <span class="apl-blog-related-card__category">
                                                    <?php echo esc_html(strtoupper($related_category)); ?>
                                                </span>
                                            <?php endif; ?>

                                            <h4 class="apl-blog-related-card__title">
                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </h4>

                                            <time class="apl-blog-related-card__date" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                                                <?php echo esc_html(get_the_date('F j, Y')); ?>
                                            </time>
                                        </div>
                                    </article>
                                <?php endwhile; ?>
                            </div>
                        </div>
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
