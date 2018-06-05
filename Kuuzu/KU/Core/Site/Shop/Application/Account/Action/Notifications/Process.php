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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Account\Action\Notifications;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;

  class Process {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_Customer = Registry::get('Customer');
      $KUUZU_MessageStack = Registry::get('MessageStack');

      $updated = false;

      if ( isset($_POST['product_global']) && is_numeric($_POST['product_global']) ) {
        $product_global = (int)$_POST['product_global'];
      } else {
        $product_global = 0;
      }

      if ( isset($_POST['products']) ) {
        (array)$products = $_POST['products'];
      } else {
        $products = array();
      }

// HPDL Should be moved to the customers class!
      $Qglobal = $KUUZU_PDO->prepare('select global_product_notifications from :table_customers where customers_id = :customers_id');
      $Qglobal->bindInt(':customers_id', $KUUZU_Customer->getID());
      $Qglobal->execute();

      if ( $product_global !== $Qglobal->valueInt('global_product_notifications') ) {
        $product_global = (($Qglobal->valueInt('global_product_notifications') === 1) ? 0 : 1);

        $Qupdate = $KUUZU_PDO->prepare('update :table_customers set global_product_notifications = :global_product_notifications where customers_id = :customers_id');
        $Qupdate->bindInt(':global_product_notifications', $product_global);
        $Qupdate->bindInt(':customers_id', $KUUZU_Customer->getID());
        $Qupdate->execute();

        if ( $Qupdate->rowCount() === 1 ) {
          $updated = true;
        }
      } elseif ( count($products) > 0 ) {
        $products_parsed = array_filter($products, 'is_numeric');

        if ( count($products_parsed) > 0 ) {
          $Qcheck = $KUUZU_PDO->prepare('select count(*) as total from :table_products_notifications where customers_id = :customers_id and products_id not in (' . implode(',', $products_parsed) . ')');
          $Qcheck->bindInt(':customers_id', $KUUZU_Customer->getID());
          $Qcheck->execute();

          if ( $Qcheck->valueInt('total') > 0 ) {
            $Qdelete = $KUUZU_PDO->prepare('delete from :table_products_notifications where customers_id = :customers_id and products_id not in (' . implode(',', $products_parsed) . ')');
            $Qdelete->bindInt(':customers_id', $KUUZU_Customer->getID());
            $Qdelete->execute();

            if ( $Qdelete->rowCount() > 0 ) {
              $updated = true;
            }
          }
        }
      } else {
        $Qcheck = $KUUZU_PDO->prepare('select count(*) as total from :table_products_notifications where customers_id = :customers_id');
        $Qcheck->bindInt(':customers_id', $KUUZU_Customer->getID());
        $Qcheck->execute();

        if ( $Qcheck->valueInt('total') > 0 ) {
          $Qdelete = $KUUZU_PDO->prepare('delete from :table_products_notifications where customers_id = :customers_id');
          $Qdelete->bindInt(':customers_id', $KUUZU_Customer->getID());
          $Qdelete->execute();

          if ( $Qdelete->rowCount() > 0 ) {
            $updated = true;
          }
        }
      }

      if ( $updated === true ) {
        $KUUZU_MessageStack->add('Account', KUUZU::getDef('success_notifications_updated'), 'success');
      }

      KUUZU::redirect(KUUZU::getLink(null, null, null, 'SSL'));
    }
  }
?>
