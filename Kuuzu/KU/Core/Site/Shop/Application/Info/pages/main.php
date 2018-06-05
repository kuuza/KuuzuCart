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
?>

<h1><?php echo $KUUZU_Template->getPageTitle(); ?></h1>

<div class="moduleBox">
  <h6><?php echo KUUZU::getDef('information_title'); ?></h6>

  <div class="content">
    <ul style="padding-left: 50px;">
      <li><?php echo HTML::link(KUUZU::getLink(null, null, 'Shipping'), KUUZU::getDef('box_information_shipping')); ?></li>
      <li><?php echo HTML::link(KUUZU::getLink(null, null, 'Privacy'), KUUZU::getDef('box_information_privacy')); ?></li>
      <li><?php echo HTML::link(KUUZU::getLink(null, null, 'Conditions'), KUUZU::getDef('box_information_conditions')); ?></li>
      <li><?php echo HTML::link(KUUZU::getLink(null, null, 'Contact'), KUUZU::getDef('box_information_contact')); ?></li>
      <li><?php echo HTML::link(KUUZU::getLink(null, null, 'Sitemap'), KUUZU::getDef('box_information_sitemap')); ?></li>
    </ul>

    <div style="clear: both;"></div>
  </div>
</div>
