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

  use Kuuzu\KU\Core\Site\Admin\Application\ProductAttributes\ProductAttributes;

/**
 * @since v3.0.3
 */

  class findUninstalled {
    public static function execute($search) {
      $modules = ProductAttributes::getUninstalled();

      $result = array('entries' => array());

      foreach ( $modules['entries'] as $module ) {
        if ( (stripos($module['code'], $search) !== false) || (stripos($module['title'], $search) !== false) ) {
          $result['entries'][] = $module;
        }
      }

      $result['total'] = count($result['entries']);

      return $result;
    }
  }
?>
