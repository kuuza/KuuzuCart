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

// HPDL Should be moved to the customers class!
  $Qglobal = $KUUZU_PDO->prepare('select global_product_notifications from :table_customers where customers_id = :customers_id');
  $Qglobal->bindInt(':customers_id', $KUUZU_Customer->getID());
  $Qglobal->execute();
?>

<h1><?php echo $KUUZU_Template->getPageTitle(); ?></h1>

<form name="account_notifications" action="<?php echo KUUZU::getLink(null, null, 'Notifications&Process', 'SSL'); ?>" method="post">

<div class="moduleBox">
  <h6><?php echo KUUZU::getDef('newsletter_product_notifications'); ?></h6>

  <div class="content">
    <?php echo KUUZU::getDef('newsletter_product_notifications_description'); ?>
  </div>
</div>

<div class="moduleBox">
  <h6><?php echo KUUZU::getDef('newsletter_product_notifications_global'); ?></h6>

  <div class="content">
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="30"><?php echo HTML::checkboxField('product_global', '1', $Qglobal->value('global_product_notifications')); ?></td>
        <td><b><?php echo HTML::label(KUUZU::getDef('newsletter_product_notifications_global'), 'product_global'); ?></b></td>
      </tr>
      <tr>
        <td width="30">&nbsp;</td>
        <td><?php echo KUUZU::getDef('newsletter_product_notifications_global_description'); ?></td>
      </tr>
    </table>
  </div>
</div>

<?php
  if ( $Qglobal->valueInt('global_product_notifications') !== 1 ) {
?>

<div class="moduleBox">
  <h6><?php echo KUUZU::getDef('newsletter_product_notifications_products'); ?></h6>

  <div class="content">

<?php
    if ( $KUUZU_Customer->hasProductNotifications() ) {
?>

    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td colspan="2"><?php echo KUUZU::getDef('newsletter_product_notifications_products_description'); ?></td>
      </tr>

<?php
      $Qproducts = $KUUZU_Customer->getProductNotifications();
      $counter = 0;

      while ( $Qproducts->next() ) {
        $counter++;
?>

      <tr>
        <td width="30"><?php echo HTML::checkboxField('products[' . $counter . ']', $Qproducts->valueInt('products_id'), true); ?></td>
        <td><b><?php echo HTML::label($Qproducts->value('products_name'), 'products[' . $counter . ']'); ?></b></td>
      </tr>

<?php
      }
?>

    </table>

<?php
    } else {
      echo KUUZU::getDef('newsletter_product_notifications_products_none');
    }
?>

  </div>
</div>

<?php
  }
?>

<div class="submitFormButtons" style="text-align: right;">
  <?php echo HTML::button(array('icon' => 'triangle-1-e', 'title' => KUUZU::getDef('button_continue'))); ?>
</div>

</form>
