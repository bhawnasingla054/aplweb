<?php
/**
 * Footer template - CMS-controlled footer matching Dreelio design
 *
 * @package APL_Theme
 */

// Get footer settings from Customizer
$company_name = apl_get_theme_mod('apl_footer_company_name', 'Accretion');
$tagline = apl_get_theme_mod('apl_footer_tagline', 'Empowering innovation through intelligent solutions');
$twitter_url = apl_get_theme_mod('apl_footer_twitter', '');
$linkedin_url = apl_get_theme_mod('apl_footer_linkedin', '');
$github_url = apl_get_theme_mod('apl_footer_github', '');
$instagram_url = apl_get_theme_mod('apl_footer_instagram', '');
$copyright = apl_get_theme_mod('apl_footer_copyright', '© 2025 Accretion. All rights reserved.');
$built_text = apl_get_theme_mod('apl_footer_built_text', 'Built with WordPress');
$built_url = apl_get_theme_mod('apl_footer_built_url', 'https://wordpress.org');
?>

<footer class="apl-footer">
    <div class="apl-footer__container">
        <!-- Top Section: Logo, Tagline, Social + Navigation Links -->
        <div class="apl-footer__top">
            <!-- Left: Company Info -->
            <div class="apl-footer__company">
                <?php if (has_custom_logo()) : ?>
                    <div class="apl-footer__logo">
                        <?php the_custom_logo(); ?>
                    </div>
                    <p class="apl-footer__company-name"><?php echo esc_html($company_name); ?></p>
                <?php else : ?>
                    <div class="apl-footer__logo-mark">
                        <div class="apl-footer__logo-icon"></div>
                        <span class="apl-footer__logo-text"><?php echo esc_html($company_name); ?></span>
                    </div>
                <?php endif; ?>

                <?php if ($tagline) : ?>
                    <p class="apl-footer__tagline"><?php echo esc_html($tagline); ?></p>
                <?php endif; ?>

                <!-- Social Links -->
                <?php if ($twitter_url || $linkedin_url || $github_url || $instagram_url) : ?>
                    <div class="apl-footer__social">
                        <?php if ($twitter_url) : ?>
                            <a href="<?php echo esc_url($twitter_url); ?>" class="apl-footer__social-link" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                </svg>
                            </a>
                        <?php endif; ?>

                        <?php if ($linkedin_url) : ?>
                            <a href="<?php echo esc_url($linkedin_url); ?>" class="apl-footer__social-link" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M20.5 2h-17A1.5 1.5 0 002 3.5v17A1.5 1.5 0 003.5 22h17a1.5 1.5 0 001.5-1.5v-17A1.5 1.5 0 0020.5 2zM8 19H5v-9h3zM6.5 8.25A1.75 1.75 0 118.3 6.5a1.78 1.78 0 01-1.8 1.75zM19 19h-3v-4.74c0-1.42-.6-1.93-1.38-1.93A1.74 1.74 0 0013 14.19a.66.66 0 000 .14V19h-3v-9h2.9v1.3a3.11 3.11 0 012.7-1.4c1.55 0 3.36.86 3.36 3.66z"/>
                                </svg>
                            </a>
                        <?php endif; ?>

                        <?php if ($github_url) : ?>
                            <a href="<?php echo esc_url($github_url); ?>" class="apl-footer__social-link" target="_blank" rel="noopener noreferrer" aria-label="GitHub">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                </svg>
                            </a>
                        <?php endif; ?>

                        <?php if ($instagram_url) : ?>
                            <a href="<?php echo esc_url($instagram_url); ?>" class="apl-footer__social-link" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right: Navigation Links -->
            <div class="apl-footer__nav-container">
                <nav class="apl-footer__nav">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="apl-footer__link">Home</a>
                    <a href="<?php echo esc_url(home_url('/#product')); ?>" class="apl-footer__link">Product</a>
                    <a href="<?php echo esc_url(home_url('/#team')); ?>" class="apl-footer__link">Team</a>
                    <a href="<?php echo esc_url(home_url('/blog')); ?>" class="apl-footer__link">Blogs</a>
                    <a href="<?php echo esc_url(home_url('/career')); ?>" class="apl-footer__link">Career</a>
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="apl-footer__link">Contact Us</a>
                    <a href="<?php echo esc_url(home_url('/resources')); ?>" class="apl-footer__link">Resources</a>
                    <a href="<?php echo esc_url(home_url('/login')); ?>" class="apl-footer__link">Log In</a>
                    <a href="<?php echo esc_url(home_url('/terms')); ?>" class="apl-footer__link">Terms of use</a>
                    <a href="<?php echo esc_url(home_url('/privacy')); ?>" class="apl-footer__link">Privacy</a>
                </nav>
            </div>
        </div>

        <!-- Bottom Section: Copyright Only -->
        <div class="apl-footer__bottom">
            <p class="apl-footer__copyright"><?php echo esc_html($copyright); ?></p>
        </div>
    </div>
</footer>

</div>
<?php wp_footer(); ?>
</body>
</html>
