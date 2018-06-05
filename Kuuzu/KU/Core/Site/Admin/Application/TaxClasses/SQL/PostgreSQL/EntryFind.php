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

  namespace Kuuzu\KU\Core\Site\Admin\Application\TaxClasses\SQL\PostgreSQL;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class EntryFind {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $result = array();

      $Qrates = $KUUZU_PDO->prepare('select tr.*, z.geo_zone_id, z.geo_zone_name from :table_tax_rates tr, :table_geo_zones z where tr.tax_class_id = :tax_class_id and tr.tax_zone_id = z.geo_zone_id and (tr.tax_description ilike :tax_description) order by tr.tax_priority, z.geo_zone_name');
      $Qrates->bindInt(':tax_class_id', $data['tax_class_id']);
      $Qrates->bindValue(':tax_description', '%' . $data['keywords'] . '%');
      $Qrates->execute();

      $result['entries'] = $Qrates->fetchAll();

      $result['total'] = count($result['entries']);

      return $result;
    }
  }
?>
