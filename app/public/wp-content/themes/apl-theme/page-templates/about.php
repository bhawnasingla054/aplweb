<?php
/**
 * Template Name: About Page
 *
 * @package APL_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main class="apl-about">
    <?php
    // ========================================
    // HERO SECTION
    // ========================================
    $hero_badge    = trim(get_theme_mod('about_hero_badge', __('ABOUT', 'apl-theme')));
    $hero_title_1  = trim(get_theme_mod('about_hero_title_1', __('Who We Are', 'apl-theme')));
    $hero_title_2  = trim(get_theme_mod('about_hero_title_2', __('Our Company Story', 'apl-theme')));
    $hero_subtitle = trim(get_theme_mod('about_hero_subtitle', __('Gain financial acumen using our expert tools and insights to efficiently manage your money and enhance personal wealth.', 'apl-theme')));
    ?>
    <section class="apl-about__hero">
        <div class="apl-about__panel">
            <div class="apl-about__hero-inner">
                <?php if (!empty($hero_badge)) : ?>
                    <span class="apl-about__badge"><?php echo esc_html($hero_badge); ?></span>
                <?php endif; ?>

                <div class="apl-about__titles">
                    <?php if (!empty($hero_title_1)) : ?>
                        <h1 class="apl-about__title"><?php echo esc_html($hero_title_1); ?></h1>
                    <?php endif; ?>
                    <?php if (!empty($hero_title_2)) : ?>
                        <h2 class="apl-about__title apl-about__title--accent"><?php echo esc_html($hero_title_2); ?></h2>
                    <?php endif; ?>
                </div>

                <?php if (!empty($hero_subtitle)) : ?>
                    <p class="apl-about__subtitle"><?php echo esc_html($hero_subtitle); ?></p>
                <?php endif; ?>
            </div>

            <?php
            // ========================================
            // STATS CARDS - Growth Rate & Revenue
            // ========================================
            ?>
            <div class="apl-about__stats-grid">
                <?php
                $growth_enabled = get_theme_mod('about_growth_enabled', true);
                if ($growth_enabled) :
                    $growth_rate = trim(get_theme_mod('about_growth_rate', '92%'));
                    $growth_label = trim(get_theme_mod('about_growth_label', '127,023 customers acquired'));
                ?>
                <div class="apl-about__stat-card">
                    <h3 class="apl-about__stat-heading"><?php echo esc_html(get_theme_mod('about_growth_heading', 'Growth Rate')); ?></h3>
                    <div class="apl-about__stat-value"><?php echo esc_html($growth_rate); ?></div>
                    <p class="apl-about__stat-label"><?php echo esc_html($growth_label); ?></p>
                    <div class="apl-about__chart">
                        <img src="<?php echo esc_url(apl_get_media_url('about_growth_chart')); ?>" alt="Growth chart">
                    </div>
                </div>
                <?php endif; ?>

                <?php
                $revenue_enabled = get_theme_mod('about_revenue_enabled', true);
                if ($revenue_enabled) :
                    $revenue_amount = trim(get_theme_mod('about_revenue_amount', '$165,750.23'));
                    $revenue_label = trim(get_theme_mod('about_revenue_label', 'Won from 262 Deals'));
                ?>
                <div class="apl-about__stat-card">
                    <h3 class="apl-about__stat-heading"><?php echo esc_html(get_theme_mod('about_revenue_heading', 'Revenue')); ?></h3>
                    <div class="apl-about__stat-value"><?php echo esc_html($revenue_amount); ?></div>
                    <p class="apl-about__stat-label"><?php echo esc_html($revenue_label); ?></p>
                    <div class="apl-about__chart">
                        <img src="<?php echo esc_url(apl_get_media_url('about_revenue_chart')); ?>" alt="Revenue chart">
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <?php
            // ========================================
            // MISSION & VISION CARDS
            // ========================================
            $mv_cards = array();
            $mv_configs = array(
                'vision' => array(
                    'enabled' => get_theme_mod('about_vision_enabled', true),
                    'heading' => trim(get_theme_mod('about_vision_heading', __('Vision', 'apl-theme'))),
                    'text'    => trim(get_theme_mod('about_vision_text', '')),
                ),
                'mission' => array(
                    'enabled' => get_theme_mod('about_mission_enabled', true),
                    'heading' => trim(get_theme_mod('about_mission_heading', __('Mission', 'apl-theme'))),
                    'text'    => trim(get_theme_mod('about_mission_text', '')),
                ),
            );

            foreach ($mv_configs as $key => $card) {
                $has_copy = !empty($card['heading']) || !empty($card['text']);
                if ($card['enabled'] && $has_copy) {
                    $card['slug'] = $key;
                    $mv_cards[]   = $card;
                }
            }
            ?>

            <?php if (!empty($mv_cards)) : ?>
            <div class="apl-about__mv-grid">
                <?php foreach ($mv_cards as $card) : ?>
                    <article class="apl-about__mv-card">
                        <?php if (!empty($card['heading'])) : ?>
                            <h3 class="apl-about__mv-heading"><?php echo esc_html($card['heading']); ?></h3>
                        <?php endif; ?>
                        <?php if (!empty($card['text'])) : ?>
                            <p class="apl-about__mv-text"><?php echo esc_html($card['text']); ?></p>
                        <?php endif; ?>
                    </article>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php
            // ========================================
            // BOTTOM STATS BAR
            // ========================================
            ?>
            <div class="apl-about__bottom-stats">
                <?php
                $stat1_enabled = get_theme_mod('about_stat1_enabled', true);
                if ($stat1_enabled) :
                    $stat1_value = trim(get_theme_mod('about_stat1_value', '120,472'));
                    $stat1_label = trim(get_theme_mod('about_stat1_label', 'TRUSTED REVIEWS'));
                ?>
                <div class="apl-about__bottom-stat">
                    <div class="apl-about__bottom-stat-value"><?php echo esc_html($stat1_value); ?></div>
                    <div class="apl-about__bottom-stat-label"><?php echo esc_html($stat1_label); ?></div>
                </div>
                <?php endif; ?>

                <?php
                $stat2_enabled = get_theme_mod('about_stat2_enabled', true);
                if ($stat2_enabled) :
                    $stat2_value = trim(get_theme_mod('about_stat2_value', '99%'));
                    $stat2_label = trim(get_theme_mod('about_stat2_label', 'CUSTOMER SATISFACTION'));
                ?>
                <div class="apl-about__bottom-stat">
                    <div class="apl-about__bottom-stat-value"><?php echo esc_html($stat2_value); ?></div>
                    <div class="apl-about__bottom-stat-label"><?php echo esc_html($stat2_label); ?></div>
                </div>
                <?php endif; ?>

                <?php
                $stat3_enabled = get_theme_mod('about_stat3_enabled', true);
                if ($stat3_enabled) :
                    $stat3_value = trim(get_theme_mod('about_stat3_value', '92K'));
                    $stat3_label = trim(get_theme_mod('about_stat3_label', 'EXPENSES SAVED'));
                ?>
                <div class="apl-about__bottom-stat">
                    <div class="apl-about__bottom-stat-value"><?php echo esc_html($stat3_value); ?></div>
                    <div class="apl-about__bottom-stat-label"><?php echo esc_html($stat3_label); ?></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php
    // ========================================
    // VISION UNVEILED SECTION
    // ========================================
    $vision_enabled   = get_theme_mod('about_vision_section_enabled', true);
    if ($vision_enabled) :
        $vision_badge     = trim(get_theme_mod('about_vision_section_badge', ''));
        $vision_title     = trim(get_theme_mod('about_vision_section_title', __('Our Vision Unveiled', 'apl-theme')));
        $vision_image     = apl_get_media_url('about_vision_section_image');
    ?>
    <section class="apl-about__vision-section">
        <div class="apl-about__panel">
            <?php if (!empty($vision_badge)) : ?>
                <span class="apl-about__badge"><?php echo esc_html($vision_badge); ?></span>
            <?php endif; ?>
            <?php if (!empty($vision_title)) : ?>
                <h2 class="apl-about__section-title"><?php echo esc_html($vision_title); ?></h2>
            <?php endif; ?>
            <?php if (!empty($vision_image)) : ?>
                <div class="apl-about__vision-image">
                    <img src="<?php echo esc_url($vision_image); ?>" alt="<?php echo esc_attr($vision_title); ?>">
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php
    // ========================================
    // TEAM SECTION
    // ========================================
    $team_enabled = get_theme_mod('about_team_enabled', true);
    if ($team_enabled) :
        $team_badge    = trim(get_theme_mod('about_team_badge', __('TEAM', 'apl-theme')));
        $team_title_1  = trim(get_theme_mod('about_team_title_1', __('The Visionaries', 'apl-theme')));
        $team_title_2  = trim(get_theme_mod('about_team_title_2', __('Behind Our Success', 'apl-theme')));

        // Get team members from CPT
        $team_members = get_posts(array(
            'post_type'      => 'apl_person',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
            'tax_query'      => array(
                array(
                    'taxonomy' => 'apl_person_group',
                    'field'    => 'slug',
                    'terms'    => 'team',
                ),
            ),
        ));
    ?>
    <section class="apl-about__team">
        <div class="apl-about__panel">
            <?php if (!empty($team_badge)) : ?>
                <span class="apl-about__badge"><?php echo esc_html($team_badge); ?></span>
            <?php endif; ?>
            <div class="apl-about__team-header">
                <?php if (!empty($team_title_1)) : ?>
                    <h2 class="apl-about__team-title"><?php echo esc_html($team_title_1); ?></h2>
                <?php endif; ?>
                <?php if (!empty($team_title_2)) : ?>
                    <h2 class="apl-about__team-title apl-about__team-title--accent"><?php echo esc_html($team_title_2); ?></h2>
                <?php endif; ?>
            </div>

            <?php if (!empty($team_members)) : ?>
                <div class="apl-about__team-grid">
                    <?php foreach ($team_members as $member) :
                        $member_name = get_the_title($member);
                        $member_role = get_post_meta($member->ID, 'apl_role', true);
                        $member_desc = get_the_content(null, false, $member);
                        $member_photo = get_the_post_thumbnail_url($member, 'full');
                    ?>
                        <article class="apl-about__team-card">
                            <div class="apl-about__team-card-header">
                                <div class="apl-about__team-info">
                                    <h3 class="apl-about__team-name"><?php echo esc_html($member_name); ?></h3>
                                    <?php if (!empty($member_role)) : ?>
                                        <p class="apl-about__team-role"><?php echo esc_html($member_role); ?></p>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($member_desc)) : ?>
                                    <p class="apl-about__team-desc"><?php echo esc_html($member_desc); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="apl-about__team-badge-container">
                                <div class="apl-about__team-badge">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 2L2 7V12C2 16.97 6.03 21 12 22C17.97 21 22 16.97 22 12V7L12 2Z" fill="currentColor"/>
                                    </svg>
                                    <span>Qupe</span>
                                </div>
                                <?php if (!empty($member_photo)) : ?>
                                    <div class="apl-about__team-photo">
                                        <img src="<?php echo esc_url($member_photo); ?>" alt="<?php echo esc_attr($member_name); ?>">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php
    // ========================================
    // MOBILE APP BANKING SECTION
    // ========================================
    $mobile_enabled = get_theme_mod('about_mobile_enabled', true);
    if ($mobile_enabled) :
        $mobile_badge    = trim(get_theme_mod('about_mobile_badge', __('MOBIL APP', 'apl-theme')));
        $mobile_title_1  = trim(get_theme_mod('about_mobile_title_1', __('Mobile App Banking', 'apl-theme')));
        $mobile_title_2  = trim(get_theme_mod('about_mobile_title_2', __('at Your Fingertips', 'apl-theme')));
        $mobile_subtitle = trim(get_theme_mod('about_mobile_subtitle', ''));

        // Get features
        $features = array();
        for ($i = 1; $i <= 2; $i++) {
            $feature_title = trim(get_theme_mod("about_mobile_feature{$i}_title", ''));
            $feature_desc  = trim(get_theme_mod("about_mobile_feature{$i}_desc", ''));
            if (!empty($feature_title)) {
                $features[] = array(
                    'title' => $feature_title,
                    'desc'  => $feature_desc,
                );
            }
        }

        // Get app images
        $app_image1 = apl_get_media_url('about_mobile_image1');
        $app_image2 = apl_get_media_url('about_mobile_image2');
    ?>
    <section class="apl-about__mobile">
        <div class="apl-about__panel">
            <div class="apl-about__mobile-content">
                <?php if (!empty($mobile_badge)) : ?>
                    <span class="apl-about__badge"><?php echo esc_html($mobile_badge); ?></span>
                <?php endif; ?>
                <h2 class="apl-about__mobile-title">
                    <?php if (!empty($mobile_title_1)) : ?>
                        <?php echo esc_html($mobile_title_1); ?>
                    <?php endif; ?>
                    <?php if (!empty($mobile_title_2)) : ?>
                        <span class="apl-about__mobile-title--accent"><?php echo esc_html($mobile_title_2); ?></span>
                    <?php endif; ?>
                </h2>
                <?php if (!empty($mobile_subtitle)) : ?>
                    <p class="apl-about__mobile-subtitle"><?php echo esc_html($mobile_subtitle); ?></p>
                <?php endif; ?>

                <?php if (!empty($features)) : ?>
                    <ul class="apl-about__mobile-features">
                        <?php foreach ($features as $feature) : ?>
                            <li class="apl-about__mobile-feature">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="10" cy="10" r="10" fill="#FF7A18"/>
                                    <path d="M6 10L9 13L14 7" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <div>
                                    <strong><?php echo esc_html($feature['title']); ?>:</strong>
                                    <?php if (!empty($feature['desc'])) : ?>
                                        <?php echo esc_html($feature['desc']); ?>
                                    <?php endif; ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <div class="apl-about__mobile-images">
                <?php if (!empty($app_image1)) : ?>
                    <div class="apl-about__mobile-image">
                        <img src="<?php echo esc_url($app_image1); ?>" alt="Mobile app screen 1">
                    </div>
                <?php endif; ?>
                <?php if (!empty($app_image2)) : ?>
                    <div class="apl-about__mobile-image">
                        <img src="<?php echo esc_url($app_image2); ?>" alt="Mobile app screen 2">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php
    // ========================================
    // CEO MESSAGE SECTION
    // ========================================
    $ceo_enabled = get_theme_mod('about_ceo_enabled', true);
    if ($ceo_enabled) :
        $ceo_image = apl_get_media_url('about_ceo_image');
        $ceo_text1 = trim(get_theme_mod('about_ceo_text1', ''));
        $ceo_text2 = trim(get_theme_mod('about_ceo_text2', ''));
    ?>
    <section class="apl-about__ceo">
        <div class="apl-about__panel">
            <?php if (!empty($ceo_image)) : ?>
                <div class="apl-about__ceo-image">
                    <img src="<?php echo esc_url($ceo_image); ?>" alt="CEO">
                </div>
            <?php endif; ?>
            <div class="apl-about__ceo-content">
                <?php if (!empty($ceo_text1)) : ?>
                    <p class="apl-about__ceo-text"><?php echo esc_html($ceo_text1); ?></p>
                <?php endif; ?>
                <?php if (!empty($ceo_text2)) : ?>
                    <p class="apl-about__ceo-text"><?php echo esc_html($ceo_text2); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php
    // ========================================
    // TESTIMONIALS SECTION
    // ========================================
    $testimonials_enabled = get_theme_mod('about_testimonials_enabled', true);
    if ($testimonials_enabled) :
        $testimonials_badge = trim(get_theme_mod('about_testimonials_badge', __('TESTIMONIAL', 'apl-theme')));
        $testimonials_title = trim(get_theme_mod('about_testimonials_title', __('What people who work with us think about us?', 'apl-theme')));

        // Get testimonials
        $testimonials = array();
        for ($i = 1; $i <= 8; $i++) {
            $test_name = trim(get_theme_mod("about_testimonial{$i}_name", ''));
            $test_role = trim(get_theme_mod("about_testimonial{$i}_role", ''));
            $test_text = trim(get_theme_mod("about_testimonial{$i}_text", ''));
            $test_photo = apl_get_media_url("about_testimonial{$i}_photo");
            if (!empty($test_name) && !empty($test_text)) {
                $testimonials[] = array(
                    'name'  => $test_name,
                    'role'  => $test_role,
                    'text'  => $test_text,
                    'photo' => $test_photo,
                );
            }
        }
    ?>
    <section class="apl-about__testimonials">
        <div class="apl-about__panel">
            <?php if (!empty($testimonials_badge)) : ?>
                <span class="apl-about__badge"><?php echo esc_html($testimonials_badge); ?></span>
            <?php endif; ?>
            <?php if (!empty($testimonials_title)) : ?>
                <h2 class="apl-about__testimonials-title"><?php echo esc_html($testimonials_title); ?></h2>
            <?php endif; ?>

            <?php if (!empty($testimonials)) : ?>
                <div class="apl-about__testimonials-grid">
                    <?php foreach ($testimonials as $testimonial) : ?>
                        <article class="apl-about__testimonial">
                            <div class="apl-about__testimonial-header">
                                <?php if (!empty($testimonial['photo'])) : ?>
                                    <img class="apl-about__testimonial-photo" src="<?php echo esc_url($testimonial['photo']); ?>" alt="<?php echo esc_attr($testimonial['name']); ?>">
                                <?php endif; ?>
                                <div>
                                    <h3 class="apl-about__testimonial-name"><?php echo esc_html($testimonial['name']); ?></h3>
                                    <?php if (!empty($testimonial['role'])) : ?>
                                        <p class="apl-about__testimonial-role"><?php echo esc_html($testimonial['role']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <p class="apl-about__testimonial-text"><?php echo esc_html($testimonial['text']); ?></p>
                        </article>
                    <?php endforeach; ?>
                </div>

                <?php if (count($testimonials) > 6) : ?>
                    <div class="apl-about__testimonials-more">
                        <button class="apl-about__btn-more"><?php echo esc_html(get_theme_mod('about_testimonials_more_label', __('Learn More', 'apl-theme'))); ?></button>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php
    // ========================================
    // FINAL CTA SECTION
    // ========================================
    $cta_enabled = get_theme_mod('about_cta_enabled', true);
    if ($cta_enabled) :
        $cta_title = trim(get_theme_mod('about_cta_title', __('Open an account for exclusive financial perks', 'apl-theme')));
        $cta_button_text = trim(get_theme_mod('about_cta_button_text', __('Get started - for free', 'apl-theme')));
        $cta_button_url = trim(get_theme_mod('about_cta_button_url', '#'));
    ?>
    <section class="apl-about__cta">
        <div class="apl-about__panel apl-about__panel--cta">
            <?php if (!empty($cta_title)) : ?>
                <h2 class="apl-about__cta-title"><?php echo esc_html($cta_title); ?></h2>
            <?php endif; ?>
            <?php if (!empty($cta_button_text) && !empty($cta_button_url)) : ?>
                <a href="<?php echo esc_url($cta_button_url); ?>" class="apl-about__cta-button"><?php echo esc_html($cta_button_text); ?></a>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>
</main>

<?php
get_footer();
