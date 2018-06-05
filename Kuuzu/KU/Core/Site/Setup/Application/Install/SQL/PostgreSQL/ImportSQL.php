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

  namespace Kuuzu\KU\Core\Site\Setup\Application\Install\SQL\PostgreSQL;

  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

  class ImportSQL {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $sql_file = KUUZU::BASE_DIRECTORY . 'Core/Site/Setup/sql/PostgreSQL/core.sql';

      return $KUUZU_PDO->importSQL($sql_file, $data['table_prefix']);
    }
  }
?>
