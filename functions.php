<?php
defined('ABSPATH') || exit;

// Placeholder image id constant
define('PLACEHOLDER_IMAGE_ID', 41);
define('GPW_TEXT_DOMAIN', 'gpw');
define('GPW_CURRENT_LANGUAGE', function_exists('pll_current_language') ? pll_current_language() : 'en');
define('GPW_DATE_FORMAT', GPW_CURRENT_LANGUAGE === 'en' ? 'F j, Y' : 'j F, Y');

// Turn off auto gen <p> of contact form 7
add_filter('wpcf7_autop_or_not', function() {
  return false;
});

// Load autoload
if(file_exists(__DIR__ . '/vendor/autoload.php')) {
  require_once __DIR__ . '/vendor/autoload.php';
}

// Register services
if(class_exists('gpweb\\inc\\ThemeInit')) {
  gpweb\inc\ThemeInit::register_services();
}