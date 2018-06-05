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
  use Kuuzu\KU\Core\Site\Shop\Reviews;

  class Process {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_Customer = Registry::get('Customer');
      $KUUZU_NavigationHistory = Registry::get('NavigationHistory');
      $KUUZU_MessageStack = Registry::get('MessageStack');
      $KUUZU_Reviews = Registry::get('Reviews');
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

      $data = array('products_id' => $KUUZU_Product->getID());

      if ( $KUUZU_Customer->isLoggedOn() ) {
        $data['customer_id'] = $KUUZU_Customer->getID();
        $data['customer_name'] = $KUUZU_Customer->getName();
      } else {
        $data['customer_id'] = '0';
        $data['customer_name'] = $_POST['customer_name'];
      }

      if ( strlen(trim($_POST['review'])) < REVIEW_TEXT_MIN_LENGTH ) {
        $KUUZU_MessageStack->add('Reviews', sprintf(KUUZU::getDef('js_review_text'), REVIEW_TEXT_MIN_LENGTH));
      } else {
        $data['review'] = $_POST['review'];
      }

      if ( ($_POST['rating'] < 1) || ($_POST['rating'] > 5) ) {
        $KUUZU_MessageStack->add('Reviews', KUUZU::getDef('js_review_rating'));
      } else {
        $data['rating'] = $_POST['rating'];
      }

      if ( $KUUZU_MessageStack->size('Reviews') < 1 ) {
        if ( $KUUZU_Reviews->isModerated() ) {
          $data['status'] = '0';

          $KUUZU_MessageStack->add('Reviews', KUUZU::getDef('success_review_moderation'), 'success');
        } else {
          $data['status'] = '1';

          $KUUZU_MessageStack->add('Reviews', KUUZU::getDef('success_review_new'), 'success');
        }

        Reviews::saveEntry($data);

        KUUZU::redirect(KUUZU::getLink(null, null, 'Reviews&' . $KUUZU_Product->getID()));
      }

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
