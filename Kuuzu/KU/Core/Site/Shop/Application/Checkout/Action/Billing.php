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
  use Kuuzu\KU\Core\ObjectInfo;
  use Kuuzu\KU\Core\Site\Shop\Product;
  use Kuuzu\KU\Core\Site\Shop\Payment;

  class Billing {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_ShoppingCart = Registry::get('ShoppingCart');
      $KUUZU_Service = Registry::get('Service');
      $KUUZU_Breadcrumb = Registry::get('Breadcrumb');
      $KUUZU_Template = Registry::get('Template');

      global $Kuu_oiAddress; // HPDL

      $application->setPageTitle(KUUZU::getDef('payment_method_heading'));
      $application->setPageContent('billing.php');

      if ( $KUUZU_Service->isStarted('Breadcrumb') ) {
        $KUUZU_Breadcrumb->add(KUUZU::getDef('breadcrumb_checkout_payment'), KUUZU::getLink(null, null, 'Billing', 'SSL'));
      }

// load billing address page if no default address exists
      if ( !$KUUZU_ShoppingCart->hasBillingAddress() ) {
        $application->setPageTitle(KUUZU::getDef('payment_address_heading'));
        $application->setPageContent('billing_address.php');

        $KUUZU_Template->addJavascriptFilename(KUUZU::getPublicSiteLink('javascript/checkout_payment_address.js'));
        $KUUZU_Template->addJavascriptPhpFilename(KUUZU::BASE_DIRECTORY . 'Core/Site/Shop/assets/form_check.js.php');

        if ( !$KUUZU_Customer->isLoggedOn() ) {
          $Kuu_oiAddress = new ObjectInfo($KUUZU_ShoppingCart->getBillingAddress());
        }
      } else {
        $KUUZU_Template->addJavascriptFilename(KUUZU::getPublicSiteLink('javascript/checkout_payment.js'));

// load all enabled payment modules
        $KUUZU_Payment = Registry::get('Payment');
        $KUUZU_Payment->loadAll();

        $KUUZU_Template->addJavascriptBlock($KUUZU_Payment->getJavascriptBlocks());
      }

// HPDL
//      if (isset($_GET['payment_error']) && is_object(${$_GET['payment_error']}) && ($error = ${$_GET['payment_error']}->get_error())) {
//        $KUUZU_MessageStack->add('CheckoutBilling', $error['error'], 'error');
//      }
    }
  }
?>
