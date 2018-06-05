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
  use Kuuzu\KU\Core\Site\Shop\Reviews;
  use Kuuzu\KU\Core\Site\Shop\Product;
  use Kuuzu\KU\Core\KUUZU;

  class View {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_Service = Registry::get('Service');
      $KUUZU_Breadcrumb = Registry::get('Breadcrumb');

      $review_check = false;

      if ( is_numeric($_GET['View']) ) {
        if ( Reviews::exists($_GET['View']) ) {
          $review_check = true;

          Registry::set('Product', new Product(Reviews::getProductID($_GET['View'])));
          $KUUZU_Product = Registry::get('Product');

          $application->setPageTitle($KUUZU_Product->getTitle());
          $application->setPageContent('reviews_view.php');

          if ( $KUUZU_Service->isStarted('Breadcrumb')) {
            $KUUZU_Breadcrumb->add($KUUZU_Product->getTitle(), KUUZU::getLink(null, null, 'Reviews&View=' . $_GET['View'] . '&' . $KUUZU_Product->getKeyword()));
          }
        }
      }

      if ( $review_check === false ) {
        $application->setPageContent('reviews_not_found.php');
      }
    }
  }
?>
