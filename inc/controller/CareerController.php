<?php
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Career Controller
 */
namespace gpweb\inc\controller;
class CareerController
{
  private static CareerController $instance;
  private string $action = 'search_careers';
  public const JOBS_PER_PAGE = 4;
  public static function getInstance(): CareerController
  {
    if (!isset(self::$instance)) {
      self::$instance = new CareerController();
    }
    return self::$instance;
  }
  public function register()
  {
    add_action("wp_ajax_nopriv_{$this->action}", [$this, 'handleSearchCareers']);
    add_action("wp_ajax_{$this->action}", [$this, 'handleSearchCareers']);
  }
  public function handleSearchCareers()
  {
    if (!check_ajax_referer($this->action, 'nonce', false)) {
      wp_send_json_error(['code' => 'INVALID_NONCE']);
      wp_die();
    }
    $keyword = isset($_POST['keyword']) ? sanitize_text_field(wp_unslash($_POST['keyword'])) : '';
    $jobPosition = isset($_POST['job-position']) ? intval($_POST['job-position']) : 0;
    $workLocation = isset($_POST['work-location']) ? intval($_POST['work-location']) : 0;
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $args = [
      'post_type' => 'career',
      'post_status' => 'publish',
      'posts_per_page' => self::JOBS_PER_PAGE,
      'paged' => $page,
    ];
    if (!empty($keyword)) {
      $args['s'] = $keyword;
    }
    if ($jobPosition > 0 || $workLocation > 0) {
      $taxQuery = ['relation' => 'AND'];
      if ($jobPosition > 0) {
        $taxQuery[] = [
          'taxonomy' => 'job-position',
          'field' => 'term_id',
          'terms' => $jobPosition,
        ];
      }
      if ($workLocation > 0) {
        $taxQuery[] = [
          'taxonomy' => 'work-location',
          'field' => 'term_id',
          'terms' => $workLocation,
        ];
      }
      $args['tax_query'] = $taxQuery;
    }
    $jobsQuery = new \WP_Query($args);
    if (!$jobsQuery->have_posts()) {
      wp_send_json_error(['code' => 'NO_JOBS_FOUND']);
      wp_die();
    }

    $responseData = [
      'max_pages' => $jobsQuery->max_num_pages,
      'found_jobs' => $jobsQuery->found_posts,
      'jobs' => [],
    ];
    while ($jobsQuery->have_posts()) {
      $jobsQuery->the_post();
      $jobID = get_the_ID();
      $title = get_the_title();
      $permalink = get_permalink();
      $locationTerms = get_the_terms($jobID, 'work-location');
      $locationName = !empty($locationTerms) && !is_wp_error($locationTerms) ? $locationTerms[0]->name : false;
      $quantity = get_field('quantity', $jobID);
      $deadline = get_field('application_deadline', $jobID);
      $deadline = \DateTime::createFromFormat('d/m/Y', $deadline)->format('F j, Y');
      $responseData[ 'jobs' ][] = [
        'id' => $jobID,
        'title' => $title,
        'permalink' => $permalink,
        'location' => $locationName,
        'quantity' => $quantity,
        'deadline' => $deadline,
      ];
    }
    wp_send_json_success($responseData);
    wp_die();
  }
  public function getAction(): string
  {
    return $this->action;
  }
}