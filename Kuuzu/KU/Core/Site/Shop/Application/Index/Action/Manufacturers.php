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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Index\Action;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Shop\Manufacturer;
  use Kuuzu\KU\Core\Site\Shop\Products;

  class Manufacturers {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_Service = Registry::get('Service');
      $KUUZU_Breadcrumb = Registry::get('Breadcrumb');

      $application->setPageTitle(sprintf(KUUZU::getDef('index_heading'), STORE_NAME));
      $application->setPageContent('product_listing.php');

      if ( is_numeric($_GET['Manufacturers']) ) {
        Registry::set('Manufacturer', new Manufacturer($_GET['Manufacturers']));
        $KUUZU_Manufacturer = Registry::get('Manufacturer');

        $application->setPageTitle($KUUZU_Manufacturer->getTitle());
// HPDL        $application->setPageImage('manufacturers/' . $KUUZU_Manufacturer->getImage());

        if ( $KUUZU_Service->isStarted('Breadcrumb') ) {
          $KUUZU_Breadcrumb->add($KUUZU_Manufacturer->getTitle(), KUUZU::getLink());
        }

        Registry::set('Products', new Products());
        $KUUZU_Products = Registry::get('Products');
        $KUUZU_Products->setManufacturer($KUUZU_Manufacturer->getID());

        if ( isset($_GET['filter']) && is_numeric($_GET['filter']) && ($_GET['filter'] > 0) ) {
          $KUUZU_Products->setCategory($_GET['filter']);
        }

        if ( isset($_GET['sort']) && !empty($_GET['sort']) ) {
          if ( strpos($_GET['sort'], '|d') !== false ) {
            $KUUZU_Products->setSortBy(substr($_GET['sort'], 0, -2), '-');
          } else {
            $KUUZU_Products->setSortBy($_GET['sort']);
          }
        }
      } else {
        KUUZU::redirect(KUUZU::getLink(KUUZU::getDefaultSite(), KUUZU::getDefaultSiteApplication()));
      }
    }
  }
?>
