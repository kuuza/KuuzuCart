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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Info\Action;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;

  class Sitemap {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_Service = Registry::get('Service');
      $KUUZU_Breadcrumb = Registry::get('Breadcrumb');

      $application->setPageTitle(KUUZU::getDef('info_sitemap_heading'));
      $application->setPageContent('sitemap.php');

      if ( $KUUZU_Service->isStarted('Breadcrumb') ) {
        $KUUZU_Breadcrumb->add(KUUZU::getDef('breadcrumb_sitemap'), KUUZU::getLink(null, null, 'Sitemap'));
      }
    }
  }
?>
