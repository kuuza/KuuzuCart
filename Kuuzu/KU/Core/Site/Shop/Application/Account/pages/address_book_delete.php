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
  use Kuuzu\KU\Core\Site\Shop\Address;
  use Kuuzu\KU\Core\Site\Shop\AddressBook;
?>

<h1><?php echo $KUUZU_Template->getPageTitle(); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists('AddressBook') ) {
    echo $KUUZU_MessageStack->get('AddressBook');
  }
?>

<form name="address_book" action="<?php echo KUUZU::getLink(null, null, 'AddressBook&Delete=' . $_GET['Delete'] . '&Process', 'SSL'); ?>" method="post">

<div class="moduleBox">
  <h6><?php echo KUUZU::getDef('address_book_delete_address_title'); ?></h6>

  <div class="content">
    <div style="float: right; padding: 0px 0px 10px 20px;">
      <?php echo Address::format($_GET['Delete'], '<br />'); ?>
    </div>

    <div style="float: right; padding: 0px 0px 10px 20px; text-align: center;">
      <?php echo '<b>' . KUUZU::getDef('selected_address_title') . '</b>'; ?>
    </div>

    <?php echo KUUZU::getDef('address_book_delete_address_description'); ?>

    <div style="clear: both;"></div>
  </div>
</div>

<div class="submitFormButtons">
  <span style="float: right;"><?php echo HTML::button(array('icon' => 'trash', 'title' => KUUZU::getDef('button_delete'))); ?></span>

  <?php echo HTML::button(array('href' => KUUZU::getLink(null, null, 'AddressBook', 'SSL'), 'icon' => 'triangle-1-w', 'title' => KUUZU::getDef('button_back'))); ?>
</div>

</form>
