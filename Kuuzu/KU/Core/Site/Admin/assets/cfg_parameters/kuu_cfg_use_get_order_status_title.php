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

  function kuu_cfg_use_get_order_status_title($id) {
    $KUUZU_PDO = Registry::get('PDO');
    $KUUZU_Language = Registry::get('Language');

    if ( $id < 1 ) {
      return KUUZU::getDef('default_entry');
    }

    $Qstatus = $KUUZU_PDO->prepare('select orders_status_name from :table_orders_status where orders_status_id = :orders_status_id and language_id = :language_id');
    $Qstatus->bindInt(':orders_status_id', $id);
    $Qstatus->bindInt(':language_id', $KUUZU_Language->getID());
    $Qstatus->execute();

    return $Qstatus->value('orders_status_name');
  }
?>
