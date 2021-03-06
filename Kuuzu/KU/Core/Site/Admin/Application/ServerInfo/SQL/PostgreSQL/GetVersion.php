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

  namespace Kuuzu\KU\Core\Site\Admin\Application\ServerInfo\SQL\PostgreSQL;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class GetVersion {
    public static function execute() {
      $KUUZU_PDO = Registry::get('PDO');

      $result = $KUUZU_PDO->query('show server_version')->fetch();

      return 'PostgreSQL v' . $result['server_version'];
    }
  }
?>
