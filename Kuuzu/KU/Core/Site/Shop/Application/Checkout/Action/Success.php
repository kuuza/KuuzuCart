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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Checkout\Action;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;

  class Success {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_ShoppingCart = Registry::get('ShoppingCart');
      $KUUZU_Service = Registry::get('Service');
      $KUUZU_Breadcrumb = Registry::get('Breadcrumb');

      $KUUZU_ShoppingCart->reset(true);

// unregister session variables used during checkout
      unset($_SESSION['comments']);

      $application->setPageTitle(KUUZU::getDef('success_heading'));
      $application->setPageContent('success.php');

      if ( $KUUZU_Service->isStarted('Breadcrumb') ) {
        $KUUZU_Breadcrumb->add(KUUZU::getDef('breadcrumb_checkout_success'), KUUZU::getLink(null, null, 'Success', 'SSL'));
      }

//      if ( $_GET[$this->_module] == 'update' ) {
//        $this->_process();
//      }
    }

    protected function _process() {
      global $Kuu_Customer;

      $notify_string = '';

      if ( $Kuu_Customer->isLoggedOn() ) {
        $products_array = (isset($_POST['notify']) ? $_POST['notify'] : array());

        if ( !is_array($products_array) ) {
          $products_array = array($products_array);
        }

        $notifications = array();

        foreach ( $products_array as $product_id ) {
          if ( is_numeric($product_id) && !in_array($product_id, $notifications) ) {
            $notifications[] = $product_id;
          }
        }

        if ( !empty($notifications) ) {
          $notify_string = 'action=notify_add&products=' . implode(';', $notifications);
        }
      }

      kuu_redirect(kuu_href_link(FILENAME_DEFAULT, $notify_string, 'AUTO'));
    }
  }
?>
