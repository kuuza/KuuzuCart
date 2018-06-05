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

  namespace Kuuzu\KU\Core\Site\Setup\Application\Install\Model;

  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\PDO;
  use Kuuzu\KU\Core\Registry;

  class checkDB {
    public static function execute($data) {
      if ( $KUUZU_PDO = PDO::initialize($data['server'], $data['username'], $data['password'], null, $data['port'], $data['class']) ) {
        Registry::set('PDO', $KUUZU_PDO);

        KUUZU::callDB('Setup\Install\CreateDB', array('database' => $data['database']));
      }

      return PDO::initialize($data['server'], $data['username'], $data['password'], $data['database'], $data['port'], $data['class']);
    }
  }
?>
