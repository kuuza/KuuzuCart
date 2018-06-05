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

  namespace Kuuzu\KU\Core\Site\Admin\Module\OrderTotal;

  use Kuuzu\KU\Core\KUUZU;

  class Total extends \Kuuzu\KU\Core\Site\Admin\OrderTotal {
    var $_title,
        $_code = 'Total',
        $_author_name = 'Kuuzu',
        $_author_www = 'https://kuuzu.org',
        $_status = false,
        $_sort_order;

    public function __construct() {
      $this->_title = KUUZU::getDef('order_total_total_title');
      $this->_description = KUUZU::getDef('order_total_total_description');
      $this->_status = (defined('MODULE_ORDER_TOTAL_TOTAL_STATUS') && (MODULE_ORDER_TOTAL_TOTAL_STATUS == 'true') ? true : false);
      $this->_sort_order = (defined('MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER') ? MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER : null);
    }

    public function isInstalled() {
      return defined('MODULE_ORDER_TOTAL_TOTAL_STATUS');
    }

    public function install() {
      parent::install();

      $data = array(array('title' => 'Display Total',
                          'key' => 'MODULE_ORDER_TOTAL_TOTAL_STATUS',
                          'value' => 'true',
                          'description' => 'Do you want to display the total order value?',
                          'group_id' => '6', 
                          'set_function' => 'kuu_cfg_set_boolean_value(array(\'true\', \'false\'))'),
                    array('title' => 'Sort Order',
                          'key' => 'MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER',
                          'value' => '4',
                          'description' => 'Sort order of display.',
                          'group_id' => '6')
                   );

      KUUZU::callDB('Admin\InsertConfigurationParameters', $data, 'Site');
    }

    public function getKeys() {
      return array('MODULE_ORDER_TOTAL_TOTAL_STATUS',
                   'MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER');
    }
  }
?>
