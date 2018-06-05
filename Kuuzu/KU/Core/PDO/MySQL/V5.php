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

  namespace Kuuzu\KU\Core\PDO\MySQL;

  class V5 extends \Kuuzu\KU\Core\PDO\MySQL\Standard {
    protected $_has_native_fk = true;
    protected $_driver_parent = 'MySQL\\Standard';

    public function connect() {
// STRICT_ALL_TABLES introduced in MySQL v5.0.2
// Only one init command can be issued (see http://bugs.php.net/bug.php?id=48859)
      $this->_driver_options[\PDO::MYSQL_ATTR_INIT_COMMAND] = 'set session sql_mode="STRICT_ALL_TABLES"';

      parent::connect();
    }
  }
?>
