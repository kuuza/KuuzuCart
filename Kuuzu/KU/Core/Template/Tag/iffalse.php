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
  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class iffalse extends \Kuuzu\KU\Core\Template\TagAbstract {
    static protected $_parse_result = false;

    static public function execute($string) {
      $args = func_get_args();

      $KUUZU_Template = Registry::get('Template');

      $key = trim($args[1]);

      if ( strpos($key, ' ') !== false ) {
        list($key, $entry) = explode(' ', $key, 2);
      }

      if ( !$KUUZU_Template->valueExists($key) ) {
        if ( class_exists('Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Application\\' . KUUZU::getSiteApplication() . '\\Module\\Template\\Value\\' . $key . '\\Controller') && is_subclass_of('Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Application\\' . KUUZU::getSiteApplication() . '\\Module\\Template\\Value\\' . $key . '\\Controller', 'Kuuzu\\KU\\Core\\Template\\ValueAbstract') ) {
          call_user_func(array('Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Application\\' . KUUZU::getSiteApplication() . '\\Module\\Template\\Value\\' . $key . '\\Controller', 'initialize'));
        } elseif ( class_exists('Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Module\\Template\\Value\\' . $key . '\\Controller') && is_subclass_of('Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Module\\Template\\Value\\' . $key . '\\Controller', 'Kuuzu\\KU\\Core\\Template\\ValueAbstract') ) {
          call_user_func(array('Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Module\\Template\\Value\\' . $key . '\\Controller', 'initialize'));
        }
      }

      $is_false = false;

      if ( $KUUZU_Template->valueExists($key) ) {
        $value = $KUUZU_Template->getValue($key);

        if ( isset($entry) && is_array($value) ) {
          if ( isset($value[$entry]) && is_bool($value[$entry]) && ($value[$entry] === false) ) {
            $is_false = true;
          }
        } elseif ( is_bool($value) && ($value === false) ) {
          $is_false = true;
        }
      }

      $has_else = strpos($string, '{else}');

      $result = '';

      if ( $has_else !== false ) {
        if ( $is_false === true ) {
          $result = substr($string, 0, $has_else);
        } else {
          $result = substr($string, $has_else + 6); // strlen('{else}')==6
        }
      } elseif ( $is_false === true ) {
        $result = $string;
      }

      return $result;
    }
  }
?>
