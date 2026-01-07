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
    // HERO SECTION WITH ALL COMPONENTS
    // ========================================
    $hero_badge    = trim(get_theme_mod('about_hero_badge', __('ABOUT', 'apl-theme')));
    $hero_title_1  = trim(get_theme_mod('about_hero_title_1', __('Who We Are', 'apl-theme')));
    $hero_title_2  = trim(get_theme_mod('about_hero_title_2', __('Our Company Story', 'apl-theme')));
    $hero_subtitle = trim(get_theme_mod('about_hero_subtitle', __('Gain financial acumen using our expert tools and insights to efficiently manage your money and enhance personal wealth.', 'apl-theme')));
    ?>
    <section class="apl-about__hero">
        <div class="apl-about__container">
            <!-- Hero Title Area -->
            <div class="apl-about__hero-content">
                <?php if (!empty($hero_badge)) : ?>
                    <span class="apl-about__badge"><?php echo esc_html($hero_badge); ?></span>
                <?php endif; ?>

                <div class="apl-about__hero-titles">
                    <?php if (!empty($hero_title_1)) : ?>
                        <h1 class="apl-about__hero-title"><?php echo esc_html($hero_title_1); ?></h1>
                    <?php endif; ?>
                    <?php if (!empty($hero_title_2)) : ?>
                        <h2 class="apl-about__hero-title apl-about__hero-title--accent"><?php echo esc_html($hero_title_2); ?></h2>
                    <?php endif; ?>
                </div>

                <?php if (!empty($hero_subtitle)) : ?>
                    <p class="apl-about__hero-subtitle"><?php echo esc_html($hero_subtitle); ?></p>
                <?php endif; ?>
            </div>

            <?php
            // Stats Cards (Growth Rate & Revenue)
            $growth_enabled = get_theme_mod('about_growth_enabled', true);
            $revenue_enabled = get_theme_mod('about_revenue_enabled', true);
            ?>

            <?php if ($growth_enabled || $revenue_enabled) : ?>
            <div class="apl-about__stats-cards">
                <?php if ($growth_enabled) : ?>
                <div class="apl-about__stat-card">
                    <h3 class="apl-about__stat-heading"><?php echo esc_html(get_theme_mod('about_growth_heading', 'Growth Rate')); ?></h3>
                    <div class="apl-about__stat-value"><?php echo esc_html(get_theme_mod('about_growth_value', '92%')); ?></div>
                    <p class="apl-about__stat-label"><?php echo esc_html(get_theme_mod('about_growth_label', '127,023 customers acquired')); ?></p>
                    <?php
                    $growth_chart = apl_get_media_url('about_growth_chart');
                    if (!empty($growth_chart)) :
                    ?>
                    <div class="apl-about__stat-chart">
                        <img src="<?php echo esc_url($growth_chart); ?>" alt="Growth chart">
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <?php if ($revenue_enabled) : ?>
                <div class="apl-about__stat-card">
                    <h3 class="apl-about__stat-heading"><?php echo esc_html(get_theme_mod('about_revenue_heading', 'Revenue')); ?></h3>
                    <div class="apl-about__stat-value"><?php echo esc_html(get_theme_mod('about_revenue_value', '$165,750.23')); ?></div>
                    <p class="apl-about__stat-label"><?php echo esc_html(get_theme_mod('about_revenue_label', 'Won from 262 Deals')); ?></p>
                    <?php
                    $revenue_chart = apl_get_media_url('about_revenue_chart');
                    if (!empty($revenue_chart)) :
                    ?>
                    <div class="apl-about__stat-chart">
                        <img src="<?php echo esc_url($revenue_chart); ?>" alt="Revenue chart">
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php
            // Vision & Mission Cards
            $vision_enabled = get_theme_mod('about_vision_enabled', true);
            $mission_enabled = get_theme_mod('about_mission_enabled', true);
            ?>

            <?php if ($vision_enabled || $mission_enabled) : ?>
            <div class="apl-about__vm-cards">
                <?php if ($vision_enabled) : ?>
                <div class="apl-about__vm-card">
                    <h3 class="apl-about__vm-heading"><?php echo esc_html(get_theme_mod('about_vision_heading', 'Vision')); ?></h3>
                    <p class="apl-about__vm-text"><?php echo esc_html(get_theme_mod('about_vision_text', 'Transforming the customer experience through technological innovation in the financial sector, fostering inclusive and sustainable economic growth for all.')); ?></p>
                </div>
                <?php endif; ?>

                <?php if ($mission_enabled) : ?>
                <div class="apl-about__vm-card">
                    <h3 class="apl-about__vm-heading"><?php echo esc_html(get_theme_mod('about_mission_heading', 'Mission')); ?></h3>
                    <p class="apl-about__vm-text"><?php echo esc_html(get_theme_mod('about_mission_text', 'To provide reliable, innovative and accessible solutions that will enable individuals and businesses to achieve their financial goals.')); ?></p>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php
            // Bottom Stats Bar
            $bottom_stats = array();
            for ($i = 1; $i <= 3; $i++) {
                $enabled = get_theme_mod("about_bottom_stat{$i}_enabled", true);
                $value = trim(get_theme_mod("about_bottom_stat{$i}_value", ''));
                $label = trim(get_theme_mod("about_bottom_stat{$i}_label", ''));
                if ($enabled && !empty($value)) {
                    $bottom_stats[] = array('value' => $value, 'label' => $label);
                }
            }
            ?>

            <?php if (!empty($bottom_stats)) : ?>
            <div class="apl-about__bottom-stats">
                <?php foreach ($bottom_stats as $stat) : ?>
                <div class="apl-about__bottom-stat">
                    <div class="apl-about__bottom-stat-value"><?php echo esc_html($stat['value']); ?></div>
                    <div class="apl-about__bottom-stat-label"><?php echo esc_html($stat['label']); ?></div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <?php
    // ========================================
    // VISION UNVEILED SECTION
    // ========================================
    $vision_section_enabled = get_theme_mod('about_vision_section_enabled', true);
    if ($vision_section_enabled) :
        $vision_section_badge = trim(get_theme_mod('about_vision_section_badge', __('ABOUT', 'apl-theme')));
        $vision_section_title_1 = trim(get_theme_mod('about_vision_section_title_1', __('Our Vision Unveiled', 'apl-theme')));
        $vision_section_title_2 = trim(get_theme_mod('about_vision_section_title_2', __('Legacy in Motion', 'apl-theme')));
        $vision_section_image = apl_get_media_url('about_vision_section_image');
    ?>
    <section class="apl-about__vision-unveiled">
        <div class="apl-about__container">
            <?php if (!empty($vision_section_badge)) : ?>
                <span class="apl-about__badge"><?php echo esc_html($vision_section_badge); ?></span>
            <?php endif; ?>

            <h2 class="apl-about__vision-unveiled-title">
                <?php if (!empty($vision_section_title_1)) : ?>
                    <?php echo esc_html($vision_section_title_1); ?>
                <?php endif; ?>
                <?php if (!empty($vision_section_title_2)) : ?>
                    <br>
                    <span class="apl-about__vision-unveiled-title--accent">
                        Experience Our <?php echo esc_html($vision_section_title_2); ?>
                    </span>
                <?php endif; ?>
            </h2>

            <?php if (!empty($vision_section_image)) : ?>
                <div class="apl-about__vision-unveiled-image">
                    <img src="<?php echo esc_url($vision_section_image); ?>" alt="<?php echo esc_attr($vision_section_title_1); ?>">
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <?php
    // ========================================
    // VALUES SECTION
    // ========================================
    $values_enabled = get_theme_mod('about_values_enabled', true);
    if ($values_enabled) :
        $values_badge = trim(get_theme_mod('about_values_badge', __('OUR VALUES', 'apl-theme')));
        $values_title = trim(get_theme_mod('about_values_title', __('What Drives Us Forward', 'apl-theme')));

        $values = array();
        for ($i = 1; $i <= 4; $i++) {
            $title = trim(get_theme_mod("about_value{$i}_title", ''));
            $desc  = trim(get_theme_mod("about_value{$i}_desc", ''));
            if (!empty($title)) {
                $values[] = array('title' => $title, 'desc' => $desc);
            }
        }
    ?>
    <?php if (!empty($values)) : ?>
    <section class="apl-about__values">
        <div class="apl-about__container">
            <?php if (!empty($values_badge)) : ?>
                <span class="apl-about__badge"><?php echo esc_html($values_badge); ?></span>
            <?php endif; ?>
            <?php if (!empty($values_title)) : ?>
                <h2 class="apl-about__section-title apl-about__section-title--center"><?php echo esc_html($values_title); ?></h2>
            <?php endif; ?>

            <div class="apl-about__values-grid">
                <?php foreach ($values as $index => $value) : ?>
                    <div class="apl-about__value-card">
                        <div class="apl-about__value-number"><?php echo sprintf('%02d', $index + 1); ?></div>
                        <h3 class="apl-about__value-title"><?php echo esc_html($value['title']); ?></h3>
                        <?php if (!empty($value['desc'])) : ?>
                            <p class="apl-about__value-desc"><?php echo esc_html($value['desc']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <?php endif; ?>

    <?php
    // ========================================
    // TEAM SECTION (SAME AS HOME PAGE)
    // ========================================
    $about_team_enabled = get_theme_mod('about_team_enabled', true);
    if ($about_team_enabled) :
        // Get Customizer settings
        $about_section_title = get_theme_mod('about_people_title', 'Meet the brains');
        $about_enable_advisors = (bool) get_theme_mod('about_people_enable_advisors', false);
        $about_default_tab = get_theme_mod('about_people_default_tab', 'advisors');

        // Query Team members
        $about_team_args = array(
            'post_type'      => 'apl_person',
            'posts_per_page' => 50,
            'orderby'        => array('menu_order' => 'ASC', 'date' => 'DESC'),
            'tax_query'      => array(
                array(
                    'taxonomy' => 'apl_person_group',
                    'field'    => 'slug',
                    'terms'    => 'team',
                ),
            ),
        );
        $about_team_query = new WP_Query($about_team_args);
        $about_team_members = array();

        if ($about_team_query->have_posts()) {
            while ($about_team_query->have_posts()) {
                $about_team_query->the_post();
                $person_id = get_the_ID();
                $role = get_post_meta($person_id, 'apl_role', true);
                $linkedin = get_post_meta($person_id, 'apl_linkedin', true);
                $photo = get_the_post_thumbnail_url($person_id, 'medium');

                // Only include if has title AND role AND photo
                if (get_the_title() && $role && $photo) {
                    $about_team_members[] = array(
                        'name'     => get_the_title(),
                        'role'     => $role,
                        'photo'    => $photo,
                        'linkedin' => $linkedin,
                    );
                }
            }
            wp_reset_postdata();
        }

        // Query Advisors members (if enabled)
        $about_advisors_members = array();
        if ($about_enable_advisors) {
            $about_advisors_args = array(
                'post_type'      => 'apl_person',
                'posts_per_page' => 50,
                'orderby'        => array('menu_order' => 'ASC', 'date' => 'DESC'),
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'apl_person_group',
                        'field'    => 'slug',
                        'terms'    => 'advisors',
                    ),
                ),
            );
            $about_advisors_query = new WP_Query($about_advisors_args);

            if ($about_advisors_query->have_posts()) {
                while ($about_advisors_query->have_posts()) {
                    $about_advisors_query->the_post();
                    $person_id = get_the_ID();
                    $role = get_post_meta($person_id, 'apl_role', true);
                    $linkedin = get_post_meta($person_id, 'apl_linkedin', true);
                    $photo = get_the_post_thumbnail_url($person_id, 'medium');

                    // Only include if has title AND role AND photo
                    if (get_the_title() && $role && $photo) {
                        $about_advisors_members[] = array(
                            'name'     => get_the_title(),
                            'role'     => $role,
                            'photo'    => $photo,
                            'linkedin' => $linkedin,
                        );
                    }
                }
                wp_reset_postdata();
            }
        }

        // Determine actual default tab (fallback to team if advisors empty)
        $about_show_pills = $about_enable_advisors && !empty($about_advisors_members);
        $about_active_tab = ($about_show_pills && $about_default_tab === 'advisors') ? 'advisors' : 'team';
        ?>

        <?php if (!empty($about_team_members)) : ?>
        <section class="apl-people" aria-label="<?php echo esc_attr($about_section_title); ?>">
            <div class="apl-people__container">

                <h2 class="apl-people__title"><?php echo esc_html($about_section_title); ?></h2>
                <p class="apl-people__subtitle">The Brains Behind the Breakthrough</p>

                <?php if ($about_show_pills) : ?>
                    <div class="apl-people__pills" role="tablist">
                        <button
                            class="apl-people__pill <?php echo ($about_active_tab === 'advisors') ? 'is-active' : ''; ?>"
                            data-tab="advisors"
                            role="tab"
                            aria-selected="<?php echo ($about_active_tab === 'advisors') ? 'true' : 'false'; ?>"
                            aria-controls="about-panel-advisors">
                            <?php _e('Advisors', 'apl-theme'); ?>
                        </button>
                        <button
                            class="apl-people__pill <?php echo ($about_active_tab === 'team') ? 'is-active' : ''; ?>"
                            data-tab="team"
                            role="tab"
                            aria-selected="<?php echo ($about_active_tab === 'team') ? 'true' : 'false'; ?>"
                            aria-controls="about-panel-team">
                            <?php _e('Team', 'apl-theme'); ?>
                        </button>
                    </div>
                <?php endif; ?>

                <?php if ($about_show_pills && !empty($about_advisors_members)) : ?>
                    <div
                        class="apl-people__panel <?php echo ($about_active_tab === 'advisors') ? 'is-active' : ''; ?>"
                        data-panel="advisors"
                        id="about-panel-advisors"
                        role="tabpanel">
                        <div class="apl-people__grid">
                            <?php foreach ($about_advisors_members as $person) : ?>
                                <?php
                                $card_tag = $person['linkedin'] ? 'a' : 'div';
                                $card_attrs = $person['linkedin'] ? 'href="' . esc_url($person['linkedin']) . '" target="_blank" rel="noopener noreferrer"' : '';
                                ?>
                                <<?php echo $card_tag; ?> class="apl-people__card" <?php echo $card_attrs; ?>>
                                    <div class="apl-people__avatar">
                                        <img src="<?php echo esc_url($person['photo']); ?>" alt="<?php echo esc_attr($person['name']); ?>">
                                    </div>
                                    <div class="apl-people__info">
                                        <h3 class="apl-people__name"><?php echo esc_html($person['name']); ?></h3>
                                        <p class="apl-people__role"><?php echo esc_html($person['role']); ?></p>
                                    </div>
                                </<?php echo $card_tag; ?>>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div
                    class="apl-people__panel <?php echo ($about_active_tab === 'team') ? 'is-active' : ''; ?>"
                    data-panel="team"
                    id="about-panel-team"
                    role="tabpanel">
                    <div class="apl-people__grid">
                        <?php foreach ($about_team_members as $person) : ?>
                            <?php
                            $card_tag = $person['linkedin'] ? 'a' : 'div';
                            $card_attrs = $person['linkedin'] ? 'href="' . esc_url($person['linkedin']) . '" target="_blank" rel="noopener noreferrer"' : '';
                            ?>
                            <<?php echo $card_tag; ?> class="apl-people__card" <?php echo $card_attrs; ?>>
                                <div class="apl-people__avatar">
                                    <img src="<?php echo esc_url($person['photo']); ?>" alt="<?php echo esc_attr($person['name']); ?>">
                                </div>
                                <div class="apl-people__info">
                                    <h3 class="apl-people__name"><?php echo esc_html($person['name']); ?></h3>
                                    <p class="apl-people__role"><?php echo esc_html($person['role']); ?></p>
                                </div>
                            </<?php echo $card_tag; ?>>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
        </section>
        <?php endif; ?>
    <?php endif; ?>

    <?php
    // ========================================
    // TESTIMONIALS SECTION
    // ========================================
    $testimonials_enabled = get_theme_mod('about_testimonials_enabled', true);
    if ($testimonials_enabled) :
        $testimonials_badge = trim(get_theme_mod('about_testimonials_badge', __('TESTIMONIALS', 'apl-theme')));
        $testimonials_title = trim(get_theme_mod('about_testimonials_title', __('Trusted by Industry Leaders', 'apl-theme')));

        $testimonials = array();
        for ($i = 1; $i <= 6; $i++) {
            $name = trim(get_theme_mod("about_testimonial{$i}_name", ''));
            $role = trim(get_theme_mod("about_testimonial{$i}_role", ''));
            $text = trim(get_theme_mod("about_testimonial{$i}_text", ''));
            $company = trim(get_theme_mod("about_testimonial{$i}_company", ''));
            $photo = apl_get_media_url("about_testimonial{$i}_photo");

            if (!empty($name) && !empty($text)) {
                $testimonials[] = array(
                    'name'    => $name,
                    'role'    => $role,
                    'text'    => $text,
                    'company' => $company,
                    'photo'   => $photo,
                );
            }
        }
    ?>
    <?php if (!empty($testimonials)) : ?>
    <section class="apl-about__testimonials">
        <div class="apl-about__container">
            <?php if (!empty($testimonials_badge)) : ?>
                <span class="apl-about__badge"><?php echo esc_html($testimonials_badge); ?></span>
            <?php endif; ?>
            <?php if (!empty($testimonials_title)) : ?>
                <h2 class="apl-about__section-title apl-about__section-title--center"><?php echo esc_html($testimonials_title); ?></h2>
            <?php endif; ?>

            <div class="apl-about__testimonials-grid">
                <?php foreach ($testimonials as $testimonial) : ?>
                    <div class="apl-about__testimonial-card">
                        <div class="apl-about__testimonial-quote">
                            <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                                <path d="M10 20C11.6569 20 13 18.6569 13 17C13 15.3431 11.6569 14 10 14C8.34315 14 7 15.3431 7 17C7 18.6569 8.34315 20 10 20Z" fill="#FF7A18" opacity="0.2"/>
                                <path d="M22 20C23.6569 20 25 18.6569 25 17C25 15.3431 23.6569 14 22 14C20.3431 14 19 15.3431 19 17C19 18.6569 20.3431 20 22 20Z" fill="#FF7A18" opacity="0.2"/>
                                <path d="M10 14V10C10 8.89543 10.8954 8 12 8H14M22 14V10C22 8.89543 22.8954 8 24 8H26" stroke="#FF7A18" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <p class="apl-about__testimonial-text"><?php echo esc_html($testimonial['text']); ?></p>
                        <div class="apl-about__testimonial-author">
                            <?php if (!empty($testimonial['photo'])) : ?>
                                <img class="apl-about__testimonial-photo" src="<?php echo esc_url($testimonial['photo']); ?>" alt="<?php echo esc_attr($testimonial['name']); ?>">
                            <?php else : ?>
                                <div class="apl-about__testimonial-photo apl-about__testimonial-photo--placeholder">
                                    <span><?php echo esc_html(substr($testimonial['name'], 0, 1)); ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="apl-about__testimonial-info">
                                <div class="apl-about__testimonial-name"><?php echo esc_html($testimonial['name']); ?></div>
                                <?php if (!empty($testimonial['role'])) : ?>
                                    <div class="apl-about__testimonial-role">
                                        <?php echo esc_html($testimonial['role']); ?>
                                        <?php if (!empty($testimonial['company'])) : ?>
                                            <span class="apl-about__testimonial-company"> at <?php echo esc_html($testimonial['company']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <?php endif; ?>

    <?php
    // ========================================
    // CTA SECTION
    // ========================================
    $cta_enabled = get_theme_mod('about_cta_enabled', true);
    if ($cta_enabled) :
        $cta_title = trim(get_theme_mod('about_cta_title', __('Ready to Transform Your Financial Future?', 'apl-theme')));
        $cta_subtitle = trim(get_theme_mod('about_cta_subtitle', __('Join thousands of satisfied customers who trust us with their financial success.', 'apl-theme')));
        $cta_button_text = trim(get_theme_mod('about_cta_button_text', __('Get Started Today', 'apl-theme')));
        $cta_button_url = trim(get_theme_mod('about_cta_button_url', '#'));
    ?>
    <section class="apl-about__cta">
        <div class="apl-about__container">
            <div class="apl-about__cta-content">
                <?php if (!empty($cta_title)) : ?>
                    <h2 class="apl-about__cta-title"><?php echo esc_html($cta_title); ?></h2>
                <?php endif; ?>
                <?php if (!empty($cta_subtitle)) : ?>
                    <p class="apl-about__cta-subtitle"><?php echo esc_html($cta_subtitle); ?></p>
                <?php endif; ?>
                <?php if (!empty($cta_button_text) && !empty($cta_button_url)) : ?>
                    <a href="<?php echo esc_url($cta_button_url); ?>" class="apl-about__cta-button">
                        <?php echo esc_html($cta_button_text); ?>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M7.5 15L12.5 10L7.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
</main>

<?php
get_footer();
