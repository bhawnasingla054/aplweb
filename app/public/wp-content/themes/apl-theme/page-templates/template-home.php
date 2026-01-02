<?php
/**
 * Template Name: Home (Fixed)
 *
 * Loads the existing front-page layout so this page stays isolated
 * from other page templates.
 *
 * @package APL_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

$front_page = locate_template('front-page.php');

if ($front_page) {
    include $front_page;
}
