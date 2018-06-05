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
  use Kuuzu\KU\Core\Site\Shop\Reviews;

  $Qreviews = Reviews::getEntry($_GET['View']);
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
?>

<p><?php echo HTML::image(KUUZU::getPublicSiteLink('images/stars_' . $Qreviews->valueInt('reviews_rating') . '.png'), sprintf(KUUZU::getDef('rating_of_5_stars'), $Qreviews->valueInt('reviews_rating'))) . '&nbsp;' . sprintf(KUUZU::getDef('reviewed_by'), $Qreviews->valueProtected('customers_name')) . '; ' . DateTime::getLong($Qreviews->value('date_added')); ?></p>

<p><?php echo nl2br(wordwrap($Qreviews->valueProtected('reviews_text'), 60, '&shy;')); ?></p>

<div class="submitFormButtons">
  <span style="float: right;"><?php echo HTML::button(array('href' => KUUZU::getLink(null, null, 'Reviews&Write&' . $KUUZU_Product->getKeyword()), 'icon' => 'pencil', 'title' => KUUZU::getDef('button_write_review'))); ?></span>

  <?php echo HTML::button(array('href' => KUUZU::getLink(null, null, 'Reviews&' . $KUUZU_Product->getKeyword()), 'icon' => 'triangle-1-w', 'title' => KUUZU::getDef('button_back'))); ?>
</div>
