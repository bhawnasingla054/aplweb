<?php get_header(); ?>

<?php if (have_posts()) : ?>
    <?php while (have_posts()) : ?>
        <?php the_post(); ?>
        <article <?php post_class(); ?>>
            <header class="entry-header">
                <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
            </header>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; ?>
<?php else : ?>
    <article class="no-results">
        <p><?php esc_html_e('No content found.', 'apl-theme'); ?></p>
    </article>
<?php endif; ?>

<?php get_footer(); ?>
