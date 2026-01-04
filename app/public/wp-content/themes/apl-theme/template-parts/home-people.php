<?php
/**
 * Template part: People Section (Team/Advisors)
 *
 * Displays team members and optionally advisors with pill toggle.
 * Only shows members that have: name (title) + role + photo (featured image)
 *
 * @package APL_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get Customizer settings
$section_title = apl_get_theme_mod('apl_people_title', 'Team');
$enable_advisors = (bool) apl_get_theme_mod('apl_people_enable_advisors', false);
$default_tab = apl_get_theme_mod('apl_people_default_tab', 'advisors');

// Query Team members
$team_args = array(
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
$team_query = new WP_Query($team_args);
$team_members = array();

if ($team_query->have_posts()) {
    while ($team_query->have_posts()) {
        $team_query->the_post();
        $person_id = get_the_ID();
        $role = get_post_meta($person_id, 'apl_role', true);
        $linkedin = get_post_meta($person_id, 'apl_linkedin', true);
        $photo = get_the_post_thumbnail_url($person_id, 'medium');

        // Only include if has title AND role AND photo
        if (get_the_title() && $role && $photo) {
            $team_members[] = array(
                'name'     => get_the_title(),
                'role'     => $role,
                'photo'    => $photo,
                'linkedin' => $linkedin,
            );
        }
    }
    wp_reset_postdata();
}

// If no team members, hide entire section
if (empty($team_members)) {
    return;
}

// Query Advisors members (if enabled)
$advisors_members = array();
if ($enable_advisors) {
    $advisors_args = array(
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
    $advisors_query = new WP_Query($advisors_args);

    if ($advisors_query->have_posts()) {
        while ($advisors_query->have_posts()) {
            $advisors_query->the_post();
            $person_id = get_the_ID();
            $role = get_post_meta($person_id, 'apl_role', true);
            $linkedin = get_post_meta($person_id, 'apl_linkedin', true);
            $photo = get_the_post_thumbnail_url($person_id, 'medium');

            // Only include if has title AND role AND photo
            if (get_the_title() && $role && $photo) {
                $advisors_members[] = array(
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
$show_pills = $enable_advisors && !empty($advisors_members);
$active_tab = ($show_pills && $default_tab === 'advisors') ? 'advisors' : 'team';
?>

<section class="apl-people" aria-label="<?php echo esc_attr($section_title); ?>">
    <div class="apl-people__container">

        <h2 class="apl-people__title"><?php echo esc_html($section_title); ?></h2>
        <p class="apl-people__subtitle">The Brains Behind the Breakthrough</p>

        <?php if ($show_pills) : ?>
            <div class="apl-people__pills" role="tablist">
                <button
                    class="apl-people__pill <?php echo ($active_tab === 'advisors') ? 'is-active' : ''; ?>"
                    data-tab="advisors"
                    role="tab"
                    aria-selected="<?php echo ($active_tab === 'advisors') ? 'true' : 'false'; ?>"
                    aria-controls="panel-advisors">
                    <?php _e('Advisors', 'apl-theme'); ?>
                </button>
                <button
                    class="apl-people__pill <?php echo ($active_tab === 'team') ? 'is-active' : ''; ?>"
                    data-tab="team"
                    role="tab"
                    aria-selected="<?php echo ($active_tab === 'team') ? 'true' : 'false'; ?>"
                    aria-controls="panel-team">
                    <?php _e('Team', 'apl-theme'); ?>
                </button>
            </div>
        <?php endif; ?>

        <?php if ($show_pills && !empty($advisors_members)) : ?>
            <div
                class="apl-people__panel <?php echo ($active_tab === 'advisors') ? 'is-active' : ''; ?>"
                data-panel="advisors"
                id="panel-advisors"
                role="tabpanel">
                <div class="apl-people__grid">
                    <?php foreach ($advisors_members as $person) : ?>
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
            class="apl-people__panel <?php echo ($active_tab === 'team') ? 'is-active' : ''; ?>"
            data-panel="team"
            id="panel-team"
            role="tabpanel">
            <div class="apl-people__grid">
                <?php foreach ($team_members as $person) : ?>
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
