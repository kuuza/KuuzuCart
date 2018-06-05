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

  namespace Kuuzu\KU\Core\Site\Shop;

  use Kuuzu\KU\Core\Cache;
  use Kuuzu\KU\Core\MessageStack;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\PDO;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Template;

  class Controller implements \Kuuzu\KU\Core\SiteInterface {
    protected static $_default_application = 'Index';

    public static function initialize() {
      Registry::set('MessageStack', new MessageStack());
      Registry::set('Cache', new Cache());
      Registry::set('PDO', PDO::initialize());

      foreach ( KUUZU::callDB('Shop\GetConfiguration', null, 'Site') as $param ) {
        define($param['cfgkey'], $param['cfgvalue']);
      }

      Registry::set('Service', new Service());
      Registry::get('Service')->start();

      Registry::set('Template', new Template());

      $application = 'Kuuzu\\KU\\Core\\Site\\Shop\\Application\\' . KUUZU::getSiteApplication() . '\\Controller';
      Registry::set('Application', new $application());

      Registry::get('Template')->setApplication(Registry::get('Application'));
    }

    public static function getDefaultApplication() {
      return self::$_default_application;
    }

    public static function hasAccess($application) {
      return true;
    }
  }
?>
