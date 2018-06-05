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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Languages\SQL\PostgreSQL;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class FindDefinitions {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $result = array();

      $Qdefs = $KUUZU_PDO->prepare('select * from :table_languages_definitions where languages_id = :languages_id and content_group = :content_group and (definition_key ilike :definition_key or definition_value ilike :definition_value) order by definition_key');
      $Qdefs->bindInt(':languages_id', $data['id']);
      $Qdefs->bindValue(':content_group', $data['group']);
      $Qdefs->bindValue(':definition_key', '%' . $data['keywords'] . '%');
      $Qdefs->bindValue(':definition_value', '%' . $data['keywords'] . '%');
      $Qdefs->execute();

      $result['entries'] = $Qdefs->fetchAll();

      $result['total'] = count($result['entries']);

      return $result;
    }
  }
?>
