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

  class Shipping {
    protected $_modules = array();
    protected $_selected_module;
    protected $_quotes = array();
    protected $_group = 'shipping';

    public function __construct($module = null) {
      $KUUZU_ShoppingCart = Registry::get('ShoppingCart');
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_Language = Registry::get('Language');

      $do_shipping = false;

      foreach ( $KUUZU_ShoppingCart->getProducts() as $product ) {
        $KUUZU_Product = new Product($product['id']);

        if ( $KUUZU_Product->isTypeActionAllowed('apply_shipping_fees') ) {
          $do_shipping = true;
          break;
        }
      }

      if ( $do_shipping === true ) {
        $this->_quotes =& $_SESSION['Kuu_ShoppingCart_data']['shipping_quotes'];

        $Qmodules = $KUUZU_PDO->prepare('select code from :table_modules where modules_group = "Shipping"');
        $Qmodules->setCache('modules-shipping');
        $Qmodules->execute();

        while ( $Qmodules->fetch() ) {
          $this->_modules[] = $Qmodules->value('code');
        }

        if ( !empty($this->_modules) ) {
          if ( !empty($module) && in_array(substr($module, 0, strpos($module, '_')), $this->_modules) ) {
            $this->_selected_module = $module;
            $this->_modules = array(substr($module, 0, strpos($module, '_')));
          }

          $KUUZU_Language->load('modules-shipping');

          foreach ( $this->_modules as $module ) {
            $module_class = 'Kuuzu\\KU\\Core\\Site\\Shop\\Module\\Shipping\\' . $module;

            Registry::set('Shipping_' . $module, new $module_class(), true);
            Registry::get('Shipping_' . $module)->initialize();
          }

          usort($this->_modules, function ($a, $b) {
            if ( Registry::get('Shipping_' . $a)->getSortOrder() == Registry::get('Shipping_' . $b)->getSortOrder() ) {
              return strnatcasecmp(Registry::get('Shipping_' . $a)->getTitle(), Registry::get('Shipping_' . $b)->getTitle());
            }

            return (Registry::get('Shipping_' . $a)->getSortOrder() < Registry::get('Shipping_' . $b)->getSortOrder()) ? -1 : 1;
          });
        }
      }

      if ( empty($this->_quotes) ) {
        $this->_calculate();
      }
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

    public function hasQuotes() {
      return !empty($this->_quotes);
    }

    public function numberOfQuotes() {
      $total_quotes = 0;

      foreach ( $this->_quotes as $quotes ) {
        $total_quotes += sizeof($quotes['methods']);
      }

      return $total_quotes;
    }

    public function getQuotes() {
      return $this->_quotes;
    }

    public function getQuote($module = null) {
      if ( empty($module) ) {
        $module = $this->_selected_module;
      }

      list($module_id, $method_id) = explode('_', $module);

      $rate = array();

      foreach ( $this->_quotes as $quote ) {
        if ( $quote['id'] == $module_id ) {
          foreach ( $quote['methods'] as $method ) {
            if ( $method['id'] == $method_id ) {
              $rate = array('id' => $module,
                            'title' => $quote['module'] . (!empty($method['title']) ? ' (' . $method['title'] . ')' : ''),
                            'cost' => $method['cost'],
                            'tax_class_id' => $quote['tax_class_id'],
                            'is_cheapest' => null);

              break 2;
            }
          }
        }
      }

      return $rate;
    }

    public function getCheapestQuote() {
      $rate = array();

      foreach ( $this->_quotes as $quote ) {
        foreach ( $quote['methods'] as $method ) {
          if ( empty($rate) || ($method['cost'] < $rate['cost']) ) {
            $rate = array('id' => $quote['id'] . '_' . $method['id'],
                          'title' => $quote['module'] . (!empty($method['title']) ? ' (' . $method['title'] . ')' : ''),
                          'cost' => $method['cost'],
                          'tax_class_id' => $quote['tax_class_id'],
                          'is_cheapest' => false);
          }
        }
      }

      if ( !empty($rate) ) {
        $rate['is_cheapest'] = true;
      }

      return $rate;
    }

    public function hasActive() {
      static $has_active;

      if ( !isset($has_active) ) {
        $has_active = false;

        foreach ( $this->_modules as $module ) {
          if (Registry::get('Shipping_' . $module)->isEnabled()) {
            $has_active = true;
            break;
          }
        }
      }

      return $has_active;
    }

    public function _calculate() {
      $this->_quotes = array();

      if ( is_array($this->_modules) ) {
        $include_quotes = array();

        if ( defined('MODULE_SHIPPING_FREE_STATUS') && isset($GLOBALS['Kuu_Shipping_free']) && $GLOBALS['Kuu_Shipping_free']->isEnabled() ) {
          $include_quotes[] = 'Kuu_Shipping_free';
        } else {
          foreach ( $this->_modules as $module ) {
            if ( Registry::get('Shipping_' . $module)->isEnabled() ) {
              $include_quotes[] = $module;
            }
          }
        }

        foreach ( $include_quotes as $module ) {
          $quotes = Registry::get('Shipping_' . $module)->quote();

          if ( is_array($quotes) ) {
            $this->_quotes[] = $quotes;
          }
        }
      }
    }
  }
?>
