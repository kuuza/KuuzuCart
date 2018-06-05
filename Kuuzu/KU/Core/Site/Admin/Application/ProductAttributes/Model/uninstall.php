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

  namespace Kuuzu\KU\Core\Site\Admin\Application\ProductAttributes\Model;

/**
 * @since v3.0.3
 */

  class uninstall {
    public static function execute($module) {
      $class = 'Kuuzu\\KU\\Core\\Site\\Admin\\Module\\ProductAttribute\\' . $module;

      if ( class_exists($class) ) {
        $KUUZU_PA = new $class();
        $KUUZU_PA->uninstall();

        return true;
      }

      return false;
    }
  }
?>
