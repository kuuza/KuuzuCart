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

  class TellAFriend {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_Customer = Registry::get('Customer');
      $KUUZU_NavigationHistory = Registry::get('NavigationHistory');
      $KUUZU_Service = Registry::get('Service');
      $KUUZU_Breadcrumb = Registry::get('Breadcrumb');

      if ( (ALLOW_GUEST_TO_TELL_A_FRIEND == '-1') && ($KUUZU_Customer->isLoggedOn() === false) ) {
        $KUUZU_NavigationHistory->setSnapshot();

        KUUZU::redirect(KUUZU::getLink(null, 'Account', 'LogIn', 'SSL'));
      }

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
        if ( Product::checkEntry($requested_product) ) {
          $product_check = true;

          Registry::set('Product', new Product($requested_product));
          $KUUZU_Product = Registry::get('Product');

          $application->setPageTitle($KUUZU_Product->getTitle());
          $application->setPageContent('tell_a_friend.php');

          if ( $KUUZU_Service->isStarted('Breadcrumb')) {
            $KUUZU_Breadcrumb->add($KUUZU_Product->getTitle(), KUUZU::getLink(null, null, $KUUZU_Product->getKeyword()));
            $KUUZU_Breadcrumb->add(KUUZU::getDef('breadcrumb_tell_a_friend'), KUUZU::getLink(null, null, 'TellAFriend&' . $KUUZU_Product->getKeyword()));
          }
        }

        if ( $product_check === false ) {
          $application->setPageContent('not_found.php');
        }
      }
    }
  }
?>
