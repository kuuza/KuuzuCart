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

  use Kuuzu\KU\Core\DateTime;
  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\PDO;
  use Kuuzu\KU\Core\Site\Shop\Order;
?>

<h1><?php echo $KUUZU_Template->getPageTitle(); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists('Account') ) {
    echo $KUUZU_MessageStack->get('Account');
  }

  if ( Order::numberOfEntries() > 0 ) {
    $orders_listing = Order::getListing(MAX_DISPLAY_ORDER_HISTORY);

    foreach ( $orders_listing['entries'] as $o ) {
      if ( !empty($o['delivery_name']) ) {
        $order_type = KUUZU::getDef('order_shipped_to');
        $order_name = $o['delivery_name'];
      } else {
        $order_type = KUUZU::getDef('order_billed_to');
        $order_name = $o['billing_name'];
      }
?>

<div class="moduleBox">
  <span style="float: right;"><h6><?php echo KUUZU::getDef('order_status') . ' ' . $o['orders_status_name']; ?></h6></span>

  <h6><?php echo KUUZU::getDef('order_number') . ' ' . $o['orders_id']; ?></h6>

  <div class="content">
    <table border="0" width="100%" cellspacing="2" cellpadding="4">
      <tr>
        <td width="50%" valign="top"><?php echo '<b>' . KUUZU::getDef('order_date') . '</b> ' . DateTime::getLong($o['date_purchased']) . '<br /><b>' . $order_type . '</b> ' . HTML::outputProtected($order_name); ?></td>
        <td width="30%" valign="top"><?php echo '<b>' . KUUZU::getDef('order_products') . '</b> ' . Order::numberOfProducts($o['orders_id']) . '<br /><b>' . KUUZU::getDef('order_cost') . '</b> ' . strip_tags($o['order_total']); ?></td>
        <td width="20%"><?php echo HTML::button(array('href' => KUUZU::getLink(null, null, 'Orders=' . $o['orders_id'] . (isset($_GET['page']) ? '&page=' . $_GET['page'] : ''), 'SSL'), 'icon' => 'document', 'title' => KUUZU::getDef('button_view'))); ?></td>
      </tr>
    </table>
  </div>
</div>

<?php
    }
?>

<div class="listingPageLinks">
  <span style="float: right;"><?php echo PDO::getBatchPageLinks('page', $orders_listing['total'], KUUZU::getAllGET('page')); ?></span>

  <?php echo PDO::getBatchTotalPages(KUUZU::getDef('result_set_number_of_orders'), (isset($_GET['page']) ? $_GET['page'] : 1), $orders_listing['total']); ?>
</div>

<?php
  } else {
?>

<div class="moduleBox">
  <div class="content">
    <?php echo KUUZU::getDef('no_orders_made_yet'); ?>
  </div>
</div>

<?php
  }
?>

<div class="submitFormButtons">
  <?php echo HTML::button(array('href' => KUUZU::getLink(null, null, null, 'SSL'), 'icon' => 'triangle-1-w', 'title' => KUUZU::getDef('button_back'))); ?>
</div>
