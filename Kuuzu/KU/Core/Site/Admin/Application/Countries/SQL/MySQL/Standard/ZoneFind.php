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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Countries\SQL\MySQL\Standard;

  use Kuuzu\KU\Core\Registry;

  class ZoneFind {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $result = array();

      $Qzones = $KUUZU_PDO->prepare('select * from :table_zones where zone_country_id = :zone_country_id and (zone_name like :zone_name or zone_code like :zone_code) order by zone_name');
      $Qzones->bindInt(':zone_country_id', $data['country_id']);
      $Qzones->bindValue(':zone_name', '%' . $data['keywords'] . '%');
      $Qzones->bindValue(':zone_code', '%' . $data['keywords'] . '%');
      $Qzones->execute();

      $result['entries'] = $Qzones->fetchAll();

      $result['total'] = count($result['entries']);

      return $result;
    }
  }
?>
