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

  class link extends \Kuuzu\KU\Core\Template\TagAbstract {
    static protected $_parse_result = false;

    static public function execute($string) {
      $params = explode('|', $string);

      if ( !isset($params[1]) ) {
        $params[1] = null;
      }

      if ( !isset($params[2]) ) {
        $params[2] = null;
      }

      $tmp = $params[1];
      $params[1] = $params[0];
      $params[0] = $tmp;

      if ( isset($params[4]) ) {
        if ( strtolower($params[4]) == 'true' ) {
          $params[4] = true;
        } elseif ( strtolower($params[4]) == 'false' ) {
          $params[4] = false;
        }
      }

      if ( isset($params[5]) ) {
        if ( strtolower($params[5]) == 'true' ) {
          $params[5] = true;
        } elseif ( strtolower($params[5]) == 'false' ) {
          $params[5] = false;
        }
      }

      return call_user_func_array('Kuuzu\KU\Core\KUUZU::getLink', $params);
    }
  }
?>
