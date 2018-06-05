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

  namespace Kuuzu\KU\Core\Site\Shop\Module\Service;

  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Shop\Customer;
  use Kuuzu\KU\Core\Site\Shop\Tax;
  use Kuuzu\KU\Core\Site\Shop\Weight;
  use Kuuzu\KU\Core\Site\Shop\ShoppingCart;
  use Kuuzu\KU\Core\Site\Shop\NavigationHistory;
  use Kuuzu\KU\Core\Site\Shop\Image;

  class Core implements \Kuuzu\KU\Core\Site\Shop\ServiceInterface {
    public static function start() {
      Registry::set('Customer', new Customer());

      Registry::set('Tax', new Tax());

      Registry::set('Weight', new Weight());

      Registry::set('ShoppingCart', new ShoppingCart());
      Registry::get('ShoppingCart')->refresh();

      Registry::set('NavigationHistory', new NavigationHistory(true));

      Registry::set('Image', new Image());

      return true;
    }

    public static function stop() {
      return true;
    }
  }
?>
