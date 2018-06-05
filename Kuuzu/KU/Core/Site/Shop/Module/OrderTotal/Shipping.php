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

  namespace Kuuzu\KU\Core\Site\Shop\Module\OrderTotal;

  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

  class Shipping extends \Kuuzu\KU\Core\Site\Shop\OrderTotal {
    var $output;

    var $_title,
        $_code = 'Shipping',
        $_status = false,
        $_sort_order;

    public function __construct() {
      $this->output = array();

      $this->_title = KUUZU::getDef('order_total_shipping_title');
      $this->_description = KUUZU::getDef('order_total_shipping_description');
      $this->_status = (defined('MODULE_ORDER_TOTAL_SHIPPING_STATUS') && (MODULE_ORDER_TOTAL_SHIPPING_STATUS == 'true') ? true : false);
      $this->_sort_order = (defined('MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER') ? MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER : null);
    }

    function process() {
      $KUUZU_ShoppingCart = Registry::get('ShoppingCart');
      $KUUZU_Tax = Registry::get('Tax');
      $KUUZU_Currencies = Registry::get('Currencies');

      if ( $KUUZU_ShoppingCart->hasShippingMethod() ) {
        $KUUZU_ShoppingCart->addToTotal($KUUZU_ShoppingCart->getShippingMethod('cost'));

        if ( $KUUZU_ShoppingCart->getShippingMethod('tax_class_id') > 0 ) {
          $tax = $KUUZU_Tax->getTaxRate($KUUZU_ShoppingCart->getShippingMethod('tax_class_id'), $KUUZU_ShoppingCart->getShippingAddress('country_id'), $KUUZU_ShoppingCart->getShippingAddress('zone_id'));
          $tax_description = $KUUZU_Tax->getTaxRateDescription($KUUZU_ShoppingCart->getShippingMethod('tax_class_id'), $KUUZU_ShoppingCart->getShippingAddress('country_id'), $KUUZU_ShoppingCart->getShippingAddress('zone_id'));

          $KUUZU_ShoppingCart->addTaxAmount($KUUZU_Tax->calculate($KUUZU_ShoppingCart->getShippingMethod('cost'), $tax));
          $KUUZU_ShoppingCart->addTaxGroup($tax_description, $KUUZU_Tax->calculate($KUUZU_ShoppingCart->getShippingMethod('cost'), $tax));

          if ( DISPLAY_PRICE_WITH_TAX == '1' ) {
            $KUUZU_ShoppingCart->addToTotal($KUUZU_Tax->calculate($KUUZU_ShoppingCart->getShippingMethod('cost'), $tax));
            $KUUZU_ShoppingCart->_shipping_method['cost'] += $KUUZU_Tax->calculate($KUUZU_ShoppingCart->getShippingMethod('cost'), $tax);
          }
        }

        $this->output[] = array('title' => $KUUZU_ShoppingCart->getShippingMethod('title') . ':',
                                'text' => $KUUZU_Currencies->format($KUUZU_ShoppingCart->getShippingMethod('cost')),
                                'value' => $KUUZU_ShoppingCart->getShippingMethod('cost'));
      }
    }
  }
?>
