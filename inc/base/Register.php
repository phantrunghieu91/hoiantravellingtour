<?php
/**
 * @author Hieu "Jin" Phan Trung
 ** The Register class handles the registration of scripts, styles, and shortcodes for the theme.
 */

namespace gpweb\inc\base;

class Register extends BaseController
{
  /**
   ** An array of shortcodes.
   * @var array
   */
  protected $shortcodes;
  protected $module_scripts = [];

  /**
   * Registers the necessary actions and filters.
   */
  public function register()
  {
    add_action('wp_enqueue_scripts', [$this, 'enqueue']);
    add_action('wp_enqueue_scripts', [$this, 'setTypeForModuleScripts']);
    // Add AOS init script in the header
    add_action('wp_footer', function () {
      echo '<script> AOS.init(); </script>';
    });
    $this->setShortcodes();
    add_action('init', [$this, 'registerShortcodes']);

    // Add Facebook SDK
    add_action('wp_head', [$this, 'addFacebookSDK']);
  }

  public function addFacebookSDK()
  {
    ?>
    <div id="fb-root"></div>
    <script id="fb-root-script" async defer crossorigin="anonymous"
      src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v24.0&appId=APP_ID"></script>
    <?php
  }

  /**
   * Sets the shortcodes.
   */
  protected function setShortcodes()
  {
    $this->shortcodes = [
      new \gpweb\shortcodes\ImgById('img_by_id'),
      new \gpweb\shortcodes\LinkTo('link_to'),
      new \gpweb\shortcodes\CertificateList('certificate_list_sc'),
    ];
  }

  /**
   * Enqueues the necessary scripts and styles.
   */
  public function enqueue()
  {
    $this->enqueueScript('aos', null, false, '', [], false);
    $this->enqueueStyle('aos', null);

    $this->enqueueStyle('theme-init', '1.0.6');
    $this->enqueueStyle('google-symbols', null, 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200');

    $this->enqueueStyle('gpw-header', '1.0.0');
    $this->enqueueStyle('gpw-footer', '1.0.0');

    // * Enqueue swiper for page that needs it
    if (is_front_page() || is_post_type_archive('logistics-solution') || is_singular('logistics-solution') || is_singular('industry') 
      || is_page( [ 508 ])) {
      $this->enqueueScript('swiper');
      $this->enqueueStyle('swiper');
    }

    if (is_front_page()) {
      $this->enqueueScript('gpw-home-page', time(), true); // 1.0.1
      $this->enqueueStyle('gpw-home-page', time()); // 1.0.4
    }

    if (is_home() || is_category()) {
      $postController = \gpweb\inc\controller\PostController::getInstance();
      $action = $postController->getAction();
      $this->enqueueScript('gpw-post-category-page', '1.0.0');
      $this->enqueueStyle('gpw-post-category-page', '1.0.0');
      wp_localize_script('gpw-post-category-page', 'gpwObject', [
        'url' => admin_url('admin-ajax.php'),
        'action' => $action,
        'nonce' => wp_create_nonce($action),
      ]);

      unset($action, $postController);
    }

    if (is_singular('post')) {
      $this->enqueueStyle('gpw-post-single-page', '1.0.0');
    }

    if ( is_post_type_archive('logistics-solution') || is_singular('logistics-solution') ) {
      $this->enqueueScript('gpw-services-page', '1.0.0', true);
      $this->enqueueStyle('gpw-services-page', '1.0.6');
    }

    if( is_singular('industry') ) {
      $this->enqueueScript('gpw-industry-single-page', '1.0.0', true);
      $this->enqueueStyle('gpw-industry-single-page', '1.0.3');
    }

    if( is_page( [14] ) ) {
      $this->enqueueStyle('gpw-contact-page', '1.0.6');
    }

    if( is_page( [13] ) ) {
      $this->enqueueScript('gpw-about-page', '1.0.1', true); // 1.0.1
      $this->enqueueStyle('gpw-about-page', '1.0.6'); // 1.0.4
    }

    if( is_page( [508] ) ) {
      $action = \gpweb\inc\controller\CareerController::getInstance()->getAction();

      $this->enqueueScript('gpw-careers-page', '1.0.0', true);
      $this->enqueueStyle('gpw-careers-page', '1.0.1');
      wp_localize_script('gpw-careers-page', 'ajaxObj', [
        'url' => admin_url('admin-ajax.php'),
        'action' => $action,
        'nonce' => wp_create_nonce($action),
      ]);
    }
  }
  public function setTypeForModuleScripts() {
    if( empty( $this->module_scripts ) ) {
      return;
    }
    add_filter('script_loader_tag', function( $tag, $handle, $src ) {
      if( in_array( $handle, $this->module_scripts ) ) {
        $tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
      }
      return $tag;
    }, 10, 3);
  }

  /**
   ** Enqueue single script 
   */
  protected function enqueueScript(string $script_name, ?string $version = null, bool $is_module = false, string $url = '', array $dependencies = [], bool $in_footer = true)
  {
    if( $is_module ) {
      $this->module_scripts[] = $script_name;
    }
    $url = $url === '' ? "{$this->theme_url}/assets/js/{$script_name}.min.js" : $url;
    wp_enqueue_script($script_name, $url, $dependencies, $version, $in_footer);
  }

  /**
   ** Enqueue single style
   */
  public function enqueueStyle(string $style_name, ?string $version = null, string $url = '', array $dependencies = [], string $media = 'all')
  {
    $url = $url === '' ? "{$this->theme_url}/assets/css/{$style_name}.min.css" : $url;
    wp_enqueue_style($style_name, $url, $dependencies, $version, $media);
  }

  /**
   * * Registers the shortcodes.
   * * Loops through the shortcodes array and registers each shortcode.
   */
  public function registerShortcodes()
  {
    foreach ($this->shortcodes as $shortcode) {
      add_shortcode($shortcode->getShortcodeName(), [$shortcode, 'shortcodeCallback']);
    }
  }
}