<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">

<?php if (!is_front_page()) : ?>
<!-- Navigation for blog and other pages -->
<div class="framer-ixfxpl" data-framer-name="Navigation Container">
    <div class="ssr-variant hidden-1ckr8yq">
        <div class="framer-a7lhy7-container">
            <div class="ssr-variant hidden-1bhams0">
                <nav class="framer-oChCI framer-ySzuw framer-j3i4zb framer-v-1r59rv4" data-framer-name="Tablet" style="max-width: 100%; opacity: 1;">
                    <div class="framer-29w5s4" data-border="true" data-framer-name="Container" style="--border-bottom-width: 0px; --border-color: rgba(255, 255, 255, 0.05); --border-left-width: 0px; --border-right-width: 0px; --border-style: solid; --border-top-width: 1px; backdrop-filter: blur(8px); background-color: var(--token-9d63c1c7-d861-4142-9e2d-0cbff97c1903, rgb(23, 23, 23)); border-radius: 16px; box-shadow: rgba(255, 255, 255, 0.1) 0px 1px 2px 0px inset; opacity: 1;">
                        <?php if (has_custom_logo()) : ?>
                        <div class="framer-v95o4h framer-1c8t2nl" data-framer-name="Logo" style="opacity: 1;">
                            <?php the_custom_logo(); ?>
                        </div>
                        <?php else : ?>
                        <a class="framer-v95o4h framer-1c8t2nl" data-framer-name="Logo" href="<?php echo esc_url(home_url('/')); ?>" style="opacity: 1;">
                            <div class="framer-1mijnca-container" style="opacity: 1;">
                                <div class="framer-ffjqz framer-psa39q framer-v-psa39q" data-framer-name="Logo Mark" style="height: 100%; width: 100%; opacity: 1;">
                                    <div class="framer-rFuua framer-juuih0" style="--1jx88ss: var(--token-0fb69f39-a3d4-4f91-b331-03e865b0d890, rgb(255, 255, 255)); opacity: 1;"></div>
                                </div>
                            </div>
                            <div class="framer-8lpjw4" data-framer-name="Accretion" data-framer-component-type="RichTextContainer" style="--extracted-r6o4lv: var(--token-0fb69f39-a3d4-4f91-b331-03e865b0d890, rgb(255, 255, 255)); --framer-paragraph-spacing: 0px; opacity: 1; transform: none; will-change: transform;">
                                <p class="framer-text framer-styles-preset-2yqw47" data-styles-preset="KqsmruUHp" style="--framer-text-color: var(--extracted-r6o4lv, var(--token-0fb69f39-a3d4-4f91-b331-03e865b0d890, rgb(255, 255, 255)));">Accretion</p>
                            </div>
                        </a>
                        <?php endif; ?>
                        <?php
                        if (function_exists('apl_theme_render_primary_menu')) {
                            apl_theme_render_primary_menu();
                        }
                        ?>
                        <div class="framer-pzbvl" data-framer-name="Button Container" style="opacity: 1;">
                            <div class="framer-15n06w9-container" style="opacity: 1;">
                                <a class="framer-md5AH framer-8Z5hc framer-P0IQu framer-0cVo4 framer-2ll5m8 framer-v-11c252k framer-1tig2iv" data-framer-name="S / Accent" href="https://framer.com/projects/new?duplicate=HlgYTkb8xP0TeLyNCBOM" target="_blank" rel="noopener" tabindex="0" style="background: linear-gradient(180deg, var(--token-b2af8d08-3339-4e61-a8f4-62dc791f6cdd, rgb(255, 133, 47)) 0%, var(--token-9552d7ad-6825-4099-8eeb-ef4800f28dce, rgb(206, 48, 0)) 100%); height: 100%; border-radius: 8px; opacity: 1;">
                                    <div class="framer-1l1x36d" data-framer-name="Background" style="background-color: var(--token-3cfec2cd-fcbc-4e6e-8f78-a7ed9a53e52a, rgb(249, 69, 0)); border-radius: 7px; opacity: 1;"></div>
                                    <div class="framer-16mynpv" data-framer-name="Get started" data-framer-component-type="RichTextContainer" style="justify-content: center; --extracted-r6o4lv: var(--token-0fb69f39-a3d4-4f91-b331-03e865b0d890, rgb(255, 255, 255)); --framer-paragraph-spacing: 0px; transform: none; opacity: 1;">
                                        <p class="framer-text framer-styles-preset-15d94cl" data-styles-preset="iEy1irmCV" style="--framer-text-color: var(--extracted-r6o4lv, var(--token-0fb69f39-a3d4-4f91-b331-03e865b0d890, rgb(255, 255, 255)));">Get started</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
