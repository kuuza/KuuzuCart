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

  namespace Kuuzu\KU\Core\PDO\Microsoft;

  class SqlServer extends \Kuuzu\KU\Core\PDO {
    public function __construct($server, $username, $password, $database, $port, $driver_options) {
      $this->_server = $server;
      $this->_username = $username;
      $this->_password = $password;
      $this->_database = $database;
      $this->_port = $port;
      $this->_driver_options = $driver_options;
    }

    public function connect() {
      $dsn = 'sqlsrv:Server=' . $this->_server;

      if ( !empty($this->_port) ) {
        $dsn .= ', ' . $this->_port;
      }

      $dsn .= '; Database=' . $this->_database;

      $this->_instance = new \PDO($dsn, $this->_username, $this->_password, $this->_driver_options);
    }
  }
?>
