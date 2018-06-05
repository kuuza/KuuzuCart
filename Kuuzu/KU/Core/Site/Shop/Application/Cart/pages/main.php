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
  if ( $KUUZU_MessageStack->exists('Cart') ) {
    echo $KUUZU_MessageStack->get('Cart');
  }
?>

<div class="moduleBox">
  <h6><?php echo KUUZU::getDef('shopping_cart_heading'); ?></h6>

  <form name="shopping_cart" action="<?php echo KUUZU::getLink(null, null, 'Update', 'SSL'); ?>" method="post">

  <div class="content">
    <table border="0" width="100%" cellspacing="0" cellpadding="2">

<?php
    $_cart_date_added = null;

    foreach ( $KUUZU_ShoppingCart->getProducts() as $products ) {
      if ( $products['date_added'] != $_cart_date_added ) {
        $_cart_date_added = $products['date_added'];
?>

      <tr>
        <td colspan="4"><?php echo sprintf(KUUZU::getDef('date_added_to_shopping_cart'), $products['date_added']); ?></td>
      </tr>

<?php
      }
?>

      <tr>
        <td valign="top" width="60"><?php echo HTML::button(array('href' => KUUZU::getLink(null, null, 'Delete=' . $products['item_id'], 'SSL'), 'icon' => 'trash', 'title' => KUUZU::getDef('button_delete'))); ?></td>
        <td valign="top">

<?php
      echo HTML::link(KUUZU::getLink(null, 'Products', $products['keyword']), '<b>' . $products['name'] . '</b>');

      if ( (STOCK_CHECK == '1') && ($KUUZU_ShoppingCart->isInStock($products['item_id']) === false) ) {
        echo '<span class="markProductOutOfStock">' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '</span>';
      }

// HPDL      echo '&nbsp;(Top Category)';

      if ( $KUUZU_ShoppingCart->isVariant($products['item_id']) ) {
        foreach ( $KUUZU_ShoppingCart->getVariant($products['item_id']) as $variant) {
          echo '<br />- ' . $variant['group_title'] . ': ' . HTML::outputProtected($variant['value_title']);
        }
      }
?>

        </td>
        <td valign="top"><?php echo HTML::inputField('products[' . $products['item_id'] . ']', $products['quantity'], 'size="4"'); ?> <a href="#" onclick="document.shopping_cart.submit(); return false;">update</a></td>
        <td valign="top" align="right"><?php echo '<b>' . $KUUZU_Currencies->displayPrice($products['price'], $products['tax_class_id'], $products['quantity']) . '</b>'; ?></td>
      </tr>

<?php
    }
?>

    </table>
  </div>

  </form>

  <table border="0" width="100%" cellspacing="0" cellpadding="2">

<?php
// HPDL
//    if ($Kuu_OrderTotal->hasActive()) {
//      foreach ($Kuu_OrderTotal->getResult() as $module) {
      foreach ( $KUUZU_ShoppingCart->getOrderTotals() as $module ) {
        echo '    <tr>' . "\n" .
             '      <td align="right">' . $module['title'] . '</td>' . "\n" .
             '      <td align="right">' . $module['text'] . '</td>' . "\n" .
             '    </tr>';
      }
//    }
?>

  </table>

<?php
    if ( (STOCK_CHECK == '1') && ($KUUZU_ShoppingCart->hasStock() === false) ) {
      if ( STOCK_ALLOW_CHECKOUT == '1' ) {
        echo '<p class="stockWarning" align="center">' . sprintf(KUUZU::getDef('products_out_of_stock_checkout_possible'), STOCK_MARK_PRODUCT_OUT_OF_STOCK) . '</p>';
      } else {
        echo '<p class="stockWarning" align="center">' . sprintf(KUUZU::getDef('products_out_of_stock_checkout_not_possible'), STOCK_MARK_PRODUCT_OUT_OF_STOCK) . '</p>';
      }
    }
?>

</div>

<div class="moduleBox">
  <form name="checkout" action="<?php echo KUUZU::getLink(null, 'Checkout', null, 'SSL'); ?>" method="post">

  <div style="float: right;">
    <?php echo HTML::button(array('icon' => 'triangle-1-e', 'title' => KUUZU::getDef('button_checkout'))); ?>
  </div>

<?php
  if ( !$KUUZU_Customer->isLoggedOn() && $KUUZU_Application->requireCustomerAccount() ) {
?>

  <div class="content">
    <?php echo 'E-Mail Address: ' . HTML::inputField('email', $KUUZU_Customer->getEMailAddress()) . ' or ' . HTML::link(KUUZU::getLink(null, 'Account', 'LogIn', 'SSL'), 'Sign-In') . ' to process this order'; ?>
  </div>

<?php
  }
?>

  </form>
</div>
