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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Configuration\SQL\ANSI;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class EntryGet {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      if ( isset($data['key']) ) {
        $Qcfg = $KUUZU_PDO->prepare('select * from :table_configuration where configuration_key = :configuration_key');
        $Qcfg->bindValue(':configuration_key', $data['key']);
      } else {
        $Qcfg = $KUUZU_PDO->prepare('select * from :table_configuration where configuration_id = :configuration_id');
        $Qcfg->bindInt(':configuration_id', $data['id']);
      }

      $Qcfg->execute();

      return $Qcfg->fetch();
    }
  }
?>
