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
?>

<h1 style="float: right;"><?php echo $KUUZU_Product->getPriceFormated(true); ?></h1>

<h1><?php echo $KUUZU_Template->getPageTitle() . ($KUUZU_Product->hasModel() ? '<br /><span class="smallText">' . $KUUZU_Product->getModel() . '</span>' : ''); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists('Reviews') ) {
    echo $KUUZU_MessageStack->get('Reviews');
  }

  if ( $KUUZU_Product->hasImage() ) {
?>

<div style="float: right; text-align: center;">
  <?php echo HTML::link(KUUZU::getLink(null, null, 'Images&' . $KUUZU_Product->getKeyword()), $KUUZU_Image->show($KUUZU_Product->getImage(), $KUUZU_Product->getTitle(), 'hspace="5" vspace="5"', 'thumbnail'), 'target="_blank" onclick="window.open(\'' . KUUZU::getLink(null, null, 'Images&' . $KUUZU_Product->getKeyword()) . '\', \'popUp\', \'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=' . (($KUUZU_Product->numberOfImages() > 1) ? $KUUZU_Image->getWidth('large') + ($KUUZU_Image->getWidth('thumbnails') * 2) + 70 : $KUUZU_Image->getWidth('large') + 20) . ',height=' . ($KUUZU_Image->getHeight('large') + 20) . '\'); return false;"'); ?>
  <?php echo '<p>' . HTML::button(array('href' => KUUZU::getLink(null, 'Cart', 'Add&' . $KUUZU_Product->getKeyword()), 'icon' => 'cart', 'title' => KUUZU::getDef('button_add_to_cart'))) . '</p>'; ?>
</div>

<?php
  }

  if ( $KUUZU_Product->getData('reviews_average_rating') > 0 ) {
?>

<p><?php echo KUUZU::getDef('average_rating') . ' ' . HTML::image(KUUZU::getPublicSiteLink('images/stars_' . $KUUZU_Product->getData('reviews_average_rating') . '.png'), sprintf(KUUZU::getDef('rating_of_5_stars'), $KUUZU_Product->getData('reviews_average_rating'))); ?></p>

<?php
  }

  $counter = 0;

  $reviews_listing = Reviews::getListing($KUUZU_Product->getID());

  foreach ( $reviews_listing['entries'] as $r ) {
    $counter++;

    if ( $counter > 1 ) {
?>

<hr style="height: 1px; width: 150px; text-align: left; margin-left: 0px" />

<?php
    }
?>

<p><?php echo HTML::image(KUUZU::getPublicSiteLink('images/stars_' . (int)$r['reviews_rating'] . '.png'), sprintf(KUUZU::getDef('rating_of_5_stars'), (int)$r['reviews_rating'])) . '&nbsp;' . sprintf(KUUZU::getDef('reviewed_by'), HTML::outputProtected($r['customers_name'])) . '; ' . DateTime::getLong($r['date_added']); ?></p>

<p><?php echo nl2br(wordwrap(HTML::outputProtected($r['reviews_text']), 60, '&shy;')); ?></p>

<?php
  }
?>

<div class="listingPageLinks">
  <span style="float: right;"><?php echo PDO::getBatchPageLinks('page', $reviews_listing['total'], KUUZU::getAllGET('page')); ?></span>

  <?php echo PDO::getBatchTotalPages(KUUZU::getDef('result_set_number_of_reviews'), (isset($_GET['page']) ? $_GET['page'] : 1), $reviews_listing['total']); ?>
</div>

<div class="submitFormButtons">
  <span style="float: right;"><?php echo HTML::button(array('href' => KUUZU::getLink(null, null, 'Reviews&Write&' . $KUUZU_Product->getKeyword()), 'icon' => 'pencil', 'title' => KUUZU::getDef('button_write_review'))); ?></span>

  <?php echo HTML::button(array('href' => KUUZU::getLink(null, null, $KUUZU_Product->getKeyword()), 'icon' => 'triangle-1-w', 'title' => KUUZU::getDef('button_back'))); ?>
</div>
