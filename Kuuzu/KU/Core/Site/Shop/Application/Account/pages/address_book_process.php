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
  use Kuuzu\KU\Core\ObjectInfo;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Site\Shop\AddressBook;

  if ( isset($_GET['Edit']) ) {
    $Kuu_oiAddress = new ObjectInfo(AddressBook::getEntry($_GET['Edit']));
  } else {
    if ( AddressBook::numberOfEntries() >= MAX_ADDRESS_BOOK_ENTRIES ) {
      $KUUZU_MessageStack->add('AddressBook', KUUZU::getDef('error_address_book_full'));
    }
  }
?>

<h1><?php echo $KUUZU_Template->getPageTitle(); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists('AddressBook') ) {
    echo $KUUZU_MessageStack->get('AddressBook');
  }

  if ( ($KUUZU_Customer->hasDefaultAddress() === false) || (isset($_GET['Create']) && (AddressBook::numberOfEntries() < MAX_ADDRESS_BOOK_ENTRIES)) || (isset($Kuu_oiAddress) && !empty($Kuu_oiAddress)) ) {
?>

<form name="address_book" action="<?php echo KUUZU::getLink(null, null, 'AddressBook&' . (isset($_GET['Edit']) ? 'Edit=' . $_GET['Edit'] : 'Create') . '&Process', 'SSL'); ?>" method="post" onsubmit="return check_form(address_book);">

<div class="moduleBox">
  <em style="float: right; margin-top: 10px;"><?php echo KUUZU::getDef('form_required_information'); ?></em>

  <h6><?php echo KUUZU::getDef('address_book_new_address_title'); ?></h6>

  <div class="content">

<?php
    include(KUUZU::BASE_DIRECTORY . 'Core/Site/Shop/Application/Account/pages/address_book_details.php');
?>

  </div>
</div>

<div class="submitFormButtons">
  <span style="float: right;"><?php echo HTML::button(array('icon' => 'triangle-1-e', 'title' => KUUZU::getDef('button_continue'))); ?></span>

<?php
    if ( $KUUZU_NavigationHistory->hasSnapshot() ) {
      $back_link = $KUUZU_NavigationHistory->getSnapshotURL();
    } elseif ( $KUUZU_Customer->hasDefaultAddress() === false ) {
      $back_link = KUUZU::getLink(null, null, null, 'SSL');
    } else {
      $back_link = KUUZU::getLink(null, null, 'AddressBook', 'SSL');
    }

    echo HTML::button(array('href' => $back_link, 'icon' => 'triangle-1-w', 'title' => KUUZU::getDef('button_back')));
?>

</div>

</form>

<?php
  } else {
?>

<div class="submitFormButtons">
  <?php HTML::button(array('href' => KUUZU::getLink(null, null, 'AddressBook', 'SSL'), 'icon' => 'triangle-1-w', 'title' => KUUZU::getDef('button_back'))); ?>
</div>

<?php
  }
?>
