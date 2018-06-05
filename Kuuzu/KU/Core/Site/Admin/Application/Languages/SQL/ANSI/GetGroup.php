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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Languages\SQL\ANSI;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class GetGroup {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $result = array();

      $Qgroup = $KUUZU_PDO->prepare('select languages_id, count(*) as total_entries from :table_languages_definitions where content_group = :content_group group by languages_id');
      $Qgroup->bindValue(':content_group', $data['group']);
      $Qgroup->execute();

      $result['entries'] = $Qgroup->fetchAll();

      $result['total'] = count($result['entries']);

      return $result;
    }
  }
?>
