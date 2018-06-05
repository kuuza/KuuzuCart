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

  namespace Kuuzu\KU\Core\Template\Tag;

  use Kuuzu\KU\Core\HTML;

  class post extends \Kuuzu\KU\Core\Template\TagAbstract {
    static protected $_parse_result = false;

    static public function execute($string) {
      if ( strpos($string, '|') !== false ) {
        list($string, $default) = explode('|', $string, 2);
      }

      if ( isset($_POST[$string]) ) {
        return HTML::outputProtected($_POST[$string]);
      } elseif ( isset($default) ) {
        return value::execute($default);
      }

      return null;
    }
  }
?>
