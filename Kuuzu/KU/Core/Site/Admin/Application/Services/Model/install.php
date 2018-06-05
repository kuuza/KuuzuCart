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

  class install {
    public static function execute($module) {
      $class = 'Kuuzu\\KU\\Core\\Site\\Admin\\Module\\Service\\' . $module;

      if ( class_exists($class) ) {
        $KUUZU_SM = new $class();
        $KUUZU_SM->install();

        $sm = explode(';', MODULE_SERVICES_INSTALLED);

        if ( isset($KUUZU_SM->depends) ) {
          if ( is_string($KUUZU_SM->depends) && ( ( $key = array_search($KUUZU_SM->depends, $sm) ) !== false ) ) {
            if ( isset($sm[$key+1]) ) {
              array_splice($sm, $key+1, 0, $module);
            } else {
              $sm[] = $module;
            }
          } elseif ( is_array($KUUZU_SM->depends) ) {
            foreach ( $KUUZU_SM->depends as $depends_module ) {
              if ( ( $key = array_search($depends_module, $sm) ) !== false ) {
                if ( !isset($array_position) || ( $key > $array_position ) ) {
                  $array_position = $key;
                }
              }
            }

            if ( isset($array_position) ) {
              array_splice($sm, $array_position+1, 0, $module);
            } else {
              $sm[] = $module;
            }
          }
        } elseif ( isset($KUUZU_SM->precedes) ) {
          if ( is_string($KUUZU_SM->precedes) ) {
            if ( ( $key = array_search($KUUZU_SM->precedes, $sm) ) !== false ) {
              array_splice($sm, $key, 0, $module);
            } else {
              $sm[] = $module;
            }
          } elseif ( is_array($KUUZU_SM->precedes) ) {
            foreach ( $KUUZU_SM->precedes as $precedes_module ) {
              if ( ( $key = array_search($precedes_module, $sm) ) !== false ) {
                if ( !isset($array_position) || ( $key < $array_position ) ) {
                  $array_position = $key;
                }
              }
            }

            if ( isset($array_position) ) {
              array_splice($sm, $array_position, 0, $module);
            } else {
              $sm[] = $module;
            }
          }
        } else {
          $sm[] = $module;
        }

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
