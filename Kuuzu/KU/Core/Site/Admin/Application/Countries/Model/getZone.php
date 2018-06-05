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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Countries\Model;

  use Kuuzu\KU\Core\KUUZU;

  class getZone {
    public static function execute($id) {
      $data = array('id' => $id);

      return KUUZU::callDB('Admin\Countries\ZoneGet', $data);
    }
  }
?>
