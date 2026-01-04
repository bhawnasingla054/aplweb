<?php
/**
 * Product overview CMS block.
 *
 * @package APL Theme
 */

$is_preview    = is_customize_preview();
$media_type    = apl_get_theme_mod('apl_home_product_media_type', 'image');

// Get media URL (prefer attachment ID, fallback to external URL)
$media_url = '';
if ('image' === $media_type) {
	$image_id = apl_get_theme_mod('apl_home_product_image_id', 0);
	if ($image_id) {
		$media_url = wp_get_attachment_url($image_id);
	}
} else {
	$video_id = apl_get_theme_mod('apl_home_product_video_id', 0);
	if ($video_id) {
		$media_url = wp_get_attachment_url($video_id);
	}
}

// Fallback to external URL if no attachment
if (!$media_url) {
	$media_url = apl_get_theme_mod('apl_home_product_media_url', '');
}

$media_alt     = apl_get_theme_mod('apl_home_product_media_alt', '');

// Get poster URL (prefer attachment ID)
$poster_url = '';
$poster_id = apl_get_theme_mod('apl_home_product_poster_id', 0);
if ($poster_id) {
	$poster_url = wp_get_attachment_url($poster_id);
}

$trusted_title = apl_get_theme_mod('apl_home_trusted_title', 'Trusted by teams everywhere');
$trusted_sub   = apl_get_theme_mod('apl_home_trusted_subtitle', '');

$customer_items = apl_get_repeater_items('apl_home_customers_json');
$logos         = array();

if (!empty($customer_items)) {
	foreach ($customer_items as $item) {
		$src = '';
		if (!empty($item['id'])) {
			$src = wp_get_attachment_image_url(absint($item['id']), 'medium');
		}
		if (!$src && !empty($item['src'])) {
			$src = esc_url($item['src']);
		}

		if ($src) {
			$logos[] = array(
				'src'  => $src,
				'href' => !empty($item['href']) ? esc_url($item['href']) : '',
				'alt'  => !empty($item['alt']) ? sanitize_text_field($item['alt']) : '',
			);
		}
	}
}

$has_media   = !empty($media_url);
$has_trusted = (bool) (trim($trusted_title) || trim($trusted_sub));
$has_logos   = !empty($logos);

if (!$has_media && !$has_trusted && !$has_logos) {
	if (!$is_preview) {
		return;
	}

	?>
	<section class="apl-productcms apl-productcms--placeholder" aria-label="<?php esc_attr_e('Product overview', 'apl-theme'); ?>">
		<div class="apl-productcms-placeholder"><?php esc_html_e('Product Overview (CMS) placeholder', 'apl-theme'); ?></div>
	</section>
	<?php
	return;
}

$media_type = in_array($media_type, array('image', 'video'), true) ? $media_type : 'image';
$logo_count = count($logos);
// Always use marquee/carousel if there are logos
$logo_duplicate = $logo_count > 0;
?>
<section class="apl-productcms apl-product-overview" aria-label="<?php esc_attr_e('Product overview', 'apl-theme'); ?>">
	<div class="apl-productcms-inner">
		<?php if ($has_media || ($is_preview && !$has_media)) : ?>
			<div class="apl-productcms-media">
				<?php if ($has_media) : ?>
					<?php if ('video' === $media_type) : ?>
						<video class="apl-productcms-video" autoplay muted loop playsinline preload="metadata"<?php if ($poster_url) : ?> poster="<?php echo esc_url($poster_url); ?>"<?php endif; ?>>
							<source src="<?php echo esc_url($media_url); ?>" type="video/mp4">
						</video>
					<?php else : ?>
						<img src="<?php echo esc_url($media_url); ?>" alt="<?php echo esc_attr($media_alt); ?>" loading="lazy">
					<?php endif; ?>
				<?php elseif ($is_preview) : ?>
					<div class="apl-productcms-placeholder"><?php esc_html_e('Add product media URL', 'apl-theme'); ?></div>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ($has_trusted || $has_logos || $is_preview) : ?>
			<div class="apl-productcms-content">
				<?php if ($has_trusted || $is_preview) : ?>
					<div class="apl-productcms-text">
						<?php if ($has_trusted || $is_preview) : ?>
							<h3><?php echo esc_html($trusted_title); ?></h3>
						<?php endif; ?>
						<?php if ($trusted_sub || $is_preview) : ?>
							<p><?php echo esc_html($trusted_sub); ?></p>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if ($has_logos) : ?>
					<?php if ($logo_duplicate) : ?>
						<div class="apl-productcms-marquee" data-animate="1">
							<div class="apl-productcms-marquee-track">
								<?php for ($loop = 0; $loop < 3; $loop++) : ?>
									<?php foreach ($logos as $logo) : ?>
										<?php
										$tile  = '<div class="apl-productcms-logo"><img src="' . esc_url($logo['src']) . '" alt="' . esc_attr($logo['alt']) . '"></div>';
										$link  = !empty($logo['href']) ? '<a class="apl-productcms-logo-link" href="' . esc_url($logo['href']) . '" target="_blank" rel="noopener">' . $tile . '</a>' : $tile;
										echo $link; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
										?>
									<?php endforeach; ?>
								<?php endfor; ?>
							</div>
						</div>
					<?php else : ?>
						<div class="apl-productcms-logos">
							<?php foreach ($logos as $logo) : ?>
								<?php
								$tile  = '<div class="apl-productcms-logo"><img src="' . esc_url($logo['src']) . '" alt="' . esc_attr($logo['alt']) . '"></div>';
								$link  = !empty($logo['href']) ? '<a class="apl-productcms-logo-link" href="' . esc_url($logo['href']) . '" target="_blank" rel="noopener">' . $tile . '</a>' : $tile;
								echo $link; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				<?php elseif ($is_preview) : ?>
					<div class="apl-productcms-logos apl-productcms-placeholder">
						<?php esc_html_e('Add customer logos to display this row', 'apl-theme'); ?>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
