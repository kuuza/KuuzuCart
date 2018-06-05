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

  class widget extends \Kuuzu\KU\Core\Template\TagAbstract {
    static public function execute($string) {
      $params = explode('|', $string, 2);

      if ( !isset($params[1]) ) {
        $params[1] = null;
      }

      $widget = $params[0];

      $class = null;

      if ( class_exists('Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Application\\' . KUUZU::getSiteApplication() . '\\Module\\Template\\Widget\\' . $widget . '\\Controller') ) {
        $class = 'Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Application\\' . KUUZU::getSiteApplication() . '\\Module\\Template\\Widget\\' . $widget . '\\Controller';
      } elseif ( class_exists('Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Module\\Template\\Widget\\' . $widget . '\\Controller') ) {
        $class = 'Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Module\\Template\\Widget\\' . $widget . '\\Controller';
      }

      if ( isset($class) ) {
        if ( is_subclass_of($class, 'Kuuzu\\KU\\Core\\Template\\WidgetAbstract') ) {
          return call_user_func(array($class, 'initialize'), $params[1]);
        } else {
          trigger_error('Template Widget {' . $widget . '} is not subclass of Kuuzu\\KU\\Core\\Template\\WidgetAbstract for ' . KUUZU::getSite());
        }
      } else {
        trigger_error('Template Widget {' . $widget . '} does not exist for ' . KUUZU::getSite());
      }

      return false;
    }
  }
?>
