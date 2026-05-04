<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Header hotline shortcode
 */
namespace gpweb\shortcodes;
class HeaderHotline extends BaseShortcode {
  protected function getPhone() {
    $companyInfo = \gpweb\inc\controller\CompanyInfo::getInstance();
    return $companyInfo->getPhoneNumber();
  }
  public function shortcodeCallback(array $atts, $content = null) {
    $tel = $this->getPhone();
    if( !$tel ) {
      return '';
    }
    return sprintf('<a class="header__hotline-btn" href="tel:%s"><span class="material-symbols-outlined">phone_in_talk</span><span class="header__hotline-btn-text">%s</span><span class="header__hotline-btn-phone">%s</span></a>', $tel, __('Have a question?', 'gpw'), $tel);
  }
}