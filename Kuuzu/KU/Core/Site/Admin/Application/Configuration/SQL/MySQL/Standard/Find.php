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

  class Find {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $result = array();

      $Qgroups = $KUUZU_PDO->prepare('select distinct cg.configuration_group_id, cg.configuration_group_title, count(c.configuration_id) as total_entries from :table_configuration_group cg, :table_configuration c where (c.configuration_key like :configuration_key or c.configuration_value like :configuration_value) and c.configuration_group_id = cg.configuration_group_id and cg.visible = 1 group by cg.configuration_group_id order by cg.sort_order, cg.configuration_group_title');
      $Qgroups->bindValue(':configuration_key', '%' . $data['search'] . '%');
      $Qgroups->bindValue(':configuration_value', '%' . $data['search'] . '%');
      $Qgroups->execute();

      $result['entries'] = $Qgroups->fetchAll();

      $result['total'] = count($result['entries']);

      return $result;
    }
  }
?>
