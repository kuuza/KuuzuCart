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

  namespace Kuuzu\KU\Core\Site\Setup\Application\Install\SQL\MySQL\Standard;

  use Kuuzu\KU\Core\Registry;

  class CreateDB {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      return ($KUUZU_PDO->exec('create database if not exists `' . $data['database'] . '` CHARACTER SET utf8 COLLATE utf8_general_ci') !== false);
    }
  }
?>
