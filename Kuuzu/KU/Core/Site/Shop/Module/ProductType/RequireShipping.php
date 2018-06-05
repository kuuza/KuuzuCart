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

  namespace Kuuzu\KU\Core\Site\Shop\Module\ProductType;

  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Shop\Product;

  class RequireShipping {
    public static function getTitle() {
      return 'Require Shipping';
    }

    public static function getDescription() {
      return 'Require shipping';
    }

    public static function isValid(Product $KUUZU_Product) {
      $KUUZU_ShoppingCart = Registry::get('ShoppingCart');
      $KUUZU_Customer = Registry::get('Customer');

      if ( $KUUZU_ShoppingCart->hasShippingAddress() === false ) {
        if ( $KUUZU_Customer->hasDefaultAddress() ) {
          $KUUZU_ShoppingCart->setShippingAddress($KUUZU_Customer->getDefaultAddressID());
          $KUUZU_ShoppingCart->resetShippingMethod();
        } elseif ( $KUUZU_ShoppingCart->hasBillingAddress() ) {
          $KUUZU_ShoppingCart->setShippingAddress($KUUZU_ShoppingCart->getBillingAddress());
          $KUUZU_ShoppingCart->resetShippingMethod();
        }
      }

      return $KUUZU_ShoppingCart->hasShippingAddress() && $KUUZU_ShoppingCart->hasShippingMethod();
    }

    public static function onFail(Product $KUUZU_Product) {
      $KUUZU_NavigationHistory = Registry::get('NavigationHistory');

      if ( !isset($_GET['Shipping']) ) {
        $KUUZU_NavigationHistory->setSnapshot();

        KUUZU::redirect(KUUZU::getLink(null, 'Checkout', 'Shipping', 'SSL'));
      }
    }
  }
?>
