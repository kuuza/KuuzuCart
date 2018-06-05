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

/**
 * @since v3.0.3
 */

  class formprotect extends \Kuuzu\KU\Core\Template\TagAbstract {
    static protected $_parse_result = false;

    static public function execute($string) {
      $KUUZU_Template = Registry::get('Template');

      if ( !$KUUZU_Template->valueExists($string) ) {
        if ( class_exists('Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Application\\' . KUUZU::getSiteApplication() . '\\Module\\Template\\Value\\' . $string . '\\Controller') && is_subclass_of('Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Application\\' . KUUZU::getSiteApplication() . '\\Module\\Template\\Value\\' . $string . '\\Controller', 'Kuuzu\\KU\\Core\\Template\\ValueAbstract') ) {
          call_user_func(array('Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Application\\' . KUUZU::getSiteApplication() . '\\Module\\Template\\Value\\' . $string . '\\Controller', 'initialize'));
        } elseif ( class_exists('Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Module\\Template\\Value\\' . $string . '\\Controller') && is_subclass_of('Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Module\\Template\\Value\\' . $string . '\\Controller', 'Kuuzu\\KU\\Core\\Template\\ValueAbstract') ) {
          call_user_func(array('Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Module\\Template\\Value\\' . $string . '\\Controller', 'initialize'));
        }
      }

      $result = '';

      if ( $KUUZU_Template->valueExists($string) ) {
        $result = HTML::hiddenField($string, md5($KUUZU_Template->getValue($string)));
      }

      return $result;
    }
  }
?>
