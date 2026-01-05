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

  /**
   * Registers the necessary actions and filters.
   */
  public function register()
  {
    add_action('wp_enqueue_scripts', [$this, 'enqueue']);
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
    <script id="fb-root-script" async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v24.0&appId=APP_ID"></script>
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
    $this->enqueueScript('aos', null, '', [], false);
    $this->enqueueStyle('aos', null);

    $this->enqueueStyle('theme-init', time());
    $this->enqueueStyle('google-symbols', null, 'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200');

    $this->enqueueStyle('gpw-header', time());
    $this->enqueueStyle('gpw-footer', time());

    // * Enqueue swiper for page that needs it
    if (is_front_page()) {
      $this->enqueueScript('swiper');
      $this->enqueueStyle('swiper');
    }

    if (is_front_page()) {
      $this->enqueueScript('gpw-home-page', time());
      $this->enqueueStyle('gpw-home-page', time());
    }

    if( is_home() || is_category() ) {
      $postController = \gpweb\inc\controller\PostController::getInstance();
      $action = $postController->getAction();
      $this->enqueueScript('gpw-post-category-page', time());
      $this->enqueueStyle('gpw-post-category-page', time());
      wp_localize_script( 'gpw-post-category-page', 'gpwObject', [
        'url' => admin_url( 'admin-ajax.php' ),
        'action' => $action,
        'nonce' => wp_create_nonce( $action ),
      ]);

      unset( $action, $postController );
    }
  }

  /**
   ** Enqueue single script 
   */
  protected function enqueueScript(string $script_name, ?string $version = null, string $url = '', array $dependencies = [], bool $in_footer = true)
  {
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