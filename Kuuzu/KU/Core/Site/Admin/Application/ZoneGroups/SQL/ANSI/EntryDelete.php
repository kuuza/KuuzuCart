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

  class EntryDelete {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qentry = $KUUZU_PDO->prepare('delete from :table_zones_to_geo_zones where association_id = :association_id');
      $Qentry->bindInt(':association_id', $data['id']);
      $Qentry->execute();

      return ( $Qentry->rowCount() === 1 );
    }
  }
?>
