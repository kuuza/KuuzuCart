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

  namespace Kuuzu\KU\Core\Site\Admin\Application\CoreUpdate\Model;

  use Kuuzu\KU\Core\Site\Admin\Application\CoreUpdate\CoreUpdate;

  class findAvailablePackages {
    public static function execute($search) {
      $result = CoreUpdate::getAvailablePackages();

      foreach ( $result['entries'] as $k => $v ) {
        if ( strpos($v['version'], $search) === false ) {
          unset($result['entries'][$k]);
        }
      }

      $result['total'] = count($result['entries']);

      return $result;
    }
  }
?>
