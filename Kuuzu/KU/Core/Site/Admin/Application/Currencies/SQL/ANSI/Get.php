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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Currencies\SQL\ANSI;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class Get {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $sql_query = 'select * from :table_currencies where';

      if ( is_numeric($data['id']) ) {
        $sql_query .= ' currencies_id = :currencies_id';
      } else {
        $sql_query .= ' code = :code';
      }

      $sql_query .= ' limit 1';

      $Qcurrency = $KUUZU_PDO->prepare($sql_query);

      if ( is_numeric($data['id']) ) {
        $Qcurrency->bindInt(':currencies_id', $data['id']);
      } else {
        $Qcurrency->bindValue(':code', $data['id']);
      }

      $Qcurrency->execute();

      return $Qcurrency->fetch();
    }
  }
?>
