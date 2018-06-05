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

  class RecentlyVisited extends \Kuuzu\KU\Core\Site\Admin\ServiceAbstract {
    var $depends = array('Session', 'CategoryPath');

    protected function initialize() {
      $this->title = KUUZU::getDef('services_recently_visited_title');
      $this->description = KUUZU::getDef('services_recently_visited_description');
    }

    public function install() {
      $data = array(array('title' => 'Display latest products',
                          'key' => 'SERVICE_RECENTLY_VISITED_SHOW_PRODUCTS',
                          'value' => '1',
                          'description' => 'Display recently visited products.',
                          'group_id' => '6',
                          'use_function' => 'kuu_cfg_use_get_boolean_value',
                          'set_function' => 'kuu_cfg_set_boolean_value(array(1, -1))'),
                    array('title' => 'Display product images',
                          'key' => 'SERVICE_RECENTLY_VISITED_SHOW_PRODUCT_IMAGES',
                          'value' => '1',
                          'description' => 'Display the product image.',
                          'group_id' => '6',
                          'use_function' => 'kuu_cfg_use_get_boolean_value',
                          'set_function' => 'kuu_cfg_set_boolean_value(array(1, -1))'),
                    array('title' => 'Display product prices',
                          'key' => 'SERVICE_RECENTLY_VISITED_SHOW_PRODUCT_PRICES',
                          'value' => '1',
                          'description' => 'Display the products price.',
                          'group_id' => '6',
                          'use_function' => 'kuu_cfg_use_get_boolean_value',
                          'set_function' => 'kuu_cfg_set_boolean_value(array(1, -1))'),
                    array('title' => 'Maximum products to show',
                          'key' => 'SERVICE_RECENTLY_VISITED_MAX_PRODUCTS',
                          'value' => '5',
                          'description' => 'Maximum number of recently visited products to show',
                          'group_id' => '6'),
                    array('title' => 'Display latest categories',
                          'key' => 'SERVICE_RECENTLY_VISITED_SHOW_CATEGORIES',
                          'value' => '1',
                          'description' => 'Display recently visited categories.',
                          'group_id' => '6', 
                          'use_function' => 'kuu_cfg_use_get_boolean_value',
                          'set_function' => 'kuu_cfg_set_boolean_value(array(1, -1))'),
                    array('title' => 'Maximum categories to show',
                          'key' => 'SERVICE_RECENTLY_VISITED_MAX_CATEGORIES',
                          'value' => '3',
                          'description' => 'Mazimum number of recently visited categories to show',
                          'group_id' => '6'),
                    array('title' => 'Display latest searches',
                          'key' => 'SERVICE_RECENTLY_VISITED_SHOW_SEARCHES',
                          'value' => '1',
                          'description' => 'Show recent searches.',
                          'group_id' => '6',
                          'use_function' => 'kuu_cfg_use_get_boolean_value',
                          'set_function' => 'kuu_cfg_set_boolean_value(array(1, -1))'),
                    array('title' => 'Maximum searches to show',
                          'key' => 'SERVICE_RECENTLY_VISITED_MAX_SEARCHES',
                          'value' => '3',
                          'description' => 'Mazimum number of recent searches to display',
                          'group_id' => '6')
                   );

      KUUZU::callDB('Admin\InsertConfigurationParameters', $data, 'Site');
    }

    public function remove() {
      KUUZU::callDB('Admin\DeleteConfigurationParameters', $this->keys(), 'Site');
    }

    public function keys() {
      return array('SERVICE_RECENTLY_VISITED_SHOW_PRODUCTS',
                   'SERVICE_RECENTLY_VISITED_SHOW_PRODUCT_IMAGES',
                   'SERVICE_RECENTLY_VISITED_SHOW_PRODUCT_PRICES',
                   'SERVICE_RECENTLY_VISITED_MAX_PRODUCTS',
                   'SERVICE_RECENTLY_VISITED_SHOW_CATEGORIES',
                   'SERVICE_RECENTLY_VISITED_MAX_CATEGORIES',
                   'SERVICE_RECENTLY_VISITED_SHOW_SEARCHES',
                   'SERVICE_RECENTLY_VISITED_MAX_SEARCHES');
    }
  }
?>
