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
  use Kuuzu\KU\Core\Site\Shop\Breadcrumb as BreadcrumbClass;

  class Breadcrumb implements \Kuuzu\KU\Core\Site\Shop\ServiceInterface {
    public static function start() {
      Registry::set('Breadcrumb', new BreadcrumbClass());

      $KUUZU_Breadcrumb = Registry::get('Breadcrumb');

      $KUUZU_Breadcrumb->add(KUUZU::getDef('breadcrumb_top'), KUUZU::getLink(KUUZU::getDefaultSite(), KUUZU::getDefaultSiteApplication()));
      $KUUZU_Breadcrumb->add(KUUZU::getDef('breadcrumb_shop'), KUUZU::getLink('Shop', 'Index'));

      return true;
    }

    public static function stop() {
      return true;
    }
  }
?>
