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

  namespace Kuuzu\KU\Core\Site\Shop\Module\Payment;

  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Shop\Order;

  class COD extends \Kuuzu\KU\Core\Site\Shop\PaymentModuleAbstract {
    protected function initialize() {
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_ShoppingCart = Registry::get('ShoppingCart');

      $this->_title = KUUZU::getDef('payment_cod_title');
      $this->_method_title = KUUZU::getDef('payment_cod_method_title');
      $this->_status = (MODULE_PAYMENT_COD_STATUS == '1') ? true : false;
      $this->_sort_order = MODULE_PAYMENT_COD_SORT_ORDER;

      if ( $this->_status === true ) {
        if ( (int)MODULE_PAYMENT_COD_ORDER_STATUS_ID > 0 ) {
          $this->order_status = MODULE_PAYMENT_COD_ORDER_STATUS_ID;
        }

        if ( (int)MODULE_PAYMENT_COD_ZONE > 0 ) {
          $check_flag = false;

          $Qcheck = $KUUZU_PDO->prepare('select zone_id from :table_zones_to_geo_zones where geo_zone_id = :geo_zone_id and zone_country_id = :zone_country_id order by zone_id');
          $Qcheck->bindInt(':geo_zone_id', (int)MODULE_PAYMENT_COD_ZONE);
          $Qcheck->bindInt(':zone_country_id', $KUUZU_ShoppingCart->getBillingAddress('country_id'));
          $Qcheck->execute();

          while ( $Qcheck->fetch() ) {
            if ( $Qcheck->valueInt('zone_id') < 1 ) {
              $check_flag = true;
              break;
            } elseif ( $Qcheck->valueInt('zone_id') == $KUUZU_ShoppingCart->getBillingAddress('zone_id') ) {
              $check_flag = true;
              break;
            }
          }

          if ( $check_flag === false ) {
            $this->_status = false;
          }
        }
      }
    }

    public function process() {
      $this->_order_id = Order::insert();
      Order::process($this->_order_id, $this->_order_status);
    }
  }
?>
