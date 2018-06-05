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

  class LowOrderFee extends \Kuuzu\KU\Core\Site\Shop\OrderTotal {
    var $output;

    var $_title,
        $_code = 'LowOrderFee',
        $_status = false,
        $_sort_order;

    public function __construct() {
      $this->output = array();

      $this->_title = KUUZU::getDef('order_total_loworderfee_title');
      $this->_description = KUUZU::getDef('order_total_loworderfee_description');
      $this->_status = (defined('MODULE_ORDER_TOTAL_LOWORDERFEE_STATUS') && (MODULE_ORDER_TOTAL_LOWORDERFEE_STATUS == 'true') ? true : false);
      $this->_sort_order = (defined('MODULE_ORDER_TOTAL_LOWORDERFEE_SORT_ORDER') ? MODULE_ORDER_TOTAL_LOWORDERFEE_SORT_ORDER : null);
    }

    function process() {
      $KUUZU_ShoppingCart = Registry::get('ShoppingCart');
      $KUUZU_Tax = Registry::get('Tax');
      $KUUZU_Currencies = Registry::get('Currencies');

      if ( MODULE_ORDER_TOTAL_LOWORDERFEE_LOW_ORDER_FEE == 'true' ) {
        switch ( MODULE_ORDER_TOTAL_LOWORDERFEE_DESTINATION ) {
          case 'national':
            if ( $KUUZU_ShoppingCart->getShippingAddress('country_id') == STORE_COUNTRY ) {
              $pass = true;
            }
            break;

          case 'international':
            if ( $KUUZU_ShoppingCart->getShippingAddress('country_id') != STORE_COUNTRY ) {
              $pass = true;
            }
            break;

          case 'both':
            $pass = true;
            break;

          default:
            $pass = false;
        }

        if ( ($pass == true) && ($KUUZU_ShoppingCart->getSubTotal() < MODULE_ORDER_TOTAL_LOWORDERFEE_ORDER_UNDER) ) {
          $tax = $KUUZU_Tax->getTaxRate(MODULE_ORDER_TOTAL_LOWORDERFEE_TAX_CLASS, $KUUZU_ShoppingCart->getTaxingAddress('country_id'), $KUUZU_ShoppingCart->getTaxingAddress('zone_id'));
          $tax_description = $KUUZU_Tax->getTaxRateDescription(MODULE_ORDER_TOTAL_LOWORDERFEE_TAX_CLASS, $KUUZU_ShoppingCart->getTaxingAddress('country_id'), $KUUZU_ShoppingCart->getTaxingAddress('zone_id'));

          $KUUZU_ShoppingCart->addTaxAmount($KUUZU_Tax->calculate(MODULE_ORDER_TOTAL_LOWORDERFEE_FEE, $tax));
          $KUUZU_ShoppingCart->addTaxGroup($tax_description, $KUUZU_Tax->calculate(MODULE_ORDER_TOTAL_LOWORDERFEE_FEE, $tax));
          $KUUZU_ShoppingCart->addToTotal(MODULE_ORDER_TOTAL_LOWORDERFEE_FEE + $KUUZU_Tax->calculate(MODULE_ORDER_TOTAL_LOWORDERFEE_FEE, $tax));

          $this->output[] = array('title' => $this->_title . ':',
                                  'text' => $KUUZU_Currencies->displayPriceWithTaxRate(MODULE_ORDER_TOTAL_LOWORDERFEE_FEE, $tax),
                                  'value' => $KUUZU_Currencies->addTaxRateToPrice(MODULE_ORDER_TOTAL_LOWORDERFEE_FEE, $tax));
        }
      }
    }
  }
?>
