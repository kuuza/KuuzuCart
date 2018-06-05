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

<div class="moduleBox">
  <h6><?php echo KUUZU::getDef('primary_address_title'); ?></h6>

  <div class="content">
    <div style="float: right; padding: 0px 0px 10px 20px;">
      <?php echo Address::format($KUUZU_Customer->getDefaultAddressID(), '<br />'); ?>
    </div>

    <div style="float: right; padding: 0px 0px 10px 20px; text-align: center;">
      <?php echo '<b>' . KUUZU::getDef('primary_address_title') . '</b>'; ?>
    </div>

    <?php echo KUUZU::getDef('primary_address_description'); ?>

    <div style="clear: both;"></div>
  </div>
</div>

<div class="moduleBox">
  <h6><?php echo KUUZU::getDef('address_book_title'); ?></h6>

  <div class="content">
    <table border="0" width="100%" cellspacing="0" cellpadding="2">

<?php
  $Qaddresses = AddressBook::getListing();

  $counter = 0;

  while ( $Qaddresses->fetch() ) {
?>

      <tr class="moduleRow" onmouseover="rowOverEffect(this);" onmouseout="rowOutEffect(this);">
        <td>
          <b><?php echo $Qaddresses->valueProtected('firstname') . ' ' . $Qaddresses->valueProtected('lastname'); ?></b>

<?php
    if ( $Qaddresses->valueInt('address_book_id') == $KUUZU_Customer->getDefaultAddressID() ) {
      echo '&nbsp;<small><i>' . KUUZU::getDef('primary_address_marker') . '</i></small>';
    }
?>

        </td>
        <td align="right"><?php echo HTML::button(array('href' => KUUZU::getLink(null, null, 'AddressBook&Edit=' . $Qaddresses->valueInt('address_book_id'), 'SSL'), 'title' => KUUZU::getDef('button_edit'))) . '&nbsp;' . HTML::button(array('href' => KUUZU::getLink(null, null, 'AddressBook&Delete=' . $Qaddresses->valueInt('address_book_id'), 'SSL'), 'title' => KUUZU::getDef('button_delete'))); ?></td>
      </tr>
      <tr>
        <td colspan="2" style="padding: 0px 0px 10px 10px;"><?php echo Address::format($Qaddresses->toArray(), '<br />'); ?></td>
      </tr>

<?php
    $counter++;
  }
?>

    </table>
  </div>
</div>

<div class="submitFormButtons">
  <span style="float: right;">

<?php
  if ( $counter < MAX_ADDRESS_BOOK_ENTRIES ) {
    echo HTML::button(array('href' => KUUZU::getLink(null, null, 'AddressBook&Create', 'SSL'), 'icon' => 'plus', 'title' => KUUZU::getDef('button_add_address')));
  } else {
    echo sprintf(KUUZU::getDef('address_book_maximum_entries'), MAX_ADDRESS_BOOK_ENTRIES);
  }
?>

  </span>

  <?php echo HTML::button(array('href' => KUUZU::getLink(null, null, null, 'SSL'), 'icon' => 'triangle-1-w', 'title' => KUUZU::getDef('button_back'))); ?>
</div>
