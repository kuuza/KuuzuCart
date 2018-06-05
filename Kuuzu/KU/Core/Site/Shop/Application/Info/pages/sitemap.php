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

<div>
  <div style="float: right; width: 49%;">
    <ul>
      <li><?php echo HTML::link(KUUZU::getLink(null, 'Account', null, 'SSL'), KUUZU::getDef('sitemap_account')); ?>
        <ul>
          <li><?php echo HTML::link(KUUZU::getLink(null, 'Account', 'Edit', 'SSL'), KUUZU::getDef('sitemap_account_edit')); ?></li>
          <li><?php echo HTML::link(KUUZU::getLink(null, 'Account', 'AddressBook', 'SSL'), KUUZU::getDef('sitemap_address_book')); ?></li>
          <li><?php echo HTML::link(KUUZU::getLink(null, 'Account', 'Orders', 'SSL'), KUUZU::getDef('sitemap_account_history')); ?></li>
          <li><?php echo HTML::link(KUUZU::getLink(null, 'Account', 'Newsletters', 'SSL'), KUUZU::getDef('sitemap_account_notifications')); ?></li>
        </ul>
      </li>
      <li><?php echo HTML::link(KUUZU::getLink(null, 'Cart', null, 'SSL'), KUUZU::getDef('sitemap_shopping_cart')); ?></li>
      <li><?php echo HTML::link(KUUZU::getLink(null, 'Checkout', null, 'SSL'), KUUZU::getDef('sitemap_checkout_shipping')); ?></li>
      <li><?php echo HTML::link(KUUZU::getLink(null, 'Search'), KUUZU::getDef('sitemap_advanced_search')); ?></li>
      <li><?php echo HTML::link(KUUZU::getLink(null, 'Products', 'New'), KUUZU::getDef('sitemap_products_new')); ?></li>
      <li><?php echo HTML::link(KUUZU::getLink(null, 'Products', 'Specials'), KUUZU::getDef('sitemap_specials')); ?></li>
      <li><?php echo HTML::link(KUUZU::getLink(null, 'Products', 'Reviews'), KUUZU::getDef('sitemap_reviews')); ?></li>
      <li><?php echo HTML::link(KUUZU::getLink(null, 'Info'), KUUZU::getDef('box_information_heading')); ?>
        <ul>
          <li><?php echo HTML::link(KUUZU::getLink(null, 'Info', 'Shipping'), KUUZU::getDef('box_information_shipping')); ?></li>
          <li><?php echo HTML::link(KUUZU::getLink(null, 'Info', 'Privacy'), KUUZU::getDef('box_information_privacy')); ?></li>
          <li><?php echo HTML::link(KUUZU::getLink(null, 'Info', 'Conditions'), KUUZU::getDef('box_information_conditions')); ?></li>
          <li><?php echo HTML::link(KUUZU::getLink(null, 'Info', 'Contact'), KUUZU::getDef('box_information_contact')); ?></li>
        </ul>
      </li>
    </ul>
  </div>

  <div style="width: 49%;">
    <?php echo $KUUZU_CategoryTree->getTree(); ?>
  </div>
</div>
