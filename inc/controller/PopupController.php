<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Popup controller
 */
namespace gpweb\inc\controller;
class PopupController {
  private static PopupController $instance;
  public static function getInstance(): PopupController {
    if( !isset( self::$instance ) ) {
      self::$instance = new PopupController();
    }
    return self::$instance;
  }
  public function register() {
    add_action( 'wp_footer', [ $this, 'addPopupToPage'] );
    add_action('wp_enqueue_scripts', [ $this, 'internalScriptForPopup'] );
  }
  public function addPopupToPage() {
    get_template_part( 'gpw-templates/global/pop-up-block' );
  }
  public function internalScriptForPopup() {
    $script = <<<JS
    document.addEventListener('DOMContentLoaded', event => {
      console.log('POPUP');
      const SEASON_KEY = 'popup_showed';
      const isPopupShowedBefore = sessionStorage.getItem( SEASON_KEY ) ?? false;
      if( isPopupShowedBefore ) return;
      const popupTO = setTimeout(() => {
        const popup = document.querySelector('.jins-popup');
        if( !popup ) return;
        popup.showPopover();
        sessionStorage.setItem( SEASON_KEY, true );
      }, 1 * 1_000);
    });
    JS;
    wp_add_inline_script( 'jquery', $script, 'after' );

    $style = <<<CSS
    html:has(.jins-popup:popover-open) {
      overflow: hidden;
    }
    .jins-popup {
      padding-inline: clamp(1.25rem, 3vw, 1.875rem);
      padding-block: clamp(1.875rem, 4vw, 2.5rem);
      width: min(37.5rem, 80%);
      display: none;
      border-radius: .5rem;
      border: 0;

      translate: 0 50px;
      opacity: 0;

      transition-property: display, overlay, opacity, translate;
      transition-duration: 300ms;
      transition-behavior: allow-discrete;
    }
    .jins-popup:popover-open {
      display: block;
      opacity: 1;
      translate: 0 0px;
    }
    @starting-style {
      .jins-popup:popover-open {
        opacity: 0;
        translate: 0 -50px;
      }
    }
    .jins-popup__close-btn {
      margin: 0;
      padding: 0;
      position: absolute;
      top: .625rem;
      right: .625rem;
    }
    .jins-popup__close-btn .material-symbols-outlined {
      font-size: 2.5rem;
      transition: rotate 250ms;
      
      &:hover {
        rotate: 90deg;
      }
    }
    .jins-popup::backdrop {
      background-color: oklch( 0 0 0 / .65 );
    }
    .jins-popup__title {
      margin-block-end: 1.875rem;
      text-align: center;
      color: var(--primary-color-500);
    }
    .jins-popup .wpcf7-form {
      margin-block-end: 0;
    }
    .jins-popup button.gpw-button {
      margin-inline: auto;
    }
    CSS;
    wp_add_inline_style( 'gpw-footer', $style );
  }
}