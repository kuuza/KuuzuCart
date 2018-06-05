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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Languages\SQL\MySQL\Standard;

  use Kuuzu\KU\Core\Registry;

  class Get {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $sql_query = 'select l.*, count(ld.languages_id) as total_definitions from :table_languages l left join :table_languages_definitions ld on (l.languages_id = ld.languages_id) where';

      if ( is_numeric($data['id']) ) {
        $sql_query .= ' l.languages_id = :languages_id';
      } else {
        $sql_query .= ' l.code = :code';
      }

      $sql_query .= ' limit 1';

      $Qlanguage = $KUUZU_PDO->prepare($sql_query);

      if ( is_numeric($data['id']) ) {
        $Qlanguage->bindInt(':languages_id', $data['id']);
      } else {
        $Qlanguage->bindValue(':code', $data['id']);
      }

      $Qlanguage->execute();

      return $Qlanguage->fetch();
    }
  }
?>
