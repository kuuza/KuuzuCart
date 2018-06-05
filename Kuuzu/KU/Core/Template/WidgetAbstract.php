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

  abstract class WidgetAbstract {
    static public function initialize($param = null) {
      $widget = array_slice(explode('\\', get_called_class()), -2, 1);

      Registry::get('Language')->loadIniFile('Modules/Template/Widgets/' . $widget[0] . '.php');

      return static::execute($param);
    }

/**
 * Not declared as an abstract static function as it freaks PHP 5.3 out
 */

    static public function execute($param = null) {
      return false;
    }
  }
?>
