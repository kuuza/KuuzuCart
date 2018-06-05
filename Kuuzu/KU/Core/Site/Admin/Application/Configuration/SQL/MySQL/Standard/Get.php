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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Configuration\SQL\MySQL\Standard;

  use Kuuzu\KU\Core\Registry;

  class Get {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qgroup = $KUUZU_PDO->prepare('select cg.*, count(c.configuration_id) as total_entries from :table_configuration_group cg left join :table_configuration c on (cg.configuration_group_id = c.configuration_group_id) where cg.configuration_group_id = :configuration_group_id');
      $Qgroup->bindInt(':configuration_group_id', $data['id']);
      $Qgroup->execute();

      return $Qgroup->fetch();
    }
  }
?>
