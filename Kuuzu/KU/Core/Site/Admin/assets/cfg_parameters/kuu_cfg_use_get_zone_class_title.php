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

  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;

  function kuu_cfg_use_get_zone_class_title($id) {
    $KUUZU_PDO = Registry::get('PDO');
    $KUUZU_Language = Registry::get('Language');

    if ( $id == '0' ) {
      return KUUZU::getDef('parameter_none');
    }

    $Qclass = $KUUZU_PDO->prepare('select geo_zone_name from :table_geo_zones where geo_zone_id = :geo_zone_id');
    $Qclass->bindInt(':geo_zone_id', $id);
    $Qclass->execute();

    return $Qclass->value('geo_zone_name');
  }
?>
