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

  use Kuuzu\KU\Core\Registry;

  class parse extends \Kuuzu\KU\Core\Template\TagAbstract {
    static protected $_parse_result = false;

    static public function execute($string) {
      $KUUZU_Template = Registry::get('Template');

      $args = func_get_args();

      $whitelist = null;

      if ( isset($args[1]) ) {
        $whitelist_string = trim($args[1]);

        if ( !empty($whitelist_string) ) {
          $whitelist = explode(' ', $whitelist_string);
        }
      }

      return $KUUZU_Template->parseContent($string, $whitelist);
    }
  }
?>
