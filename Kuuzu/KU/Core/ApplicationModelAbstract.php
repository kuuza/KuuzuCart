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

  abstract class ApplicationModelAbstract {
    public static function __callStatic($name, $arguments) {
      $class = get_called_class();

      $ns = substr($class, 0, strrpos($class, '\\'));

      return call_user_func_array(array($ns . '\\Model\\' . $name, 'execute'), $arguments);
    }
  }
?>
