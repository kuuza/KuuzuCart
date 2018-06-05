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

  function kuu_cfg_use_get_tax_class_title($id) {
    $KUUZU_PDO = Registry::get('PDO');
    $KUUZU_Language = Registry::get('Language');

    if ( $id < 1 ) {
      return KUUZU::getDef('parameter_none');
    }

    $Qclass = $KUUZU_PDO->prepare('select tax_class_title from :table_tax_class where tax_class_id = :tax_class_id');
    $Qclass->bindInt(':tax_class_id', $id);
    $Qclass->execute();

    return $Qclass->value('tax_class_title');
  }
?>
