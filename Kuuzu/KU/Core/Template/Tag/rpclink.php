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

  use Kuuzu\KU\Core\KUUZU;

  class rpclink extends \Kuuzu\KU\Core\Template\TagAbstract {
    static protected $_parse_result = false;

/**
 * @param string $string params|application|site
 */

    static public function execute($string) {
      $params = explode('|', $string, 3);

      if ( !isset($params[1]) ) {
        $params[1] = null;
      }

      if ( !isset($params[2]) ) {
        $params[2] = null;
      }

      return KUUZU::getRPCLink($params[2], $params[1], $params[0]);
    }
  }
?>
