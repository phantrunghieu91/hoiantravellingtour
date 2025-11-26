<?php 
/**
 * @author Hieu "JIN" Phan Trung
 * * Controller: Company Information
 */
namespace gpweb\inc\controller;
class CompanyInfo {
  private static CompanyInfo $instance;
  private array $office;
  private string $email;
  private string $phone;
  private array $socials;
  private string $facebookEmbed;
  private string $mainOfficeMap;
  public static function getInstance(): CompanyInfo {
    if( !isset( self::$instance ) ) {
      self::$instance = new CompanyInfo();
    }
    return self::$instance;
  }
  public function register() {
    if( !function_exists('get_field') ) {
      error_log('ACF function get_field does not exist. CompanyInfo controller cannot be initialized.');
      return;
    }
    $companyInfo = get_field('company_information', 'gpw_settings');
    $this->office = $companyInfo['office'] ?? [];
    $this->email = $companyInfo['email'] ?? '';
    $this->phone = $companyInfo['phone_number'] ?? '';
    $this->socials = $companyInfo['social'] ?? [];
    $this->facebookEmbed = $companyInfo['facebook_embed'] ?? '';
    $this->mainOfficeMap = $companyInfo['main_office_map_embed'] ?? '';
  }
  public function getOffice(): array {
    return $this->office;
  }
  public function getPhoneNumber(): string {
    return $this->phone;
  }
  public function getEmail(): string {
    return $this->email;
  }
  public function getSocials(): array {
    return $this->socials;
  }
  public function getFacebookEmbed(): string {
    return $this->facebookEmbed;
  }
  public function getMainOfficeMap(): string {
    return $this->mainOfficeMap;
  }
  public function getDefaultLogo() {
    $logoID = get_theme_mod( 'site_logo', get_template_directory_uri() . '/assets/img/logo.png' );
    return $logoID;
  }
}