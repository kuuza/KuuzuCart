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

  namespace Kuuzu\KU\Core\Site\Admin\Application\ZoneGroups\SQL\ANSI;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class EntrySave {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      if ( isset($data['id']) && is_numeric($data['id']) ) {
        $Qentry = $KUUZU_PDO->prepare('update :table_zones_to_geo_zones set zone_country_id = :zone_country_id, zone_id = :zone_id, last_modified = now() where association_id = :association_id');
        $Qentry->bindInt(':association_id', $data['id']);
      } else {
        $Qentry = $KUUZU_PDO->prepare('insert into :table_zones_to_geo_zones (zone_country_id, zone_id, geo_zone_id, date_added) values (:zone_country_id, :zone_id, :geo_zone_id, now())');
        $Qentry->bindInt(':geo_zone_id', $data['group_id']);
      }

      if ( is_numeric($data['country_id']) ) {
        $Qentry->bindInt(':zone_country_id', $data['country_id']);
      } else {
        $Qentry->bindNull(':zone_country_id');
      }

      if ( is_numeric($data['zone_id']) ) {
        $Qentry->bindInt(':zone_id', $data['zone_id']);
      } else {
        $Qentry->bindNull(':zone_id');
      }

      $Qentry->execute();

      return ( ($Qentry->rowCount() === 1) || !$Qentry->isError() );
    }
  }
?>
