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

  namespace Kuuzu\KU\Core\Site\Admin\Application\ServerInfo\SQL\MySQL\Standard;

  use Kuuzu\KU\Core\Registry;

  class GetUptime {
    public static function execute() {
      $KUUZU_PDO = Registry::get('PDO');

      $result = $KUUZU_PDO->query('show status like "Uptime"')->fetch();

      return intval($result['Value'] / 3600) . ':' . str_pad(intval(($result['Value'] / 60) % 60), 2, '0', STR_PAD_LEFT);
    }
  }
?>
