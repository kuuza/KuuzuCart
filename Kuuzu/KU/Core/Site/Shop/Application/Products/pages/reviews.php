<?php
/**
 * Kuuzu Cart
 * 
 * @copyright (c) 2007 - 2017 osCommerce; http://www.oscommerce.com
 * @license BSD License; http://www.oscommerce.com/bsdlicense.txt
 *
 * @copyright Copyright c 2018 Kuuzu; https://kuuzu.org
 * @license MIT License; https://kuuzu.org/mitlicense.txt
 */

  use Kuuzu\KU\Core\DateTime;
  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\PDO;
  use Kuuzu\KU\Core\Site\Shop\Reviews;

  $reviews_listing = Reviews::getListing();
?>

<h1><?php echo $KUUZU_Template->getPageTitle(); ?></h1>

<?php
  foreach ( $reviews_listing['entries'] as $r ) {
?>

<div class="moduleBox">
  <div style="float: right; margin-top: 5px;"><?php echo sprintf(KUUZU::getDef('review_date_added'), DateTime::getLong($r['date_added'])); ?></div>

  <h6><?php echo HTML::link(KUUZU::getLink(null, 'Products', 'Reviews&View=' . $r['reviews_id'] . '&' . $r['products_keyword']), $r['products_name']); ?> (<?php echo sprintf(KUUZU::getDef('reviewed_by'), HTML::outputProtected($r['customers_name'])); ?>)</h6>

  <div class="content">

<?php
    if ( !empty($r['image']) ) {
      echo HTML::link(KUUZU::getLink(null, 'Products', 'Reviews&View=' . $r['reviews_id'] . '&' . $r['products_keyword']), $KUUZU_Image->show($r['image'], $r['products_name'], 'style="float: left;"'));
    }
?>

    <p style="padding-left: 100px;"><?php echo wordwrap(HTML::outputProtected($r['reviews_text']), 60, '&shy;') . ((strlen(HTML::outputProtected($r['reviews_text'])) >= 100) ? '..' : '') . '<br /><br /><i>' . sprintf(KUUZU::getDef('review_rating'), HTML::image(KUUZU::getPublicSiteLink('images/stars_' . (int)$r['reviews_rating'] . '.png'), sprintf(KUUZU::getDef('rating_of_5_stars'), (int)$r['reviews_rating'])), sprintf(KUUZU::getDef('rating_of_5_stars'), (int)$r['reviews_rating'])) . '</i>'; ?></p>

    <div style="clear: both;"></div>
  </div>
</div>

<?php
  }
?>

<div class="listingPageLinks">
  <span style="float: right;"><?php echo PDO::getBatchPageLinks('page', $reviews_listing['total'], KUUZU::getAllGET('page')); ?></span>

  <?php echo PDO::getBatchTotalPages(KUUZU::getDef('result_set_number_of_reviews'), (isset($_GET['page']) ? $_GET['page'] : 1), $reviews_listing['total']); ?>
</div>
