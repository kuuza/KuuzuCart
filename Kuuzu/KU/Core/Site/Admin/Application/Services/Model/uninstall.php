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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Services\Model;

  use Kuuzu\KU\Core\Cache;
  use Kuuzu\KU\Core\KUUZU;

/**
 * @since v3.0.2
 */

  class uninstall {
    public static function execute($module) {
      $class = 'Kuuzu\\KU\\Core\\Site\\Admin\\Module\\Service\\' . $module;

      if ( class_exists($class) ) {
        $KUUZU_SM = new $class();
        $KUUZU_SM->remove();

        $sm = explode(';', MODULE_SERVICES_INSTALLED);

        unset($sm[array_search($module, $sm)]);

        $data = array('key' => 'MODULE_SERVICES_INSTALLED',
                      'value' => implode(';', $sm));

        if ( KUUZU::callDB('Admin\Configuration\EntrySave', $data) ) {
          Cache::clear('configuration');

          return true;
        }
      }

      return false;
    }
  }
?>
