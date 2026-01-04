<?php
/**
 * Homepage demo booking section.
 *
 * @package APL_Theme
 */

if (!function_exists('apl_get_theme_mod')) {
    return;
}

$enabled = apl_get_theme_mod('apl_demo_enabled', true);

if (!$enabled) {
    return;
}

$title          = apl_get_theme_mod('apl_demo_title', 'Book a Demo');
$subtitle       = apl_get_theme_mod('apl_demo_subtitle', 'Tell us what interests you and we’ll arrange a personalized demo.');
$button_label   = apl_get_theme_mod('apl_demo_button_label', 'Send Request');
$success_notice = apl_get_theme_mod('apl_demo_success_message', 'Thanks — we’ll reach out shortly.');
$error_notice   = apl_get_theme_mod('apl_demo_error_message', 'Please fill required fields and try again.');
$slider_heading = apl_get_theme_mod('apl_demo_carousel_heading', '');
$slides         = array();

for ($i = 1; $i <= 4; $i++) {
    $slide_title = apl_get_theme_mod("apl_demo_slide{$i}_title", '');
    $slide_body  = apl_get_theme_mod("apl_demo_slide{$i}_body", '');
    $slide_img   = apl_get_media_url("apl_demo_slide{$i}_image");

    if (!empty($slide_title) || !empty($slide_body) || !empty($slide_img)) {
        $slides[] = array(
            'title' => $slide_title,
            'body'  => $slide_body,
            'img'   => $slide_img,
        );
    }
}

$slide_count   = count($slides);
$inner_classes = 'apl-demo__inner';
$status         = isset($_GET['demo']) ? sanitize_text_field(wp_unslash($_GET['demo'])) : '';
$form_action    = admin_url('admin-post.php');

?>
<section class="apl-demo" id="demo" aria-label="<?php echo esc_attr($title); ?>">
    <div class="<?php echo esc_attr($inner_classes); ?>">
        <div class="apl-demo__left">
            <h2><?php echo esc_html($title); ?></h2>
            <p class="apl-demo__subtitle"><?php echo esc_html($subtitle); ?></p>

            <?php if ('sent' === $status) : ?>
                <div class="apl-demo__notice apl-demo__notice--success"><?php echo esc_html($success_notice); ?></div>
            <?php elseif ('error' === $status) : ?>
                <div class="apl-demo__notice apl-demo__notice--error"><?php echo esc_html($error_notice); ?></div>
            <?php endif; ?>

            <form method="post" action="<?php echo esc_url($form_action); ?>" class="apl-demo__form">
                <input type="hidden" name="action" value="apl_demo_request">
                <?php wp_nonce_field('apl_demo_request', 'apl_demo_nonce'); ?>

                <div class="apl-demo__field">
                    <label for="apl-demo-name"><?php esc_html_e('Name', 'apl-theme'); ?> *</label>
                    <input type="text" id="apl-demo-name" name="demo_name" required>
                </div>

                <div class="apl-demo__field">
                    <label for="apl-demo-email"><?php esc_html_e('Work email', 'apl-theme'); ?> *</label>
                    <input type="email" id="apl-demo-email" name="demo_email" required>
                </div>

                <div class="apl-demo__field">
                    <label for="apl-demo-company"><?php esc_html_e('Company', 'apl-theme'); ?></label>
                    <input type="text" id="apl-demo-company" name="demo_company">
                </div>

                <div class="apl-demo__field">
                    <label for="apl-demo-role"><?php esc_html_e('Role', 'apl-theme'); ?></label>
                    <input type="text" id="apl-demo-role" name="demo_role">
                </div>

                <div class="apl-demo__field apl-demo__field--full">
                    <label for="apl-demo-message"><?php esc_html_e('Use case / message', 'apl-theme'); ?></label>
                    <textarea id="apl-demo-message" name="demo_message" rows="4"></textarea>
                </div>

                <div class="apl-demo__actions">
                    <button type="submit" class="apl-demo__submit">
                        <?php echo esc_html($button_label); ?>
                    </button>
                </div>
            </form>
        </div>

        <?php $right_classes = 'apl-demo__right' . (0 === $slide_count ? ' apl-demo__right--empty' : ''); ?>
        <div class="<?php echo esc_attr($right_classes); ?>">
            <?php if ($slide_count > 0) : ?>
                <div class="apl-demo__carousel" data-autoplay="<?php echo esc_attr($slide_count > 1 ? 'true' : 'false'); ?>" data-total="<?php echo esc_attr($slide_count); ?>">
                    <?php if (!empty($slider_heading)) : ?>
                        <h3 class="apl-demo-carousel__heading"><?php echo esc_html($slider_heading); ?></h3>
                    <?php endif; ?>
                    <button class="apl-demo__arrow apl-demo__arrow--prev" type="button" aria-label="<?php esc_attr_e('Previous slide', 'apl-theme'); ?>" <?php disabled($slide_count <= 1); ?> data-dir="prev">
                        <span>&lsaquo;</span>
                    </button>
                    <div class="apl-demo__track">
                        <?php foreach ($slides as $index => $slide) : ?>
                            <?php
                            $card_classes = 'apl-demo__card';
                            if (empty($slide['img'])) {
                                $card_classes .= ' apl-demo__card--text';
                            }
                            ?>
                            <article class="<?php echo esc_attr($card_classes); ?>" data-index="<?php echo esc_attr($index); ?>">
                                <?php if (!empty($slide['img'])) : ?>
                                    <div class="apl-demo__card-media">
                                        <img src="<?php echo esc_url($slide['img']); ?>" alt="<?php echo esc_attr($slide['title'] ?: __('Demo highlight', 'apl-theme')); ?>">
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($slide['title']) || !empty($slide['body'])) : ?>
                                    <div class="apl-demo__card-copy">
                                        <?php if (!empty($slide['title'])) : ?>
                                            <h3><?php echo esc_html($slide['title']); ?></h3>
                                        <?php endif; ?>
                                        <?php if (!empty($slide['body'])) : ?>
                                            <p><?php echo esc_html($slide['body']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </article>
                        <?php endforeach; ?>
                    </div>
                    <button class="apl-demo__arrow apl-demo__arrow--next" type="button" aria-label="<?php esc_attr_e('Next slide', 'apl-theme'); ?>" <?php disabled($slide_count <= 1); ?> data-dir="next">
                        <span>&rsaquo;</span>
                    </button>
                </div>
            <?php else : ?>
                <div class="apl-demo__carousel-placeholder">
                    <?php esc_html_e('Add demo slides in the Customizer to enable this carousel.', 'apl-theme'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
