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

  namespace Kuuzu\KU\Core\Site\Admin\Application\TaxClasses\SQL\ANSI;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class EntryGet {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qrates = $KUUZU_PDO->prepare('select tr.*, tc.tax_class_title, z.geo_zone_id, z.geo_zone_name from :table_tax_rates tr, :table_tax_class tc, :table_geo_zones z where tr.tax_rates_id = :tax_rates_id and tr.tax_class_id = tc.tax_class_id and tr.tax_zone_id = z.geo_zone_id');
      $Qrates->bindInt(':tax_rates_id', $data['id']);
      $Qrates->execute();

      return $Qrates->fetch();
    }
  }
?>
