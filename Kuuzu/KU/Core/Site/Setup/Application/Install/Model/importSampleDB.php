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

  class importSampleDB {
    public static function execute($data) {
      Registry::set('PDO', PDO::initialize($data['server'], $data['username'], $data['password'], $data['database'], $data['port'], $data['class']));

      KUUZU::callDB('Setup\Install\ImportSampleSQL', array('table_prefix' => $data['table_prefix']));
    }
  }
?>
