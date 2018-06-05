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

  use \Phar;
  use Kuuzu\KU\Core\KUUZU;

  class getPackageInfo {
    public static function execute($key = null) {
      $phar_can_open = true;

      try {
        $phar = new Phar(KUUZU::BASE_DIRECTORY . 'Work/CoreUpdate/update.phar');
      } catch ( \Exception $e ) {
        $phar_can_open = false;

        trigger_error($e->getMessage());
      }

      if ( $phar_can_open === true ) {
        $result = $phar->getMetadata();

        if ( isset($key) ) {
          $result = $result[$key] ?: null;
        }

        return $result;
      }

      return false;
    }
  }
?>
