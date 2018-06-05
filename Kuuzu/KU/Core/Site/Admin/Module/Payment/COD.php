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

  namespace Kuuzu\KU\Core\Site\Admin\Module\Payment;

  use Kuuzu\KU\Core\KUUZU;

/**
 * The administration side of the Cash On Delivery payment module
 */

  class COD extends \Kuuzu\KU\Core\Site\Admin\PaymentModuleAbstract {

/**
 * The administrative title of the payment module
 *
 * @var string
 */

    protected $_title;

/**
 * The administrative description of the payment module
 *
 * @var string
 */

    protected $_description;

/**
 * The developers name
 *
 * @var string
 */

    protected $_author_name = 'Kuuzu';

/**
 * The developers address
 *
 * @var string
 */

    protected $_author_www = 'https://kuuzu.org';

/**
 * The status of the module
 *
 * @var boolean
 */

    protected $_status = false;

/**
 * Initialize module
 */

    protected function initialize() {
      $this->_title = KUUZU::getDef('payment_cod_title');
      $this->_description = KUUZU::getDef('payment_cod_description');
      $this->_status = (defined('MODULE_PAYMENT_COD_STATUS') && (MODULE_PAYMENT_COD_STATUS == '1') ? true : false);
      $this->_sort_order = (defined('MODULE_PAYMENT_COD_SORT_ORDER') ? MODULE_PAYMENT_COD_SORT_ORDER : 0);
    }

/**
 * Checks to see if the module has been installed
 *
 * @return boolean
 */

    public function isInstalled() {
      return defined('MODULE_PAYMENT_COD_STATUS');
    }

/**
 * Installs the module
 *
 * @see \Kuuzu\KU\Core\Site\Admin\PaymentModuleAbstract::install()
 */

    public function install() {
      parent::install();

      $data = array(array('title' => 'Enable Cash On Delivery Module',
                          'key' => 'MODULE_PAYMENT_COD_STATUS',
                          'value' => '-1',
                          'description' => 'Do you want to accept Cash On Delivery payments?',
                          'group_id' => '6',
                          'use_function' => 'kuu_cfg_use_get_boolean_value',
                          'set_function' => 'kuu_cfg_set_boolean_value(array(1, -1))'),
                    array('title' => 'Payment Zone',
                          'key' => 'MODULE_PAYMENT_COD_ZONE',
                          'value' => '0',
                          'description' => 'If a zone is selected, only enable this payment method for that zone.',
                          'group_id' => '6',
                          'use_function' => 'kuu_cfg_use_get_zone_class_title',
                          'set_function' => 'kuu_cfg_set_zone_classes_pull_down_menu'),
                    array('title' => 'Sort order of display.',
                          'key' => 'MODULE_PAYMENT_COD_SORT_ORDER',
                          'value' => '0',
                          'description' => 'Sort order of display. Lowest is displayed first.',
                          'group_id' => '6'),
                    array('title' => 'Set Order Status',
                          'key' => 'MODULE_PAYMENT_COD_ORDER_STATUS_ID',
                          'value' => '0',
                          'description' => 'Set the status of orders made with this payment module to this value',
                          'group_id' => '6',
                          'use_function' => 'kuu_cfg_use_get_order_status_title',
                          'set_function' => 'kuu_cfg_set_order_statuses_pull_down_menu')
                   );

      KUUZU::callDB('Admin\InsertConfigurationParameters', $data, 'Site');
    }

/**
 * Return the configuration parameter keys in an array
 *
 * @return array
 */

    public function getKeys() {
      return array('MODULE_PAYMENT_COD_STATUS',
                   'MODULE_PAYMENT_COD_ZONE',
                   'MODULE_PAYMENT_COD_ORDER_STATUS_ID',
                   'MODULE_PAYMENT_COD_SORT_ORDER');
    }
  }
?>
