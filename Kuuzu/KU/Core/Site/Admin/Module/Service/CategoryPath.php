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

  namespace Kuuzu\KU\Core\Site\Admin\Module\Service;

  use Kuuzu\KU\Core\KUUZU;

/**
 * @since v3.0.2
 */

  class CategoryPath extends \Kuuzu\KU\Core\Site\Admin\ServiceAbstract {
    var $uninstallable = false;

    protected function initialize() {
      $this->title = KUUZU::getDef('services_category_path_title');
      $this->description = KUUZU::getDef('services_category_path_description');
    }

    public function install() {
      $data = array('title' => 'Calculate Number Of Products In Each Category',
                    'key' => 'SERVICES_CATEGORY_PATH_CALCULATE_PRODUCT_COUNT',
                    'value' => '1',
                    'description' => 'Recursively calculate how many products are in each category.',
                    'group_id' => '6',
                    'use_function' => 'kuu_cfg_use_get_boolean_value',
                    'set_function' => 'kuu_cfg_set_boolean_value(array(1, -1))');

      KUUZU::callDB('Admin\InsertConfigurationParameters', $data, 'Site');
    }

    public function remove() {
      KUUZU::callDB('Admin\DeleteConfigurationParameters', $this->keys(), 'Site');
    }

    public function keys() {
      return array('SERVICES_CATEGORY_PATH_CALCULATE_PRODUCT_COUNT');
    }
  }
?>
