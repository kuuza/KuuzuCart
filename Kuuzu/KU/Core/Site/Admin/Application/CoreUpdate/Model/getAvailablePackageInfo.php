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

  class getAvailablePackageInfo {
    public static function execute($key = null) {
      $versions = CoreUpdate::getAvailablePackages();

      if ( !empty($versions['entries']) ) {
        if ( !empty($key) && isset($versions['entries'][0][$key]) ) {
          return $versions['entries'][0][$key];
        } else {
          return $versions['entries'][0];
        }
      }

      return false;
    }
  }
?>
