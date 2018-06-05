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

  class Currencies extends \Kuuzu\KU\Core\Site\Admin\ServiceAbstract {
    var $uninstallable = false;
    var $depends = 'Language';

    protected function initialize() {
      $this->title = KUUZU::getDef('services_currencies_title');
      $this->description = KUUZU::getDef('services_currencies_description');
    }

    public function install() {
      $data = array('title' => 'Use Default Language Currency',
                    'key' => 'USE_DEFAULT_LANGUAGE_CURRENCY',
                    'value' => '-1',
                    'description' => 'Automatically use the currency set with the language (eg, German->Euro).',
                    'group_id' => '6',
                    'use_function' => 'kuu_cfg_use_get_boolean_value',
                    'set_function' => 'kuu_cfg_set_boolean_value(array(1, -1))');

      KUUZU::callDB('Admin\InsertConfigurationParameters', $data, 'Site');
    }

    public function remove() {
      KUUZU::callDB('Admin\DeleteConfigurationParameters', $this->keys(), 'Site');
    }

    public function keys() {
      return array('USE_DEFAULT_LANGUAGE_CURRENCY');
    }
  }
?>
