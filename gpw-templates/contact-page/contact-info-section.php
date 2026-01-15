<?php 
/**
 * @author Hieu "Jin" Phan Trung
 * * Template: Contact Page - Contact information section
 */
$companyInfo = gpweb\inc\controller\CompanyInfo::getInstance();
$email = $companyInfo->getEmail();
$phoneNumber = $companyInfo->getPhoneNumber();
$offices = $companyInfo->getOffice();
$address = $offices[0]['address'] ?? '';
$items = [
  ['icon' => 'location_on', 'content' => esc_html($address)],
  ['icon' => 'email', 'content' => sprintf('<a href="mailto:%s">%s</a>', $email, $email)],
  ['icon' => 'call', 'content' => sprintf('<a href="tel:%s">%s</a>', $phoneNumber, $phoneNumber)],
]
?>
<section class="company-info">
  <div class="section__inner">

    <?php foreach( $items as $item ): ?>
      <article class="company-info__item">
        <div class="company-info__item-icon">
          <span class="material-symbols-outlined"><?= $item['icon'] ?></span>
        </div>
        <div class="company-info__item-content"><?= $item['content'] ?></div>
      </article>
    <?php endforeach ?>

  </div>
</section>
<?php 
// ! Cleanup variables
unset( $companyInfo, $address, $email, $phoneNumber, $offices );