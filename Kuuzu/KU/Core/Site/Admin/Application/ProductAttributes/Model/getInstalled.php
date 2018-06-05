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

  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;

/**
 * @since v3.0.3
 */

  class getInstalled {
    public static function execute() {
      $result = KUUZU::callDB('Admin\ProductAttributes\GetAll');

      foreach ( $result['entries'] as &$module ) {
        $class = 'Kuuzu\\KU\\Core\\Site\\Admin\\Module\\ProductAttribute\\' . $module['code'];

        $KUUZU_PA = new $class();

        $module['title'] = $KUUZU_PA->getTitle();
      }

      return $result;
    }
  }
?>
