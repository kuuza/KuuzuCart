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

  namespace Kuuzu\KU\Core\Site\Admin;

  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Cache;

  class Shipping extends \Kuuzu\KU\Core\Site\Shop\Shipping {
    var $_group = 'shipping';

    public function hasKeys() {
      return (count($this->getKeys()) > 0);
    }

    public function install() {
      $KUUZU_Language = Registry::get('Language');

      $data = array('title' => $this->_title,
                    'code' => $this->_code,
                    'author_name' => $this->_author_name,
                    'author_www' => $this->_author_www,
                    'group' => 'Shipping');

      KUUZU::callDB('Admin\InsertModule', $data, 'Site');

      foreach ( $KUUZU_Language->getAll() as $key => $value ) {
        if ( file_exists(KUUZU::BASE_DIRECTORY . 'Core/Site/Shop/Languages/' . $key . '/modules/shipping/' . $this->_code . '.xml') ) {
          foreach ( $KUUZU_Language->extractDefinitions($key . '/modules/shipping/' . $this->_code . '.xml') as $def ) {
            $def['id'] = $value['id'];

            KUUZU::callDB('Admin\InsertLanguageDefinition', $def, 'Site');
          }
        }
      }

      Cache::clear('languages');
    }

    public function remove() {
      $KUUZU_Language = Registry::get('Language');

      $data = array('code' => $this->_code,
                    'group' => 'Shipping');

      KUUZU::callDB('Admin\DeleteModule', $data, 'Site');

      if ( $this->hasKeys() ) {
        KUUZU::callDB('Admin\DeleteConfigurationParameters', $this->getKeys(), 'Site');

        Cache::clear('configuration');
      }

      if ( file_exists(KUUZU::BASE_DIRECTORY . 'Core/Site/Shop/Languages/' . $KUUZU_Language->getCode() . '/modules/shipping/' . $this->_code . '.xml') ) {
        foreach ( $KUUZU_Language->extractDefinitions($KUUZU_Language->getCode() . '/modules/shipping/' . $this->_code . '.xml') as $def ) {
          KUUZU::callDB('Admin\DeleteLanguageDefinitions', $def, 'Site');
        }

        Cache::clear('languages');
      }
    }
  }
?>
