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

  namespace Kuuzu\KU\Core\Site\Admin\Application\ZoneGroups\SQL\MySQL\Standard;

  use Kuuzu\KU\Core\Registry;

  class EntryFind {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $result = array();

      $Qentries = $KUUZU_PDO->prepare('select z2gz.*, c.countries_name, z.zone_name from :table_zones_to_geo_zones z2gz, :table_countries c, :table_zones z where z2gz.geo_zone_id = :geo_zone_id and z2gz.zone_country_id = c.countries_id and z2gz.zone_id = z.zone_id and (c.countries_name like :countries_name or z.zone_name like :zone_name) order by c.countries_name, z.zone_name');
      $Qentries->bindInt(':geo_zone_id', $data['group_id']);
      $Qentries->bindValue(':countries_name', '%' . $data['keywords'] . '%');
      $Qentries->bindValue(':zone_name', '%' . $data['keywords'] . '%');
      $Qentries->execute();

      $result['entries'] = $Qentries->fetchAll();

      $result['total'] = count($result['entries']);

      return $result;
    }
  }
?>
