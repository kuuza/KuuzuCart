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

  namespace Kuuzu\KU\Core\Site\Admin\Application\CreditCards\Model;

  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Cache;

  class setStatus {
    public static function execute($id, $status) {
      $data = array('id' => $id,
                    'status' => $status);

      if ( KUUZU::callDB('Admin\CreditCards\SetStatus', $data) ) {
        Cache::clear('credit-cards');

        return true;
      }

      return false;
    }
  }
?>
