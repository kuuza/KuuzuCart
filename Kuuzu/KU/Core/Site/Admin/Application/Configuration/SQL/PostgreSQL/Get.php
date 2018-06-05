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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Configuration\SQL\PostgreSQL;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class Get {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qgroup = $KUUZU_PDO->prepare('select * from :table_configuration_group where configuration_group_id = :configuration_group_id');
      $Qgroup->bindInt(':configuration_group_id', $data['id']);
      $Qgroup->execute();

      $result = $Qgroup->fetch();

      if ( $result !== false ) {
        $Qentries = $KUUZU_PDO->prepare('select count(*) as total_entries from :table_configuration where configuration_group_id = :configuration_group_id');
        $Qentries->bindInt(':configuration_group_id', $data['id']);
        $Qentries->execute();

        $result = array_merge($result, $Qentries->fetch());
      }

      return $result;
    }
  }
?>
