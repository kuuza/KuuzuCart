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

  namespace Kuuzu\KU\Core\Site\Admin\Application\ZoneGroups\SQL\PostgreSQL;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class Get {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qzone = $KUUZU_PDO->prepare('select gz.*, (select count(*) from :table_zones_to_geo_zones z2gz where z2gz.geo_zone_id = gz.geo_zone_id) as total_entries from :table_geo_zones gz where gz.geo_zone_id = :geo_zone_id');
      $Qzone->bindInt(':geo_zone_id', $data['id']);
      $Qzone->execute();

      return $Qzone->fetch();
    }
  }
?>
