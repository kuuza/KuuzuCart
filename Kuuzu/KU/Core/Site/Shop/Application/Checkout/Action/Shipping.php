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
  use Kuuzu\KU\Core\Site\Shop\Shipping as ShippingClass;

  class Shipping {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_ShoppingCart = Registry::get('ShoppingCart');
      $KUUZU_Service = Registry::get('Service');
      $KUUZU_Breadcrumb = Registry::get('Breadcrumb');
      $KUUZU_Template = Registry::get('Template');
      $KUUZU_Customer = Registry::get('Customer');

      global $Kuu_oiAddress; // HPDL

      $application->setPageTitle(KUUZU::getDef('shipping_method_heading'));
      $application->setPageContent('shipping.php');

      if ( $KUUZU_Service->isStarted('Breadcrumb') ) {
        $KUUZU_Breadcrumb->add(KUUZU::getDef('breadcrumb_checkout_shipping'), KUUZU::getLink(null, null, 'Shipping', 'SSL'));
      }

// load shipping address page if no default address exists
      if ( !$KUUZU_ShoppingCart->hasShippingAddress() ) {
        $application->setPageTitle(KUUZU::getDef('shipping_address_heading'));
        $application->setPageContent('shipping_address.php');

        $KUUZU_Template->addJavascriptFilename(KUUZU::getPublicSiteLink('javascript/checkout_shipping_address.js'));
        $KUUZU_Template->addJavascriptPhpFilename(KUUZU::BASE_DIRECTORY . 'Core/Site/Shop/assets/form_check.js.php');

        if ( !$KUUZU_Customer->isLoggedOn() ) {
          $Kuu_oiAddress = new ObjectInfo($KUUZU_ShoppingCart->getShippingAddress());
        }
      } else {
        $KUUZU_Template->addJavascriptFilename(KUUZU::getPublicSiteLink('javascript/checkout_shipping.js'));

// load all enabled shipping modules
        Registry::set('Shipping', new ShippingClass(), true);
      }
    }
  }
?>
