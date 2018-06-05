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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Checkout\Action\Shipping;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\ObjectInfo;

  class Address {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_Template = Registry::get('Template');
      $KUUZU_Service = Registry::get('Service');
      $KUUZU_Breadcrumb = Registry::get('Breadcrumb');
      $KUUZU_Customer = Registry::get('Customer');
      $KUUZU_ShoppingCart = Registry::get('ShoppingCart');

      global $Kuu_oiAddress;

      $application->setPageTitle(KUUZU::getDef('shipping_address_heading'));
      $application->setPageContent('shipping_address.php');

      $KUUZU_Template->addJavascriptFilename(KUUZU::getPublicSiteLink('javascript/checkout_shipping_address.js'));
      $KUUZU_Template->addJavascriptPhpFilename(KUUZU::BASE_DIRECTORY . 'Core/Site/Shop/assets/form_check.js.php');

      if ( $KUUZU_Service->isStarted('Breadcrumb') ) {
        $KUUZU_Breadcrumb->add(KUUZU::getDef('breadcrumb_checkout_shipping_address'), KUUZU::getLink(null, null, 'Shipping&Address', 'SSL'));
      }

      if ( !$KUUZU_Customer->isLoggedOn() ) {
        $Kuu_oiAddress = new ObjectInfo($KUUZU_ShoppingCart->getShippingAddress());
      }
    }
  }
?>
