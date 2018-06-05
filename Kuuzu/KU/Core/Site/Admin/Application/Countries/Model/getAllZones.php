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

  class getAllZones {
    public static function execute($country_id) {
      $data = array('country_id' => $country_id);

      return KUUZU::callDB('Admin\Countries\ZoneGetAll', $data);
    }
  }
?>
