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

  class GetDefinitions {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $result = array();

      $sql_query = 'select * from :table_languages_definitions where languages_id = :languages_id and';

      if ( is_array($data['group']) ) {
        $sql_query .= ' content_group in (\'' . implode('\', \'', $data['group']) . '\')';
      } else {
        $sql_query .= ' content_group = :content_group';
      }

      $sql_query .= ' order by content_group, definition_key';

      $Qdefs = $KUUZU_PDO->prepare($sql_query);

      if ( !is_array($data['group']) ) {
        $Qdefs->bindValue(':content_group', $data['group']);
      }

      $Qdefs->bindInt(':languages_id', $data['id']);
      $Qdefs->execute();

      $result['entries'] = $Qdefs->fetchAll();

      $result['total'] = count($result['entries']);

      return $result;
    }
  }
?>
