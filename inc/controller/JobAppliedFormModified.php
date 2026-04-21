<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Controller for the job applied form section on the career page.
 */
namespace gpweb\inc\controller;
class JobAppliedFormModified
{
  private static $instance = null;
  public static function getInstance()
  {
    if (self::$instance == null) {
      self::$instance = new JobAppliedFormModified();
    }
    return self::$instance;
  }
  public function register()
  {
    add_action('wp', [$this, 'addJobTitleToForm']);
  }
  public function addJobTitleToForm()
  {
    if( !is_singular( 'career' ) ) {
      return;
    }
    add_filter('wpcf7_form_tag', function( $tags ) {
      if( $tags['name'] !== 'position-applied-for' ) {
        return $tags;
      }
      $tags['options'] = ['readonly'];
      $tags['raw_values'] = [ get_the_title() ];
      $tags['values'] = [ get_the_title() ];

      return $tags;
    });
  }
}