<?php
/**
 * Home credibility section.
 *
 * Renders sponsors, recognition cards, and optional feature cards using Customizer data.
 *
 * @package APL Theme
 */

$is_preview = is_customize_preview();

/**
 * Render sponsors grid.
 */
ob_start();
$has_sponsor = false;
for ($i = 1; $i <= 4; $i++) {
    $img = apl_get_media_url("apl_home_sponsor{$i}_img");
    $url = apl_get_theme_mod("apl_home_sponsor{$i}_url", '');

    if ($img) {
        $tile  = '<div class="apl-sponsor-tile">';
        $tile .= '<img src="' . esc_url($img) . '" alt="">';
        $tile .= '</div>';
        if ($url) {
            $tile = '<a class="apl-sponsor-link" href="' . esc_url($url) . '" target="_blank" rel="noopener">' . $tile . '</a>';
        }
        echo $tile; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        $has_sponsor = true;
    } elseif ($is_preview) {
        echo '<div class="apl-sponsor-tile apl-placeholder">Sponsor ' . esc_html($i) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        $has_sponsor = true;
    }
}
$sponsor_html = ob_get_clean();

/**
 * Render recognition grid.
 */
ob_start();
$has_rec = false;
for ($i = 1; $i <= 2; $i++) {
    $img = apl_get_media_url("apl_home_rec{$i}_img");
    $url = apl_get_theme_mod("apl_home_rec{$i}_url", '');
    $cap = apl_get_theme_mod("apl_home_rec{$i}_caption", '');

    if ($img) {
        $card  = '<div class="apl-rec-card">';
        $card .= '<img src="' . esc_url($img) . '" alt="">';
        if ($cap) {
            $card .= '<div class="apl-rec-caption">' . esc_html($cap) . '</div>';
        }
        $card .= '</div>';

        if ($url) {
            $card = '<a class="apl-rec-link" href="' . esc_url($url) . '" target="_blank" rel="noopener">' . $card . '</a>';
        }

        echo $card; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        $has_rec = true;
    } elseif ($is_preview) {
        echo '<div class="apl-rec-card apl-placeholder">Recognition ' . esc_html($i) . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        $has_rec = true;
    }
}
$rec_html = ob_get_clean();

/**
 * Render optional mini cards.
 */
ob_start();
$has_opt = false;
for ($i = 1; $i <= 4; $i++) {
    $title = apl_get_theme_mod("apl_home_opt{$i}_title", '');
    $body  = apl_get_theme_mod("apl_home_opt{$i}_body", '');

    if ($title || $body) {
        echo '<div class="apl-opt-card"><h6>' . esc_html($title) . '</h6><p>' . esc_html($body) . '</p></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        $has_opt = true;
    } elseif ($is_preview) {
        echo '<div class="apl-opt-card apl-placeholder"><h6>Optional Card ' . esc_html($i) . '</h6><p>Fill in Customizer to enable</p></div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        $has_opt = true;
    }
}
$opt_html = ob_get_clean();

if (! $has_sponsor && ! $has_rec && ! $has_opt) {
    return;
}
?>
<div class="apl-cred-wrap">
	<?php if ($has_sponsor) : ?>
	<div class="apl-sponsor-grid">
		<?php echo $sponsor_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
	<?php endif; ?>

	<?php if ($has_rec) : ?>
	<div class="apl-rec-grid">
		<?php echo $rec_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
	<?php endif; ?>

	<?php if ($has_opt) : ?>
	<div class="apl-opt-grid">
		<?php echo $opt_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
	<?php endif; ?>
</div>
