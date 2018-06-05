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

  class Specials extends \Kuuzu\KU\Core\Site\Admin\ServiceAbstract {
    protected function initialize() {
      $this->title = KUUZU::getDef('services_specials_title');
      $this->description = KUUZU::getDef('services_specials_description');
    }

    public function install() {
      $data = array('title' => 'Special Products',
                    'key' => 'MAX_DISPLAY_SPECIAL_PRODUCTS',
                    'value' => '9',
                    'description' => 'Maximum number of products on special to display',
                    'group_id' => '6');

      KUUZU::callDB('Admin\InsertConfigurationParameters', $data, 'Site');
    }

    public function remove() {
      KUUZU::callDB('Admin\DeleteConfigurationParameters', $this->keys(), 'Site');
    }

    public function keys() {
      return array('MAX_DISPLAY_SPECIAL_PRODUCTS');
    }
  }
?>
