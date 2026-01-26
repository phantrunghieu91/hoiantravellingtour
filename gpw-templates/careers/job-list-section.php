<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Career page - Job list section
 */
define('JOBS_PER_PAGE', gpweb\inc\controller\CareerController::JOBS_PER_PAGE);
const PAGED = 1;
$jobPositions = get_terms([
  'taxonomy' => 'job-position',
  'hide_empty' => false,
]);
$workLocations = get_terms([
  'taxonomy' => 'work-location',
  'hide_empty' => false,
]);
$jobArgs = [
  'post_type' => 'career',
  'post_status' => 'publish',
  'posts_per_page' => JOBS_PER_PAGE,
  'paged' => PAGED,
];
$jobsQuery = new WP_Query($jobArgs);
?>
<section class="job-list">
  <div class="section__inner">
    <header class="job-list__header">
      <form method="POST" class="job-list__search-form job-search">
        <div class="job-search__message" aria-hidden="true"></div>
        <div class="job-search__group">
          <input type="text" name="keyword" placeholder="<?php esc_attr_e('Job', GPW_TEXT_DOMAIN) ?>" class="job-search__form-control" />
        </div>
        <div class="job-search__group">
          <select name="job-position" class="job-search__form-control">
            <option value=""><?php esc_html_e('Choose job position', GPW_TEXT_DOMAIN) ?></option>
            <?php foreach( $jobPositions as $position ) {
              echo sprintf('<option value="%s">%s</option>',
                esc_attr( $position->term_id ),
                esc_html( $position->name )
              );
            } ?>
          </select>
        </div>
        <div class="job-search__group">
          <select name="work-location" class="job-search__form-control">
            <option value=""><?php esc_html_e('Choose work location', GPW_TEXT_DOMAIN) ?></option>
            <?php foreach( $workLocations as $location ) {
              echo sprintf('<option value="%s">%s</option>',
                esc_attr( $location->term_id ),
                esc_html( $location->name )
              );
            } ?>
          </select>
        </div>
        <?php get_template_part( 'gpw-templates/global/gpw-button', null, [
          'tag' => 'button',
          'type' => 'submit',
          'label' => 'Search',
          'has_icon' => true,
          'style' => 'secondary',
          'icon_code' => 'search',
          'icon_position' => 'left',
          'class' => 'job-search__submit-btn',
        ] ) ?>
      </form>
    </header>
    <main class="job-list__main">
      
      <?php if( !$jobsQuery->have_posts() ): ?>

        <p class="job-list__no-results-message"><?php esc_html_e('No job openings found.', GPW_TEXT_DOMAIN) ?></p>

      <?php else: ?>
        <h2 class="section__title"><?php esc_html_e('Jobs', GPW_TEXT_DOMAIN) ?></h2>

        <ul class="job-list__items">

          <?php while( $jobsQuery->have_posts() ): $jobsQuery->the_post();
            $jobID = get_the_ID();
            $title = get_the_title();
            $permalink = get_permalink();
            $locationTerms = get_the_terms( get_the_ID(), 'work-location' );
            $locationName = !empty( $locationTerms ) && !is_wp_error( $locationTerms ) ? $locationTerms[0]->name : false;
            $quantity = get_field( 'quantity', $jobID );
            $deadline = get_field( 'application_deadline', $jobID );
            $deadline = DateTime::createFromFormat('d/m/Y', $deadline )->format('F j, Y');
          ?>

            <li class="job-list__item">
              <h3 class="job-list__item-title"><a href="<?= $permalink ?>"></a><?= esc_html( $title ) ?></h3>
              <ul class="job-list__item-meta-list">
                <?php if( !empty( $quantity )): ?>
                  <li class="job-list__item-meta quantity">
                    <span class="job-list__item-meta-label"><?php esc_html_e('Quantity', GPW_TEXT_DOMAIN) ?></span>
                    <span class="job-list__item-meta-value"><?= esc_html( $quantity ) ?></span>
                  </li>
                <?php endif; ?>
                <?php if( $locationName ): ?>
                  <li class="job-list__item-meta location">
                    <span class="job-list__item-meta-label"><?php esc_html_e('Location', GPW_TEXT_DOMAIN) ?></span>
                    <span class="job-list__item-meta-value"><?= esc_html( $locationName ) ?></span>
                  </li>
                <?php endif; ?>
                <?php if( !empty( $deadline )): ?>
                  <li class="job-list__item-meta deadline">
                    <span class="job-list__item-meta-label"><?php esc_html_e('Application Deadline', GPW_TEXT_DOMAIN) ?></span>
                    <span class="job-list__item-meta-value"><?= esc_html( $deadline ) ?></span>
                  </li>
                <?php endif; ?>
              </ul>
              <a href="<?= $permalink ?>" class="job-list__item-view-detail">
                <span><?php esc_html_e('View detail', GPW_TEXT_DOMAIN) ?></span>
                <span class="material-symbols-outlined">arrow_forward</span>
              </a>
            </li>

          <?php endwhile; wp_reset_postdata(); ?>

        </ul>

      <?php endif ?>

    </main>
    <?php if( $jobsQuery->max_num_pages > 1 ): ?>

      <footer class="job-list__footer" aria-hidden="false">

        <ul class="job-list__pagination" data-max-pages="<?= esc_attr( $jobsQuery->max_num_pages ) ?>">

          <li class="job-list__pagination-item job-list__pagination-item--disabled" data-page="prev">
            <span class="material-symbols-outlined">chevron_left</span>
          </li>
          <?php for( $i = 1; $i <= $jobsQuery->max_num_pages; $i++ ){
            $isActive = $i === PAGED;
            echo sprintf('<li class="job-list__pagination-item%s" data-page="%d"><span>%d</span></li>',
              $isActive ? ' job-list__pagination-item--active' : '',
              $i,
              $i
            );
          } ?>
          <li class="job-list__pagination-item" data-page="next"> 
            <span class="material-symbols-outlined">chevron_right</span>
          </li>

        </ul>

      </footer>

    <?php endif ?>
    <template id="job-item-template">
      <li class="job-list__item">
        <h3 class="job-list__item-title"><a href=""></a></h3>
        <ul class="job-list__item-meta-list">
          <li class="job-list__item-meta quantity">
            <span class="job-list__item-meta-label"><?php esc_html_e('Quantity', GPW_TEXT_DOMAIN) ?></span>
            <span class="job-list__item-meta-value"></span>
          </li>
          <li class="job-list__item-meta location">
            <span class="job-list__item-meta-label"><?php esc_html_e('Location', GPW_TEXT_DOMAIN) ?></span>
            <span class="job-list__item-meta-value"></span>
          </li>
          <li class="job-list__item-meta deadline">
            <span class="job-list__item-meta-label"><?php esc_html_e('Application Deadline', GPW_TEXT_DOMAIN) ?></span>
            <span class="job-list__item-meta-value"></span>
          </li>
        </ul>
        <a href="" class="job-list__item-view-detail">
          <span><?php esc_html_e('View detail', GPW_TEXT_DOMAIN) ?></span>
          <span class="material-symbols-outlined">arrow_forward</span>
        </a>
      </li>
    </template>
  </div>
</section>