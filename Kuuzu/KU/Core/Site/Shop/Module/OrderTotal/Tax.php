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

  class Tax extends \Kuuzu\KU\Core\Site\Shop\OrderTotal {
    var $output;

    var $_title,
        $_code = 'Tax',
        $_status = false,
        $_sort_order;

    public function __construct() {
      $this->output = array();

      $this->_title = KUUZU::getDef('order_total_tax_title');
      $this->_description = KUUZU::getDef('order_total_tax_description');
      $this->_status = (defined('MODULE_ORDER_TOTAL_TAX_STATUS') && (MODULE_ORDER_TOTAL_TAX_STATUS == 'true') ? true : false);
      $this->_sort_order = (defined('MODULE_ORDER_TOTAL_TAX_SORT_ORDER') ? MODULE_ORDER_TOTAL_TAX_SORT_ORDER : null);
    }

    function process() {
      $KUUZU_ShoppingCart = Registry::get('ShoppingCart');
      $KUUZU_Currencies = Registry::get('Currencies');

      foreach ( $KUUZU_ShoppingCart->getTaxGroups() as $key => $value ) {
        if ( $value > 0 ) {
          if ( DISPLAY_PRICE_WITH_TAX == '1' ) {
            $KUUZU_ShoppingCart->addToTotal($value);
          }

          $this->output[] = array('title' => $key . ':',
                                  'text' => $KUUZU_Currencies->format($value),
                                  'value' => $value);
        }
      }
    }
  }
?>
