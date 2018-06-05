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

  class EntryGetAll {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $result = array('entries' => array());

      $Qcfg = $KUUZU_PDO->prepare('select * from :table_configuration where configuration_group_id = :configuration_group_id order by sort_order, configuration_title');
      $Qcfg->bindInt(':configuration_group_id', $data['group_id']);
      $Qcfg->execute();

      $result['entries'] = $Qcfg->fetchAll();

      $result['total'] = count($result['entries']);

      return $result;
    }
  }
?>
