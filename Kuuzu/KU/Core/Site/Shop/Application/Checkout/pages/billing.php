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
?>

<h1><?php echo $KUUZU_Template->getPageTitle(); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists('CheckoutPayment') ) {
    echo $KUUZU_MessageStack->get('CheckoutPayment');
  }
?>

<form name="checkout_billing" action="<?php echo KUUZU::getLink(null, null, 'Billing&Process', 'SSL'); ?>" method="post" onsubmit="return check_form();">

<?php
  if ( DISPLAY_CONDITIONS_ON_CHECKOUT == '1' ) {
?>

<div class="moduleBox">
  <h6><?php echo KUUZU::getDef('order_conditions_title'); ?></h6>

  <div class="content">
    <?php echo sprintf(KUUZU::getDef('order_conditions_description'), KUUZU::getLink(null, 'Info', 'Conditions', 'AUTO')) . '<br /><br />' . HTML::checkboxField('conditions', array(array('id' => 1, 'text' => KUUZU::getDef('order_conditions_acknowledge'))), false); ?>
  </div>
</div>

<?php
  }
?>

<div class="moduleBox">
  <h6><?php echo KUUZU::getDef('billing_address_title'); ?></h6>

  <div class="content">
    <div style="float: right; padding: 0px 0px 10px 20px;">
      <?php echo Address::format($KUUZU_ShoppingCart->getBillingAddress(), '<br />'); ?>
    </div>

    <div style="float: right; padding: 0px 0px 10px 20px; text-align: center;">
      <?php echo '<b>' . KUUZU::getDef('billing_address_title') . '</b>'; ?>
    </div>

    <?php echo KUUZU::getDef('choose_billing_destination'). '<br /><br />' . HTML::button(array('href' => KUUZU::getLink(null, null, 'Billing&Address', 'SSL'), 'icon' => 'home', 'title' => KUUZU::getDef('button_change_address'))); ?>

    <div style="clear: both;"></div>
  </div>
</div>

<div class="moduleBox">
  <h6><?php echo KUUZU::getDef('payment_method_title'); ?></h6>

  <div class="content">

<?php
  $selection = $KUUZU_Payment->selection();

  if ( count($selection) > 1 ) {
?>

    <div style="float: right; padding: 0px 0px 10px 20px; text-align: center;">
      <?php echo '<b>' . KUUZU::getDef('please_select') . '</b>'; ?>
    </div>

    <p style="margin-top: 0px;"><?php echo KUUZU::getDef('choose_payment_method'); ?></p>

<?php
  } else {
?>

    <p style="margin-top: 0px;"><?php echo KUUZU::getDef('only_one_payment_method_available'); ?></p>

<?php
  }
?>

    <table border="0" width="100%" cellspacing="0" cellpadding="2">

<?php
  $radio_buttons = 0;
  for ( $i=0, $n=sizeof($selection); $i<$n; $i++ ) {
?>

      <tr>
        <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">

<?php
    if ( ($n == 1) || ($KUUZU_ShoppingCart->hasBillingMethod() && ($selection[$i]['id'] == $KUUZU_ShoppingCart->getBillingMethod('id'))) ) {
      echo '          <tr id="defaultSelected" class="moduleRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
    } else {
      echo '          <tr class="moduleRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="selectRowEffect(this, ' . $radio_buttons . ')">' . "\n";
    }
?>

            <td width="10">&nbsp;</td>

<?php
    if ( $n > 1 ) {
?>

            <td colspan="3"><?php echo '<b>' . $selection[$i]['module'] . '</b>'; ?></td>
            <td align="right"><?php echo HTML::radioField('payment_method', $selection[$i]['id'], ($KUUZU_ShoppingCart->hasBillingMethod() ? $KUUZU_ShoppingCart->getBillingMethod('id') : null)); ?></td>

<?php
    } else {
?>

            <td colspan="4"><?php echo '<b>' . $selection[$i]['module'] . '</b>' . HTML::hiddenField('payment_method', $selection[$i]['id']); ?></td>

<?php
  }
?>

            <td width="10">&nbsp;</td>
          </tr>

<?php
    if ( isset($selection[$i]['error']) ) {
?>

          <tr>
            <td width="10">&nbsp;</td>
            <td colspan="4"><?php echo $selection[$i]['error']; ?></td>
            <td width="10">&nbsp;</td>
          </tr>

<?php
    } elseif ( isset($selection[$i]['fields']) && is_array($selection[$i]['fields']) ) {
?>

          <tr>
            <td width="10">&nbsp;</td>
            <td colspan="4"><table border="0" cellspacing="0" cellpadding="2">

<?php
      for ( $j=0, $n2=sizeof($selection[$i]['fields']); $j<$n2; $j++ ) {
?>

              <tr>
                <td width="10">&nbsp;</td>
                <td><?php echo $selection[$i]['fields'][$j]['title']; ?></td>
                <td width="10">&nbsp;</td>
                <td><?php echo $selection[$i]['fields'][$j]['field']; ?></td>
                <td width="10">&nbsp;</td>
              </tr>

<?php
      }
?>

            </table></td>
            <td width="10">&nbsp;</td>
          </tr>

<?php
    }
?>

        </table></td>
      </tr>

<?php
    $radio_buttons++;
  }
?>

    </table>
  </div>
</div>

<div class="moduleBox">
  <h6><?php echo KUUZU::getDef('add_comment_to_order_title'); ?></h6>

  <div class="content">
    <?php echo HTML::textareaField('comments', (isset($_SESSION['comments']) ? $_SESSION['comments'] : null), null, null, 'style="width: 98%;"'); ?>
  </div>
</div>

<br />

<div class="moduleBox">
  <div class="content">
    <div style="float: right;">
      <?php echo HTML::button(array('icon' => 'triangle-1-e', 'title' => KUUZU::getDef('button_continue'))); ?>
    </div>

    <?php echo '<b>' . KUUZU::getDef('continue_checkout_procedure_title') . '</b><br />' . KUUZU::getDef('continue_checkout_procedure_to_confirmation'); ?>
  </div>
</div>

</form>
