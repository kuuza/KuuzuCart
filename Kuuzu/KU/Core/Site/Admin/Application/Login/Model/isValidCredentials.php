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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Login\Model;

  use Kuuzu\KU\Core\Hash;
  use Kuuzu\KU\Core\KUUZU;

  class isValidCredentials {
    public static function execute($data) {
      $result = KUUZU::callDB('Admin\Login\GetAdmin', array('username' => $data['username']));

      if ( !empty($result) ) {
        return Hash::validate($data['password'], $result['user_password']);
      }

      return false;
    }
  }
?>
