<?php
/**
 * Template Name: Instagram/Social Media Page
 * Description: Landing page template matching Social Media PDF design
 *
 * @package APL_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main class="apl-instagram">
    <?php
    // ========================================
    // HERO SECTION
    // ========================================
    $hero_badge = trim(get_theme_mod('instagram_hero_badge', __('Instagram Insights', 'apl-theme')));
    $hero_title = get_theme_mod('instagram_hero_title', __('Make data driven decisions with real time insights.', 'apl-theme'));
    $hero_subtitle = get_theme_mod('instagram_hero_subtitle', __('In today\'s fast-paced business environment, staying ahead requires quick and informed decision making ERPSAA empowers.', 'apl-theme'));
    $hero_cta2_text = get_theme_mod('instagram_hero_cta2_text', __('Book A Free Demo', 'apl-theme'));
    $hero_cta2_url = get_theme_mod('instagram_hero_cta2_url', '#');

    // Hero cards
    $hero_media_mode  = get_theme_mod('instagram_hero_media_mode', 'image');
    $hero_media_embed = trim(get_theme_mod('instagram_hero_media_embed', ''));
    $hero_media_image = apl_get_media_url('instagram_hero_media_image');
    ?>
    <section class="apl-instagram__hero" id="hero">
        <div class="apl-instagram__shell">
            <div class="apl-instagram__hero-grid">
                <div class="apl-instagram__hero-copy">
                    <?php if (!empty($hero_badge)) : ?>
                        <span class="apl-instagram__eyebrow"><?php echo esc_html($hero_badge); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($hero_title)) : ?>
                        <h1 class="apl-instagram__hero-title"><?php echo esc_html($hero_title); ?></h1>
                    <?php endif; ?>
                    <?php if (!empty($hero_subtitle)) : ?>
                        <p class="apl-instagram__hero-subtitle"><?php echo esc_html($hero_subtitle); ?></p>
                    <?php endif; ?>

                    <div class="apl-instagram__hero-ctas">
                        <?php if (!empty($hero_cta2_text)) : ?>
                            <a href="<?php echo esc_url($hero_cta2_url); ?>" class="apl-instagram__cta apl-instagram__cta--primary">
                                <?php echo esc_html($hero_cta2_text); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="apl-instagram__hero-media">
                    <div class="apl-instagram__hero-frame">
                        <?php
                        if ('embed' === $hero_media_mode && !empty($hero_media_embed)) {
                            $embed_markup = wp_oembed_get($hero_media_embed, array('width' => 480));
                            if ($embed_markup) {
                                echo $embed_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            }
                        } elseif (!empty($hero_media_image)) {
                            ?>
                            <img src="<?php echo esc_url($hero_media_image); ?>" alt="<?php echo esc_attr($hero_title); ?>">
                            <?php
                        } else {
                            ?>
                            <div class="apl-instagram__hero-placeholder">
                                <?php esc_html_e('Add your 9:16 Instagram preview', 'apl-theme'); ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    // ========================================
    // STATS SECTION
    // ========================================
    $stats_enabled = get_theme_mod('instagram_stats_enabled', true);
    if ($stats_enabled) :
        $stats_title = get_theme_mod('instagram_stats_title', __('Save 110 hours per year.', 'apl-theme'));
        $stats_subtitle = get_theme_mod('instagram_stats_subtitle', __('An ERP SaaS brings everything in one place with all essential features.', 'apl-theme'));

        $stats = array();
        for ($i = 1; $i <= 3; $i++) {
            $enabled = get_theme_mod("instagram_stat{$i}_enabled", true);
            $icon = get_theme_mod("instagram_stat{$i}_icon", '');
            $text = get_theme_mod("instagram_stat{$i}_text", '');
            if ($enabled && (!empty($icon) || !empty($text))) {
                $stats[] = array('icon' => $icon, 'text' => $text);
            }
        }
    ?>
    <?php if (!empty($stats)) : ?>
    <section class="apl-instagram__metrics">
        <div class="apl-instagram__shell">
            <div class="apl-instagram__metrics-header">
                <?php if (!empty($stats_title)) : ?>
                    <h2><?php echo esc_html($stats_title); ?></h2>
                <?php endif; ?>
                <?php if (!empty($stats_subtitle)) : ?>
                    <p><?php echo esc_html($stats_subtitle); ?></p>
                <?php endif; ?>
            </div>

            <div class="apl-instagram__metrics-grid">
                <?php foreach ($stats as $stat) : ?>
                    <article class="apl-instagram__metric">
                        <?php if (!empty($stat['icon'])) : ?>
                            <span class="apl-instagram__metric-label"><?php echo esc_html($stat['icon']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($stat['text'])) : ?>
                            <p class="apl-instagram__metric-value"><?php echo esc_html($stat['text']); ?></p>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <?php endif; ?>

    <?php
    // ========================================
    // FEATURES SECTION
    // ========================================
    $features_enabled = get_theme_mod('instagram_features_enabled', true);
    if ($features_enabled) :
        $features_title = get_theme_mod('instagram_features_title', __('Features that set us apart and make us proud', 'apl-theme'));
        $features_subtitle = get_theme_mod('instagram_features_subtitle', '');

        $features = array();
        for ($i = 1; $i <= 4; $i++) {
            $enabled = get_theme_mod("instagram_feature{$i}_enabled", true);
            $number = get_theme_mod("instagram_feature{$i}_number", $i);
            $title = get_theme_mod("instagram_feature{$i}_title", '');
            $description = get_theme_mod("instagram_feature{$i}_description", '');
            $image = apl_get_media_url("instagram_feature{$i}_image");

            if ($enabled && (!empty($title) || !empty($image))) {
                $features[] = array(
                    'number' => $number,
                    'title' => $title,
                    'description' => $description,
                    'image' => $image
                );
            }
        }
    ?>
    <?php if (!empty($features)) : ?>
    <section class="apl-instagram__stories">
        <div class="apl-instagram__shell">
            <?php if (!empty($features_title) || !empty($features_subtitle)) : ?>
                <div class="apl-instagram__stories-header">
                    <?php if (!empty($features_title)) : ?>
                        <h2><?php echo esc_html($features_title); ?></h2>
                    <?php endif; ?>
                    <?php if (!empty($features_subtitle)) : ?>
                        <p><?php echo esc_html($features_subtitle); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="apl-instagram__stories-grid">
                <?php foreach ($features as $feature) : ?>
                    <article class="apl-instagram__story">
                        <?php if (!empty($feature['image'])) : ?>
                            <div class="apl-instagram__story-cover">
                                <img src="<?php echo esc_url($feature['image']); ?>" alt="<?php echo esc_attr($feature['title']); ?>">
                            </div>
                        <?php endif; ?>
                        <div class="apl-instagram__story-body">
                            <?php if (!empty($feature['number'])) : ?>
                                <span class="apl-instagram__story-index"><?php echo esc_html($feature['number']); ?></span>
                            <?php endif; ?>
                            <?php if (!empty($feature['title'])) : ?>
                                <h3><?php echo esc_html($feature['title']); ?></h3>
                            <?php endif; ?>
                            <?php if (!empty($feature['description'])) : ?>
                                <p><?php echo esc_html($feature['description']); ?></p>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <?php endif; ?>

    <?php
    // ========================================
    // SPOTLIGHTS SECTION
    // ========================================
    $spotlights_enabled = get_theme_mod('instagram_spotlights_enabled', true);
    if ($spotlights_enabled) :
        $spotlights_title = get_theme_mod('instagram_spotlights_title', __('Our Expert Services to Drive Growth', 'apl-theme'));
        $spotlights = array();
        for ($i = 1; $i <= 3; $i++) {
            $enabled = get_theme_mod("instagram_spotlight{$i}_enabled", true);
            $heading = trim(get_theme_mod("instagram_spotlight{$i}_heading", ''));
            $body    = trim(get_theme_mod("instagram_spotlight{$i}_body", ''));
            $mode    = get_theme_mod("instagram_spotlight{$i}_mode", 'image');
            $embed   = trim(get_theme_mod("instagram_spotlight{$i}_embed", ''));
            $image   = apl_get_media_url("instagram_spotlight{$i}_image");

            if ($enabled && (!empty($heading) || !empty($body) || !empty($embed) || !empty($image))) {
                $spotlights[] = array(
                    'heading' => $heading,
                    'body'    => $body,
                    'mode'    => $mode,
                    'embed'   => $embed,
                    'image'   => $image,
                );
            }
        }
    ?>
    <?php if (!empty($spotlights)) : ?>
        <section class="apl-instagram__spotlights">
            <div class="apl-instagram__shell">
                <?php if (!empty($spotlights_title)) : ?>
                    <div class="apl-instagram__spotlights-header">
                        <h2><?php echo esc_html($spotlights_title); ?></h2>
                    </div>
                <?php endif; ?>

                <div class="apl-instagram__spotlights-grid">
                    <?php foreach ($spotlights as $card) : ?>
                        <article class="apl-instagram__spotlight-card">
                            <div class="apl-instagram__spotlight-media">
                                <?php
                                $rendered = false;
                                if ('embed' === $card['mode'] && !empty($card['embed'])) {
                                    $embed_markup = wp_oembed_get($card['embed']);
                                    if ($embed_markup) {
                                        echo $embed_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                        $rendered = true;
                                    }
                                }

                                if (!$rendered && !empty($card['image'])) :
                                    ?>
                                    <img src="<?php echo esc_url($card['image']); ?>" alt="<?php echo esc_attr($card['heading']); ?>">
                                <?php else : ?>
                                    <?php if (!$rendered) : ?>
                                        <div class="apl-instagram__spotlight-placeholder">
                                            <?php esc_html_e('Add Instagram media', 'apl-theme'); ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <div class="apl-instagram__spotlight-body">
                                <?php if (!empty($card['heading'])) : ?>
                                    <h3><?php echo esc_html($card['heading']); ?></h3>
                                <?php endif; ?>
                                <?php if (!empty($card['body'])) : ?>
                                    <p><?php echo esc_html($card['body']); ?></p>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <?php endif; ?>
</main>

<?php
get_footer();
