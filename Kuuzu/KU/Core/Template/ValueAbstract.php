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

  namespace Kuuzu\KU\Core\Template;

  use Kuuzu\KU\Core\Registry;

  abstract class ValueAbstract {
    static public function initialize() {
      $KUUZU_Template = Registry::get('Template');

      $key = array_slice(explode('\\', get_called_class()), -2, 1);

      $KUUZU_Template->setValue($key[0], static::execute());
    }

/**
 * Not declared as an abstract static function as it freaks PHP 5.3 out
 */

    static public function execute() {
      return null;
    }
  }
?>
