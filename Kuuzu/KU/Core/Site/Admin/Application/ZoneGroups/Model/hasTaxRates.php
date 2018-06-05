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

  namespace Kuuzu\KU\Core\Site\Admin\Application\ZoneGroups\Model;

  use Kuuzu\KU\Core\KUUZU;

  class hasTaxRates {
    public static function execute($tax_zone_id) {
      $data = array('tax_zone_id' => $tax_zone_id);

      $result = KUUZU::callDB('Admin\ZoneGroups\GetTotalTaxRates', $data);

      return $result > 0;
    }
  }
?>
