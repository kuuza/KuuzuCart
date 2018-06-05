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

  class WhosOnline extends \Kuuzu\KU\Core\Site\Admin\ServiceAbstract {
    var $depends = array('Session', 'Core');

    protected function initialize() {
      $this->title = KUUZU::getDef('services_whos_online_title');
      $this->description = KUUZU::getDef('services_whos_online_description');
    }

    public function install() {
      $data = array('title' => 'Detect Search Engine Spider Robots',
                    'key' => 'SERVICE_WHOS_ONLINE_SPIDER_DETECTION',
                    'value' => '1',
                    'description' => 'Detect search engine spider robots (GoogleBot, Yahoo, etc).',
                    'group_id' => '6',
                    'use_function' => 'kuu_cfg_use_get_boolean_value',
                    'set_function' => 'kuu_cfg_set_boolean_value(array(1, -1))');

      KUUZU::callDB('Admin\InsertConfigurationParameters', $data, 'Site');
    }

    public function remove() {
      KUUZU::callDB('Admin\DeleteConfigurationParameters', $this->keys(), 'Site');
    }

    public function keys() {
      return array('SERVICE_WHOS_ONLINE_SPIDER_DETECTION');
    }
  }
?>
