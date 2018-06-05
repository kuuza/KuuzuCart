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

  namespace Kuuzu\KU\Core\Site\Admin\Application\ServerInfo\Model;

  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\DateTime;

  class getAll {
    public static function execute() {
      $result = array();

      $db_time = KUUZU::callDB('Admin\ServerInfo\GetTime');
      $db_uptime = KUUZU::callDB('Admin\ServerInfo\GetUptime');
      $db_version = KUUZU::callDB('Admin\ServerInfo\GetVersion');

      $uptime = '---';

      if ( !in_array('exec', explode(',', str_replace(' ', '', ini_get('disable_functions')))) ) {
        $uptime = @exec('uptime');
      }

      $data = array(array('key' => 'date',
                          'title' => KUUZU::getDef('field_server_date'),
                          'value' => DateTime::getShort(null, true)),
                    array('key' => 'system',
                          'title' => KUUZU::getDef('field_server_operating_system'),
                          'value' => php_uname('s') . ' ' . php_uname('r')),
                    array('key' => 'host',
                          'title' => KUUZU::getDef('field_server_host'),
                          'value' => php_uname('n') . ' (' . gethostbyname(php_uname('n')) . ')'),
                    array('key' => 'uptime',
                          'title' => KUUZU::getDef('field_server_up_time'),
                          'value' => $uptime),
                    array('key' => 'http_server',
                          'title' => KUUZU::getDef('field_http_server'),
                          'value' => $_SERVER['SERVER_SOFTWARE']),
                    array('key' => 'php',
                          'title' => KUUZU::getDef('field_php_version'),
                          'value' => 'PHP v' . PHP_VERSION . ' / Zend v' . zend_version()),
                    array('key' => 'db_server',
                          'title' => KUUZU::getDef('field_database_host'),
                          'value' => KUUZU::getConfig('db_server') . ' (' . gethostbyname(KUUZU::getConfig('db_server')) . ')'),
                    array('key' => 'db_version',
                          'title' => KUUZU::getDef('field_database_version'),
                          'value' => $db_version),
                    array('key' => 'db_date',
                          'title' => KUUZU::getDef('field_database_date'),
                          'value' => DateTime::getShort($db_time, true)),
                    array('key' => 'db_uptime',
                          'title' => KUUZU::getDef('field_database_up_time'),
                          'value' => $db_uptime));

      $result['entries'] = $data;

      $result['total'] = count($data);

      return $result;
    }
  }
?>
