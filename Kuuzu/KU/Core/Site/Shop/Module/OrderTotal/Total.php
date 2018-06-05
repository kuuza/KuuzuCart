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

  class Total extends \Kuuzu\KU\Core\Site\Shop\OrderTotal {
    var $output;

    var $_title,
        $_code = 'Total',
        $_status = false,
        $_sort_order;

    public function __construct() {
      $this->output = array();

      $this->_title = KUUZU::getDef('order_total_total_title');
      $this->_description = KUUZU::getDef('order_total_total_description');
      $this->_status = (defined('MODULE_ORDER_TOTAL_TOTAL_STATUS') && (MODULE_ORDER_TOTAL_TOTAL_STATUS == 'true') ? true : false);
      $this->_sort_order = (defined('MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER') ? MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER : null);
    }

    function process() {
      $KUUZU_Currencies = Registry::get('Currencies');
      $KUUZU_ShoppingCart = Registry::get('ShoppingCart');

      $this->output[] = array('title' => $this->_title . ':',
                              'text' => '<b>' . $KUUZU_Currencies->format($KUUZU_ShoppingCart->getTotal()) . '</b>',
                              'value' => $KUUZU_ShoppingCart->getTotal());
    }
  }
?>
