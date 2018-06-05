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

  namespace Kuuzu\KU\Core\Site\Shop\Module\Service;

  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Language as LanguageClass;

  class Language implements \Kuuzu\KU\Core\Site\Shop\ServiceInterface {
    public static function start() {
      Registry::set('Language', new LanguageClass());

      $KUUZU_Language = Registry::get('Language');

      if ( isset($_GET['language']) && !empty($_GET['language']) ) {
        $KUUZU_Language->set($_GET['language']);
      }

      $KUUZU_Language->load('general');
      $KUUZU_Language->load('modules-boxes');
      $KUUZU_Language->load('modules-content');

      $KUUZU_Language->load(KUUZU::getSiteApplication());

      header('Content-Type: text/html; charset=' . $KUUZU_Language->getCharacterSet());

      return true;
    }

    public static function stop() {
      return true;
    }
  }
?>
