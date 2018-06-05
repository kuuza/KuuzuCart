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
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

  class loop extends \Kuuzu\KU\Core\Template\TagAbstract {
    static protected $_parse_result = false;

    static public function execute($string) {
      $args = func_get_args();

      $KUUZU_Template = Registry::get('Template');

      $key = trim($args[1]);

      if ( !$KUUZU_Template->valueExists($key) ) {
        if ( class_exists('Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Application\\' . KUUZU::getSiteApplication() . '\\Module\\Template\\Value\\' . $key . '\\Controller') && is_subclass_of('Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Application\\' . KUUZU::getSiteApplication() . '\\Module\\Template\\Value\\' . $key . '\\Controller', 'Kuuzu\\KU\\Core\\Template\\ValueAbstract') ) {
          call_user_func(array('Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Application\\' . KUUZU::getSiteApplication() . '\\Module\\Template\\Value\\' . $key . '\\Controller', 'initialize'));
        } elseif ( class_exists('Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Module\\Template\\Value\\' . $key . '\\Controller') && is_subclass_of('Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Module\\Template\\Value\\' . $key . '\\Controller', 'Kuuzu\\KU\\Core\\Template\\ValueAbstract') ) {
          call_user_func(array('Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Module\\Template\\Value\\' . $key . '\\Controller', 'initialize'));
        }
      }

      $data = $KUUZU_Template->getValue($key);

      if ( isset($args[2]) ) {
        $data = $data[$args[2]];
      }

      $result = '';

      if ( !empty($data) ) {
        foreach ( $data as $d ) {
          $result .= preg_replace_callback('/([#|%])([a-zA-Z0-9_-]+)\1/', function ($matches) use (&$d) {
                       if ( substr($matches[0], 0, 1) == '%' ) {
                         return ( isset($d[$matches[2]]) ? $d[$matches[2]] : $matches[0] );
                       } else {
                         return ( isset($d[$matches[2]]) ? HTML::outputProtected($d[$matches[2]]) : $matches[0] );
                       }
                     }, $string);
        }
      }

      return $result;
    }
  }
?>
