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

  abstract class PaymentModuleAbstract {
    protected $_code;
    protected $_title;
    protected $_description;
    protected $_author_name;
    protected $_author_www;
    protected $_status;
    protected $_sort_order = 0;

    abstract protected function initialize();
    abstract public function isInstalled();

    public function __construct() {
      $module_class = explode('\\', get_called_class());
      $this->_code = end($module_class);

      $this->initialize();
    }

    public function isEnabled() {
      return $this->_status;
    }

    public function getCode() {
      return $this->_code;
    }

    public function getTitle() {
      return $this->_title;
    }

    public function getSortOrder() {
      return $this->_sort_order;
    }

    public function hasKeys() {
      return (count($this->getKeys()) > 0);
    }

    public function getKeys() {
      return array();
    }

    public function install() {
      $KUUZU_Language = Registry::get('Language');

      $data = array('title' => $this->_title,
                    'code' => $this->_code,
                    'author_name' => $this->_author_name,
                    'author_www' => $this->_author_www,
                    'group' => 'Payment');

      KUUZU::callDB('Admin\InsertModule', $data, 'Site');

      foreach ( $KUUZU_Language->getAll() as $key => $value ) {
        if ( file_exists(KUUZU::BASE_DIRECTORY . 'Core/Site/Shop/Languages/' . $key . '/modules/payment/' . $this->_code . '.xml') ) {
          foreach ( $KUUZU_Language->extractDefinitions($key . '/modules/payment/' . $this->_code . '.xml') as $def ) {
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
                    'group' => 'Payment');

      KUUZU::callDB('Admin\DeleteModule', $data, 'Site');

      if ( $this->hasKeys() ) {
        KUUZU::callDB('Admin\DeleteConfigurationParameters', $this->getKeys(), 'Site');

        Cache::clear('configuration');
      }

      if ( file_exists(KUUZU::BASE_DIRECTORY . 'Core/Site/Shop/Languages/' . $KUUZU_Language->getCode() . '/modules/payment/' . $this->_code . '.xml') ) {
        foreach ( $KUUZU_Language->extractDefinitions($KUUZU_Language->getCode() . '/modules/payment/' . $this->_code . '.xml') as $def ) {
          KUUZU::callDB('Admin\DeleteLanguageDefinitions', $def, 'Site');
        }

        Cache::clear('languages');
      }
    }
  }
?>
