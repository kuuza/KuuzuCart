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

  namespace Kuuzu\KU\Core;

  use Kuuzu\KU\Core\KUUZU;

/**
 * The Session class initializes the session storage handler
 */

  class Session {

/**
 * Loads the session storage handler
 *
 * @param string $name The name of the session
 * @access public
 */

    public static function load($name = null) {
      $class_name = 'Kuuzu\\KU\\Core\\Session\\' . KUUZU::getConfig('store_sessions');

      if ( !class_exists($class_name) ) {
        trigger_error('Session Handler \'' . $class_name . '\' does not exist, using default \'Kuuzu\\KU\\Core\\Session\\File\'', E_USER_ERROR);

        $class_name = 'Kuuzu\\KU\\Core\\Session\\File';
      }

      $obj = new $class_name();

      if ( !isset($name) ) {
        $name = 'sid';
      }

      $obj->setName($name);
      $obj->setLifeTime(ini_get('session.gc_maxlifetime'));

      return $obj;
    }
  }
?>
