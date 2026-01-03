<?php
/**
 * Home credibility section.
 *
 * @package APL Theme
 */

$is_preview = is_customize_preview();

$sponsors = array();
$json_sponsors = apl_get_repeater_items('apl_home_sponsors_json');

if (!empty($json_sponsors)) {
    foreach ($json_sponsors as $item) {
        $src = '';
        if (!empty($item['id'])) {
            $src = wp_get_attachment_image_url(absint($item['id']), 'large');
        }
        if (!$src && !empty($item['src'])) {
            $src = esc_url($item['src']);
        }

        if ($src) {
            $sponsors[] = array(
                'src' => $src,
                'url' => !empty($item['url']) ? esc_url($item['url']) : '',
            );
        }
    }
}

if (empty($sponsors)) {
    for ($i = 1; $i <= 4; $i++) {
        $img = apl_get_media_url("apl_home_sponsor{$i}_img");
        $url = apl_get_theme_mod("apl_home_sponsor{$i}_url", '');

        if ($img) {
            $sponsors[] = array(
                'src' => $img,
                'url' => $url,
            );
        }
    }
}

$recognitions = array();
$json_rec = apl_get_repeater_items('apl_home_recognition_json');

if (!empty($json_rec)) {
    foreach ($json_rec as $item) {
        $src = '';
        if (!empty($item['id'])) {
            $src = wp_get_attachment_image_url(absint($item['id']), 'large');
        }
        if (!$src && !empty($item['src'])) {
            $src = esc_url($item['src']);
        }

        if ($src) {
            $recognitions[] = array(
                'src'     => $src,
                'url'     => !empty($item['url']) ? esc_url($item['url']) : '',
                'caption' => !empty($item['caption']) ? sanitize_text_field($item['caption']) : '',
            );
        }
    }
}

if (empty($recognitions)) {
    for ($i = 1; $i <= 3; $i++) {
        $img = apl_get_media_url("apl_home_rec{$i}_img");
        if ($img) {
            $recognitions[] = array(
                'src'     => $img,
                'url'     => apl_get_theme_mod("apl_home_rec{$i}_url", ''),
                'caption' => apl_get_theme_mod("apl_home_rec{$i}_caption", ''),
            );
        }
    }
}

$has_sponsor = !empty($sponsors);
$has_rec     = !empty($recognitions);

$has_opt = false;
$opt_cards = array();
for ($i = 1; $i <= 4; $i++) {
    $title = apl_get_theme_mod("apl_home_opt{$i}_title", '');
    $body  = apl_get_theme_mod("apl_home_opt{$i}_body", '');

    if ($title || $body) {
        $opt_cards[] = array(
            'title' => $title,
            'body'  => $body,
        );
        $has_opt = true;
    } elseif ($is_preview) {
        $opt_cards[] = array(
            'title' => sprintf(__('Optional Card %d', 'apl-theme'), $i),
            'body'  => __('Fill in Customizer to enable', 'apl-theme'),
            'placeholder' => true,
        );
        $has_opt = true;
    }
}

if (!$has_sponsor && !$has_rec && !$has_opt) {
    return;
}

$sponsor_count = count($sponsors);
$rec_count     = count($recognitions);
?>
<div class="apl-cred-wrap">
<?php if ($has_sponsor || $is_preview) : ?>
		<?php if ($sponsor_count > 0) : ?>
			<?php $sponsor_duplicate = $sponsor_count > 4; ?>
			<?php if ($sponsor_duplicate) : ?>
	<div class="apl-marquee apl-marquee--sponsors">
		<div class="apl-marquee-track">
			<?php for ($loop = 0; $loop < 3; $loop++) : ?>
				<?php foreach ($sponsors as $sponsor) : ?>
					<?php
                    $tile  = '<div class="apl-sponsor-tile"><img src="' . esc_url($sponsor['src']) . '" alt=""></div>';
                    $link  = !empty($sponsor['url']) ? '<a class="apl-sponsor-link" href="' . esc_url($sponsor['url']) . '" target="_blank" rel="noopener">' . $tile . '</a>' : $tile;
                    echo $link; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    ?>
				<?php endforeach; ?>
			<?php endfor; ?>
		</div>
	</div>
			<?php else : ?>
	<div class="apl-sponsor-static">
		<div class="apl-sponsor-track">
			<?php foreach ($sponsors as $sponsor) : ?>
				<?php
                $tile  = '<div class="apl-sponsor-tile"><img src="' . esc_url($sponsor['src']) . '" alt=""></div>';
                $link  = !empty($sponsor['url']) ? '<a class="apl-sponsor-link" href="' . esc_url($sponsor['url']) . '" target="_blank" rel="noopener">' . $tile . '</a>' : $tile;
                echo $link; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                ?>
			<?php endforeach; ?>
		</div>
	</div>
			<?php endif; ?>
		<?php elseif ($is_preview) : ?>
	<div class="apl-sponsor-static">
		<div class="apl-sponsor-track">
			<?php for ($i = 1; $i <= 4; $i++) : ?>
				<div class="apl-sponsor-tile apl-placeholder"><?php echo esc_html(sprintf(__('Sponsor %d', 'apl-theme'), $i)); ?></div>
			<?php endfor; ?>
		</div>
	</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ($has_rec || $is_preview) : ?>
		<?php if ($rec_count > 0) : ?>
	<div class="apl-rec-grid">
		<?php foreach ($recognitions as $recognition) : ?>
			<?php
            $has_link = !empty($recognition['url']);
            $tag      = $has_link ? 'a' : 'div';
            $attrs    = $has_link ? ' href="' . esc_url($recognition['url']) . '" target="_blank" rel="noopener"' : '';
            ?>
			<<?php echo $tag; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> class="apl-rec-card"<?php echo $attrs; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
				<img src="<?php echo esc_url($recognition['src']); ?>" alt="">
				<?php if (!empty($recognition['caption'])) : ?>
				<div class="apl-rec-caption"><?php echo esc_html($recognition['caption']); ?></div>
				<?php endif; ?>
			</<?php echo $tag; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
		<?php endforeach; ?>
	</div>
		<?php elseif ($is_preview) : ?>
	<div class="apl-rec-grid">
		<?php for ($i = 1; $i <= 2; $i++) : ?>
			<div class="apl-rec-card apl-placeholder"><?php echo esc_html(sprintf(__('Recognition %d', 'apl-theme'), $i)); ?></div>
		<?php endfor; ?>
	</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ($has_opt) : ?>
	<div class="apl-mini-grid">
		<div class="apl-opt-grid">
			<?php foreach ($opt_cards as $card) : ?>
				<div class="apl-opt-card<?php echo !empty($card['placeholder']) ? ' apl-placeholder' : ''; ?>">
					<h6><?php echo esc_html($card['title']); ?></h6>
					<p><?php echo esc_html($card['body']); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php endif; ?>
</div>
