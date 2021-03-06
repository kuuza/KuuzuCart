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

  class canApplyPackage {
    public static function execute() {
      $contents = CoreUpdate::getPackageContents();

      foreach ( $contents['entries'] as $file ) {
        if ( $file['writable'] === false ) {
          return false;
        }
      }

      return true;
    }
  }
?>
