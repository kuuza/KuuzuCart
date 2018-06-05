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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Products\Action\Reviews;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Shop\Product;
  use Kuuzu\KU\Core\KUUZU;

  class Write {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_Customer = Registry::get('Customer');
      $KUUZU_NavigationHistory = Registry::get('NavigationHistory');
      $KUUZU_Template = Registry::get('Template');
      $KUUZU_Service = Registry::get('Service');
      $KUUZU_Breadcrumb = Registry::get('Breadcrumb');

      $requested_product = null;
      $product_check = false;

      if ( count($_GET) > 3 ) {
        $requested_product = basename(key(array_slice($_GET, 3, 1, true)));

        if ( $requested_product == 'Write' ) {
          unset($requested_product);

          if ( count($_GET) > 4 ) {
            $requested_product = basename(key(array_slice($_GET, 4, 1, true)));
          }
        }
      }

      if ( isset($requested_product) ) {
        if ( Product::checkEntry($requested_product) ) {
          $product_check = true;
        }
      }

      if ( $product_check === false ) {
        $application->setPageContent('not_found.php');

        return false;
      }

      if ( ($KUUZU_Customer->isLoggedOn() === false) && (SERVICE_REVIEW_ENABLE_REVIEWS == 1) ) {
        $KUUZU_NavigationHistory->setSnapshot();

        KUUZU::redirect(KUUZU::getLink(null, 'Account', 'LogIn', 'SSL'));
      }

      Registry::set('Product', new Product($requested_product));
      $KUUZU_Product = Registry::get('Product');

      $application->setPageTitle($KUUZU_Product->getTitle());
      $application->setPageContent('reviews_write.php');
      $KUUZU_Template->addJavascriptPhpFilename(KUUZU::BASE_DIRECTORY . 'Core/Site/Shop/assets/reviews_new.php');

      if ( $KUUZU_Service->isStarted('Breadcrumb')) {
        $KUUZU_Breadcrumb->add($KUUZU_Product->getTitle(), KUUZU::getLink(null, null, 'Reviews&' . $KUUZU_Product->getKeyword()));
        $KUUZU_Breadcrumb->add(KUUZU::getDef('breadcrumb_reviews_new'), KUUZU::getLink(null, null, 'Reviews&Write&' . $KUUZU_Product->getKeyword()));
      }
    }
  }
?>
