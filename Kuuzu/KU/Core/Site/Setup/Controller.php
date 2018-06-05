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

  namespace Kuuzu\KU\Core\Site\Setup;

  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

  class Controller implements \Kuuzu\KU\Core\SiteInterface {
    protected static $_default_application = 'Index';

    public static function initialize() {
      Registry::set('Language', new Language());
      Registry::set('Kuu_Language', Registry::get('Language')); // HPDL to remove

      if ( !self::hasAccess(KUUZU::getSiteApplication()) ) {
        KUUZU::redirect(KUUZU::getLink(null, 'Offline'));
      }

      $application = 'Kuuzu\\KU\\Core\\Site\\Setup\\Application\\' . KUUZU::getSiteApplication() . '\\Controller';
      Registry::set('Application', new $application());

      Registry::set('Template', new Template());
      Registry::get('Template')->setApplication(Registry::get('Application'));
    }

    public static function getDefaultApplication() {
      return self::$_default_application;
    }

    public static function hasAccess($application) {
      if ( KUUZU::configExists('offline') && (KUUZU::getConfig('offline') == 'true') && ($application != 'Offline') ) {
        return false;
      }

      return true;
    }
  }
?>
