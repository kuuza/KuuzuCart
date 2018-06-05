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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Products\Action;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Site\Shop\Product;

  class Images {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_Template = Registry::get('Template');
      $KUUZU_NavigationHistory = Registry::get('NavigationHistory');

// HPDL
      $KUUZU_Template->setHasHeader(false);
      $KUUZU_Template->setHasFooter(false);
      $KUUZU_Template->setHasBoxModules(false);
      $KUUZU_Template->setHasContentModules(false);
      $KUUZU_Template->setShowDebugMessages(false);

      $KUUZU_NavigationHistory->removeCurrentPage();

      $requested_product = null;
      $product_check = false;

      if ( count($_GET) > 2 ) {
        $requested_product = basename(key(array_slice($_GET, 2, 1, true)));

        if ( $requested_product == KUUZU::getSiteApplication() ) {
          unset($requested_product);

          if ( count($_GET) > 3 ) {
            $requested_product = basename(key(array_slice($_GET, 3, 1, true)));
          }
        }
      }

      if ( isset($requested_product) ) {
        if ( !$application->siteApplicationActionExists($requested_product) ) {
          if ( Product::checkEntry($requested_product) ) {
            $product_check = true;

            Registry::set('Product', new Product($requested_product));
            $KUUZU_Product = Registry::get('Product');

            $KUUZU_Template->addPageTags('keywords', $KUUZU_Product->getTitle());
            $KUUZU_Template->addPageTags('keywords', $KUUZU_Product->getModel());

            if ( $KUUZU_Product->hasTags() ) {
              $KUUZU_Template->addPageTags('keywords', $KUUZU_Product->getTags());
            }

            $application->setPageTitle($KUUZU_Product->getTitle());
            $application->setPageContent('images.php');
          }
        }
      }

      if ( $product_check === false ) {
        $application->setPageTitle(KUUZU::getDef('product_not_found_heading'));
        $application->setPageContent('not_found.php');
      }
    }
  }
?>