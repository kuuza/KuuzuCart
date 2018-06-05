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
  use Kuuzu\KU\Core\Site\Shop\Tax;

  if ( $KUUZU_ShoppingCart->hasBillingMethod() ) {
    echo $KUUZU_PaymentModule->preConfirmationCheck();
  }
?>

<h1><?php echo $KUUZU_Template->getPageTitle(); ?></h1>

<div class="moduleBox">
  <div class="content">
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="30%" valign="top">

<?php
  if ( $KUUZU_ShoppingCart->hasShippingAddress() ) {
?>
          <p><?php echo '<b>' . KUUZU::getDef('order_delivery_address_title') . '</b> ' . HTML::link(KUUZU::getLink(null, 'Checkout', 'Shipping&Address', 'SSL'), '<span class="orderEdit">' . KUUZU::getDef('order_text_edit_title') . '</span>'); ?></p>
          <p><?php echo Address::format($KUUZU_ShoppingCart->getShippingAddress(), '<br />'); ?></p>

<?php
    if ( $KUUZU_ShoppingCart->hasShippingMethod() ) {
?>

          <p><?php echo '<b>' . KUUZU::getDef('order_shipping_method_title') . '</b> ' . HTML::link(KUUZU::getLink(null, 'Checkout', 'Shipping', 'SSL'), '<span class="orderEdit">' . KUUZU::getDef('order_text_edit_title') . '</span>'); ?></p>
          <p><?php echo $KUUZU_ShoppingCart->getShippingMethod('title'); ?></p>

<?php
    }
  }
?>

          <p><?php echo '<b>' . KUUZU::getDef('order_billing_address_title') . '</b> ' . HTML::link(KUUZU::getLink(null, 'Checkout', 'Billing&Address', 'SSL'), '<span class="orderEdit">' . KUUZU::getDef('order_text_edit_title') . '</span>'); ?></p>
          <p><?php echo Address::format($KUUZU_ShoppingCart->getBillingAddress(), '<br />'); ?></p>

          <p><?php echo '<b>' . KUUZU::getDef('order_payment_method_title') . '</b> ' . HTML::link(KUUZU::getLink(null, 'Checkout', 'Billing', 'SSL'), '<span class="orderEdit">' . KUUZU::getDef('order_text_edit_title') . '</span>'); ?></p>
          <p><?php echo $KUUZU_ShoppingCart->getBillingMethod('title'); ?></p>
        </td>
        <td width="70%" valign="top">
          <div style="border: 1px; border-style: solid; border-color: #CCCCCC; background-color: #FBFBFB; padding: 5px;">
            <table border="0" width="100%" cellspacing="0" cellpadding="2">

<?php
  if ( $KUUZU_ShoppingCart->numberOfTaxGroups() > 1 ) {
?>

              <tr>
                <td colspan="2"><?php echo '<b>' . KUUZU::getDef('order_products_title') . '</b> ' . HTML::link(KUUZU::getLink(null, 'Cart', null, 'SSL'), '<span class="orderEdit">' . KUUZU::getDef('order_text_edit_title') . '</span>'); ?></td>
                <td align="right"><b><?php echo KUUZU::getDef('order_tax_title'); ?></b></td>
                <td align="right"><b><?php echo KUUZU::getDef('order_total_title'); ?></b></td>
              </tr>

<?php
  } else {
?>

              <tr>
                <td colspan="3"><?php echo '<b>' . KUUZU::getDef('order_products_title') . '</b> ' . HTML::link(KUUZU::getLink(null, 'Cart', null, 'SSL'), '<span class="orderEdit">' . KUUZU::getDef('order_text_edit_title') . '</span>'); ?></td>
              </tr>

<?php
  }

  foreach ( $KUUZU_ShoppingCart->getProducts() as $products ) {
    echo '              <tr>' . "\n" .
         '                <td align="right" valign="top" width="30">' . $products['quantity'] . '&nbsp;x&nbsp;</td>' . "\n" .
         '                <td valign="top">' . $products['name'];

    if ( (STOCK_CHECK == '1') && !$KUUZU_ShoppingCart->isInStock($products['item_id']) ) {
      echo '<span class="markProductOutOfStock">' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '</span>';
    }

    if ( $KUUZU_ShoppingCart->isVariant($products['item_id']) ) {
      foreach ( $KUUZU_ShoppingCart->getVariant($products['item_id']) as $variant) {
        echo '<br />- ' . $variant['group_title'] . ': ' . HTML::outputProtected($variant['value_title']);
      }
    }

    echo '</td>' . "\n";

    if ( $KUUZU_ShoppingCart->numberOfTaxGroups() > 1 ) {
      echo '                <td valign="top" align="right">' . Tax::displayTaxRateValue($products['tax']) . '</td>' . "\n";
    }

    echo '                <td align="right" valign="top">' . $KUUZU_Currencies->displayPrice($products['price'], $products['tax_class_id'], $products['quantity']) . '</td>' . "\n" .
         '              </tr>' . "\n";
  }
