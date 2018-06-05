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

<?php
  if ( $KUUZU_MessageStack->exists('Account') ) {
    echo $KUUZU_MessageStack->get('Account');
  }
?>

<div class="moduleBox">
  <h6><?php echo KUUZU::getDef('my_account_title'); ?></h6>

  <div class="content">
    <ul style="padding-left: 50px;">
      <li><?php echo HTML::link(KUUZU::getLink(null, null, 'Edit', 'SSL'), KUUZU::getDef('my_account_information')); ?></li>
      <li><?php echo HTML::link(KUUZU::getLink(null, null, 'AddressBook', 'SSL'), KUUZU::getDef('my_account_address_book')); ?></li>
      <li><?php echo HTML::link(KUUZU::getLink(null, null, 'Password', 'SSL'), KUUZU::getDef('my_account_password')); ?></li>
    </ul>

    <div style="clear: both;"></div>
  </div>
</div>

<div class="moduleBox">
  <h6><?php echo KUUZU::getDef('my_orders_title'); ?></h6>

  <div class="content">
    <ul style="padding-left: 50px;">
      <li><?php echo HTML::link(KUUZU::getLink(null, null, 'Orders', 'SSL'), KUUZU::getDef('my_orders_view')); ?></li>
    </ul>

    <div style="clear: both;"></div>
  </div>
</div>

<div class="moduleBox">
  <h6><?php echo KUUZU::getDef('my_notifications_title'); ?></h6>

  <div class="content">
    <ul style="padding-left: 50px;">
      <li><?php echo HTML::link(KUUZU::getLink(null, null, 'Newsletters', 'SSL'), KUUZU::getDef('my_notifications_newsletters')); ?></li>
      <li><?php echo HTML::link(KUUZU::getLink(null, null, 'Notifications', 'SSL'), KUUZU::getDef('my_notifications_products')); ?></li>
    </ul>

    <div style="clear: both;"></div>
  </div>
</div>
