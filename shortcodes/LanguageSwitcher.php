<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Shortcode: Language Switcher
 */
namespace gpweb\shortcodes;
class LanguageSwitcher extends BaseShortcode {
  public function shortcodeCallback(array $atts, $content = null) {
    if( !function_exists( 'pll_the_languages' ) ) {
      return '';
    }
    $args = [
      'display_names_as' => 'slug',
      'show_flags' => '1',
      'echo' => '0',
    ];
    return sprintf('<ul class="gpw-lang-switcher">%s</ul>', pll_the_languages( $args ));
  }
}