?>

            </table>

            <p>&nbsp;</p>

            <table border="0" width="100%" cellspacing="0" cellpadding="2">

<?php
// HPDL
//  if ($Kuu_OrderTotal->hasActive()) {
//    foreach ($Kuu_OrderTotal->getResult() as $module) {
    foreach ( $KUUZU_ShoppingCart->getOrderTotals() as $module ) {
      echo '              <tr>' . "\n" .
           '                <td align="right">' . $module['title'] . '</td>' . "\n" .
           '                <td align="right">' . $module['text'] . '</td>' . "\n" .
           '              </tr>';
    }
//  }
?>

            </table>
          </div>
        </td>
      </tr>
    </table>
  </div>
</div>

<?php
  if ( $KUUZU_ShoppingCart->hasBillingMethod() ) {
    if ( $confirmation = $KUUZU_PaymentModule->confirmation() ) {
?>

<div class="moduleBox">
  <h6><?php echo KUUZU::getDef('order_payment_information_title'); ?></h6>

  <div class="content">
    <p><?php echo $confirmation['title']; ?></p>

<?php
      if ( isset($confirmation['fields']) ) {
?>

    <table border="0" cellspacing="0" cellpadding="2">

<?php
        for ( $i=0, $n=sizeof($confirmation['fields']); $i<$n; $i++ ) {
?>

      <tr>
        <td width="10">&nbsp;</td>
        <td><?php echo $confirmation['fields'][$i]['title']; ?></td>
        <td width="10">&nbsp;</td>
        <td><?php echo $confirmation['fields'][$i]['field']; ?></td>
      </tr>

<?php
        }
?>

    </table>

<?php
      }

      if ( isset($confirmation['text']) ) {
?>

    <p><?php echo $confirmation['text']; ?></p>

<?php
      }
?>

  </div>
</div>

<?php
    }
  }

  if ( isset($_SESSION['comments']) && !empty($_SESSION['comments']) ) {
?>

<div class="moduleBox">
  <h6><?php echo '<b>' . KUUZU::getDef('order_comments_title') . '</b> ' . HTML::link(KUUZU::getLink(null, 'Checkout', 'Payment', 'SSL'), '<span class="orderEdit">' . KUUZU::getDef('order_text_edit_title') . '</span>'); ?></h6>

  <div class="content">
    <?php echo nl2br(HTML::outputProtected($_SESSION['comments'])) . HTML::hiddenField('comments', $_SESSION['comments']); ?>
  </div>
</div>

<?php
  }
?>

<div class="submitFormButtons" style="text-align: right;">

<?php
  if ( $KUUZU_ShoppingCart->hasBillingMethod() && $KUUZU_PaymentModule->hasGateway() ) {
    $form_action_url = $KUUZU_PaymentModule->getGatewayURL();
  } else {
    $form_action_url = KUUZU::getLink(null, null, 'Process', 'SSL');
  }

  echo '<form name="checkout_confirmation" action="' . $form_action_url . '" method="post">';

  if ( $KUUZU_ShoppingCart->hasBillingMethod() ) {
    echo $KUUZU_PaymentModule->getProcessButton();
  }

  echo HTML::button(array('icon' => 'triangle-1-e', 'title' => KUUZU::getDef('button_confirm_order'))) . '</form>';
?>

</div>
