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

  abstract class TemplateAbstract {
    static protected $_parent;
    static protected $_base_filename = 'base.html';

    static public function getBaseFilename() {
      return static::$_base_filename;
    }

    static public function hasParent() {
      return isset(static::$_parent);
    }

    static public function getParent() {
      return static::$_parent;
    }
  }
?>
