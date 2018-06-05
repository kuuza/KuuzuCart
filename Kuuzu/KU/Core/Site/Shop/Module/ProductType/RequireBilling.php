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
  use Kuuzu\KU\Core\Site\Shop\Payment;
  use Kuuzu\KU\Core\Site\Shop\Product;

  class RequireBilling {
    public static function getTitle() {
      return 'Require Billing';
    }

    public static function getDescription() {
      return 'Require billing';
    }

    public static function isValid(Product $KUUZU_Product) {
      $KUUZU_Customer = Registry::get('Customer');
      $KUUZU_ShoppingCart = Registry::get('ShoppingCart');

      if ( $KUUZU_ShoppingCart->hasBillingAddress() === false ) {
        if ( $KUUZU_Customer->hasDefaultAddress() ) {
          $KUUZU_ShoppingCart->setBillingAddress($KUUZU_Customer->getDefaultAddressID());
          $KUUZU_ShoppingCart->resetBillingMethod();
        } elseif ( $KUUZU_ShoppingCart->hasShippingAddress() ) {
          $KUUZU_ShoppingCart->setBillingAddress($KUUZU_ShoppingCart->getShippingAddress());
          $KUUZU_ShoppingCart->resetBillingMethod();
        }
      }

      if ( $KUUZU_ShoppingCart->hasBillingMethod() === false ) {
        if ( Registry::exists('Payment') === false ) {
          Registry::set('Payment', new Payment());
        }

        $KUUZU_Payment = Registry::get('Payment');
        $KUUZU_Payment->loadAll();

        if ( $KUUZU_Payment->hasActive() ) {
          $payment_modules = $KUUZU_Payment->getActive();
          $payment_module = $payment_modules[0];

          $KUUZU_PaymentModule = Registry::get('Payment_' . $payment_module);

          $KUUZU_ShoppingCart->setBillingMethod(array('id' => $KUUZU_PaymentModule->getCode(),
                                                      'title' => $KUUZU_PaymentModule->getMethodTitle()));
        }
      }

      return $KUUZU_ShoppingCart->hasBillingAddress() && $KUUZU_ShoppingCart->hasBillingMethod();
    }

    public static function onFail(Product $KUUZU_Product) {
      $KUUZU_NavigationHistory = Registry::get('NavigationHistory');

      if ( !isset($_GET['Billing']) ) {
        $KUUZU_NavigationHistory->setSnapshot();

        KUUZU::redirect(KUUZU::getLink(null, 'Checkout', 'Billing', 'SSL'));
      }
    }
  }
?>
