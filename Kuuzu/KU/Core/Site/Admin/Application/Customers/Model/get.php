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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Customers\Model;

  use Kuuzu\KU\Core\KUUZU;

/**
 * @since v3.0.2
 */

  class get {
    public static function execute($id, $key = null) {
      $data = array('id' => $id);

      $result = KUUZU::callDB('Admin\Customers\Get', $data);

      if ( isset($key) ) {
        $result = $result[$key] ?: null;
      }

      return $result;
    }
  }
?>
