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

  namespace Kuuzu\KU\Core\Site\Admin\Application\PaymentModules\Model;

  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Cache;

  class install {
    public static function execute($module) {
      $KUUZU_Language = Registry::get('Language');

      $class = 'Kuuzu\\KU\\Core\\Site\\Admin\\Module\\Payment\\' . $module;

      if ( class_exists($class) ) {
        $KUUZU_Language->injectDefinitions('modules/payment/' . $module . '.xml');

        $KUUZU_PM = new $class();
        $KUUZU_PM->install();

        Cache::clear('modules-payment');
        Cache::clear('configuration');

        return true;
      }

      return false;
    }
  }
?>
