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

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;

  if ( $KUUZU_NavigationHistory->hasSnapshot() ) {
    $origin_href = $KUUZU_NavigationHistory->getSnapshotURL();
    $KUUZU_NavigationHistory->resetSnapshot();
  } else {
    $origin_href = KUUZU::getLink(null, KUUZU::getDefaultSiteApplication());
  }
?>

<h1><?php echo $KUUZU_Template->getPageTitle(); ?></h1>

<div>
  <div style="padding-top: 30px;">
    <p><?php echo sprintf(KUUZU::getDef('success_account_created'), KUUZU::getLink(null, 'Info', 'Contact')); ?></p>
  </div>
</div>

<div class="submitFormButtons" style="text-align: right;">
  <?php echo HTML::button(array('href' => $origin_href, 'icon' => 'triangle-1-e', 'title' => KUUZU::getDef('button_continue'))); ?>
</div>
