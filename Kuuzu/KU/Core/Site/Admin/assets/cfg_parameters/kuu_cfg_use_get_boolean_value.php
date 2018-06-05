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

  use Kuuzu\KU\Core\KUUZU;

  function kuu_cfg_use_get_boolean_value($string) {
    switch ($string) {
      case -1:
      case '-1':
        return KUUZU::getDef('parameter_false');
        break;

      case 0:
      case '0':
        return KUUZU::getDef('parameter_optional');
        break;

      case 1:
      case '1':
        return KUUZU::getDef('parameter_true');
        break;

      default:
        return $string;
        break;
    }
  }
?>
