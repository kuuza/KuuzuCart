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

  namespace Kuuzu\KU\Core\Site\Shop;

  use Kuuzu\KU\Core\Registry;

  class OrderTotal {
    protected $_modules = array();
    protected $_data = array();
    protected $_group = 'order_total';

    public function __construct() {
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_Language = Registry::get('Language');

      $Qmodules = $KUUZU_PDO->prepare('select code from :table_modules where modules_group = "OrderTotal"');
      $Qmodules->setCache('modules-order_total');
      $Qmodules->execute();

      while ( $Qmodules->fetch() ) {
        $this->_modules[] = $Qmodules->value('code');
      }

      $KUUZU_Language->load('modules-order_total');

      foreach ( $this->_modules as $module ) {
        $class_name = 'Kuuzu\\KU\\Core\\Site\\Shop\\Module\\OrderTotal\\' . $module;

        Registry::set('OrderTotal_' . $module, new $class_name(), true);
      }

      usort($this->_modules, function ($a, $b) {
        if ( Registry::get('OrderTotal_' . $a)->getSortOrder() == Registry::get('OrderTotal_' . $b)->getSortOrder() ) {
          return strnatcasecmp(Registry::get('OrderTotal_' . $a)->getTitle(), Registry::get('OrderTotal_' . $b)->getTitle());
        }

        return (Registry::get('OrderTotal_' . $a)->getSortOrder() < Registry::get('OrderTotal_' . $b)->getSortOrder()) ? -1 : 1;
      });
    }

    public function getCode() {
      return $this->_code;
    }

    public function getTitle() {
      return $this->_title;
    }

    public function getDescription() {
      return $this->_description;
    }

    public function isEnabled() {
      return $this->_status;
    }

    public function getSortOrder() {
      return $this->_sort_order;
    }

    public function getResult() {
      $this->_data = array();

      foreach ( $this->_modules as $module ) {
        $KUUZU_OrderTotal_Module = Registry::get('OrderTotal_' . $module);

        if ( $KUUZU_OrderTotal_Module->isEnabled() ) {
          $KUUZU_OrderTotal_Module->process();

          foreach ( $KUUZU_OrderTotal_Module->output as $output ) {
            if ( !empty($output['title']) && !empty($output['text']) ) {
              $this->_data[] = array('code' => $KUUZU_OrderTotal_Module->getCode(),
                                     'title' => $output['title'],
                                     'text' => $output['text'],
                                     'value' => $output['value'],
                                     'sort_order' => $KUUZU_OrderTotal_Module->getSortOrder());
            }
          }
        }
      }

      return $this->_data;
    }

    public function hasActive() {
      static $has_active;

      if ( !isset($has_active) ) {
        $has_active = false;

        foreach ( $this->_modules as $module ) {
          if ( Registry::get('OrderTotal_' . $module)->isEnabled() ) {
            $has_active = true;
            break;
          }
        }
      }

      return $has_active;
    }
  }
?>
