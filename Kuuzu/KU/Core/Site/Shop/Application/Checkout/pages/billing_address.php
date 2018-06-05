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
  if ( $KUUZU_MessageStack->exists('CheckoutAddress') ) {
    echo $KUUZU_MessageStack->get('CheckoutAddress');
  }
?>

<form name="checkout_address" action="<?php echo KUUZU::getLink(null, null, 'Billing&Address&Process', 'SSL'); ?>" method="post" onsubmit="return check_form_optional(checkout_address);">

<?php
  if ( !isset($_GET['Process']) ) {
    if ( $KUUZU_Customer->hasDefaultAddress() ) {
?>

<div class="moduleBox">
  <h6><?php echo KUUZU::getDef('billing_address_title'); ?></h6>

  <div class="content">
    <div style="float: right; padding: 0px 0px 10px 20px;">
      <?php echo Address::format($KUUZU_ShoppingCart->getBillingAddress(), '<br />'); ?>
    </div>

    <div style="float: right; padding: 0px 0px 10px 20px; text-align: center;">
      <?php echo '<b>' . KUUZU::getDef('current_billing_address_title') . '</b>'; ?>
    </div>

    <?php echo KUUZU::getDef('selected_billing_destination'); ?>

    <div style="clear: both;"></div>
  </div>
</div>

<?php
    }

    if ( $KUUZU_Customer->isLoggedOn() && (AddressBook::numberOfEntries() > 1) ) {
?>

<div class="moduleBox">
  <h6><?php echo KUUZU::getDef('address_book_entries_title'); ?></h6>

  <div class="content">
    <div style="float: right; padding: 0px 0px 10px 20px; text-align: center;">
      <?php echo '<b>' . KUUZU::getDef('please_select') . '</b>'; ?>
    </div>

    <p style="margin-top: 0px;"><?php echo KUUZU::getDef('select_another_billing_destination'); ?></p>

    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td height="30" colspan="4">&nbsp;</td>
      </tr>

<?php
      $radio_buttons = 0;

      $Qaddresses = AddressBook::getListing();

      while ( $Qaddresses->fetch() ) {
?>

      <tr>
        <td width="10">&nbsp;</td>
        <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">

<?php
       if ( $Qaddresses->valueInt('address_book_id') == $KUUZU_ShoppingCart->getBillingAddress('id') ) {
          echo '          <tr id="defaultSelected" class="moduleRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
        } else {
          echo '          <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
        }
/* HPDL kuu_draw_radio_field() does not like integer default values */
?>

            <td width="10">&nbsp;</td>
            <td colspan="2"><b><?php echo $Qaddresses->valueProtected('firstname') . ' ' . $Qaddresses->valueProtected('lastname'); ?></b></td>
            <td align="right"><?php echo HTML::radioField('ab', $Qaddresses->valueInt('address_book_id'), (string)$KUUZU_ShoppingCart->getBillingAddress('id')); ?></td>
            <td width="10">&nbsp;</td>
          </tr>
          <tr>
            <td width="10">&nbsp;</td>
            <td colspan="3"><table border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td width="10">&nbsp;</td>
                <td><?php echo Address::format($Qaddresses->toArray(), ', '); ?></td>
                <td width="10">&nbsp;</td>
              </tr>
            </table></td>
            <td width="10">&nbsp;</td>
          </tr>
        </table></td>
        <td width="10">&nbsp;</td>
      </tr>

<?php
        $radio_buttons++;
      }
?>

    </table>
  </div>
</div>

<?php
    }
  }

  if ( !$KUUZU_Customer->isLoggedOn() || (AddressBook::numberOfEntries() < MAX_ADDRESS_BOOK_ENTRIES) ) {
?>

<div class="moduleBox">
  <em style="float: right; margin-top: 10px;"><?php echo KUUZU::getDef('form_required_information'); ?></em>

  <h6><?php echo KUUZU::getDef('new_billing_address_title'); ?></h6>

  <div class="content">
    <?php echo KUUZU::getDef('new_billing_address'); ?>

    <div style="margin: 10px 30px 10px 30px;">
      <?php require(KUUZU::BASE_DIRECTORY . 'Core/Site/Shop/Application/Account/pages/address_book_details.php'); ?>
    </div>
  </div>
</div>

<?php
  }
?>

<br />

<div class="moduleBox">
  <div class="content">
    <div style="float: right;">
      <?php echo HTML::button(array('icon' => 'triangle-1-e', 'title' => KUUZU::getDef('button_continue'))); ?>
    </div>

    <?php echo '<b>' . KUUZU::getDef('continue_checkout_procedure_title') . '</b><br />' . KUUZU::getDef('continue_checkout_procedure_to_payment'); ?>
  </div>
</div>

</form>
