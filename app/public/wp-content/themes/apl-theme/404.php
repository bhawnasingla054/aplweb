<?php
/**
 * 404 template.
 *
 * @package APL_Theme
 */

get_header();
?>

<main class="apl-blog apl-blog-empty">
    <h1 class="apl-blog__title"><?php esc_html_e('Page Not Found', 'apl-theme'); ?></h1>
    <p><?php esc_html_e('Sorry, we couldn’t find the page you were looking for.', 'apl-theme'); ?></p>
    <?php get_search_form(); ?>
    <p>
        <a class="apl-blog-card__read-more" href="<?php echo esc_url(home_url('/')); ?>">
            <?php esc_html_e('Return to the homepage', 'apl-theme'); ?>
        </a>
    </p>
</main>

<?php
get_footer();
