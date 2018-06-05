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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Account\Action;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Site\Shop\Order;

  class Orders {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_Customer = Registry::get('Customer');
      $KUUZU_NavigationHistory = Registry::get('NavigationHistory');
      $KUUZU_Language = Registry::get('Language');
      $KUUZU_Service = Registry::get('Service');
      $KUUZU_Breadcrumb = Registry::get('Breadcrumb');

      if ( $KUUZU_Customer->isLoggedOn() === false ) {
        $KUUZU_NavigationHistory->setSnapshot();

        KUUZU::redirect(KUUZU::getLink(null, null, 'LogIn', 'SSL'));
      }

      $application->setPageTitle(KUUZU::getDef('orders_heading'));
      $application->setPageContent('orders.php');

      $KUUZU_Language->load('order');

      if ( $KUUZU_Service->isStarted('Breadcrumb') ) {
        $KUUZU_Breadcrumb->add(KUUZU::getDef('breadcrumb_my_orders'), KUUZU::getLink(null, null, 'Orders', 'SSL'));

        if ( is_numeric($_GET['Orders']) ) {
          $KUUZU_Breadcrumb->add(sprintf(KUUZU::getDef('breadcrumb_order_information'), $_GET['Orders']), KUUZU::getLink(null, null, 'Orders=' . $_GET['Orders'], 'SSL'));
        }
      }

      if ( is_numeric($_GET['Orders']) ) {
        if ( Order::getCustomerID($_GET['Orders']) !== $KUUZU_Customer->getID() ) {
          KUUZU::redirect(KUUZU::getLink(null, null, null, 'SSL'));
        }

        $application->setPageTitle(sprintf(KUUZU::getDef('order_information_heading'), $_GET['Orders']));
        $application->setPageContent('orders_info.php');
      }
    }
  }
?>
