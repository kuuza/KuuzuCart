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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Checkout;

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Shop\Payment;
  use Kuuzu\KU\Core\Site\Shop\Product;

  class Controller extends \Kuuzu\KU\Core\Site\Shop\ApplicationAbstract {
    protected function initialize() {
      $KUUZU_ShoppingCart = Registry::get('ShoppingCart');
      $KUUZU_Customer = Registry::get('Customer');
      $KUUZU_Language = Registry::get('Language');
      $KUUZU_Service = Registry::get('Service');
      $KUUZU_Breadcrumb = Registry::get('Breadcrumb');
      $KUUZU_MessageStack = Registry::get('MessageStack');

// redirect to shopping cart if shopping cart is empty
      if ( !$KUUZU_ShoppingCart->hasContents() ) {
        KUUZU::redirect(KUUZU::getLink(null, 'Cart'));
      }

// check for e-mail address
      if ( !$KUUZU_Customer->hasEmailAddress() ) {
        if ( isset($_POST['email']) && (strlen(trim($_POST['email'])) >= ACCOUNT_EMAIL_ADDRESS) ) {
          if ( filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ) {
            $KUUZU_Customer->setEmailAddress(trim($_POST['email']));
          } else {
            $KUUZU_MessageStack->add('Cart', KUUZU::getDef('field_customer_email_address_check_error'));

            KUUZU::redirect(KUUZU::getLink(null, 'Cart'));
          }
        } else {
          $KUUZU_MessageStack->add('Cart', sprintf(KUUZU::getDef('field_customer_email_address_error'), ACCOUNT_EMAIL_ADDRESS));

          KUUZU::redirect(KUUZU::getLink(null, 'Cart'));
        }
      }

// check product type perform_order conditions
      foreach ( $KUUZU_ShoppingCart->getProducts() as $product ) {
        $KUUZU_Product = new Product($product['id']);
        $KUUZU_Product->isTypeActionAllowed('PerformOrder');
      }

      $KUUZU_Language->load('checkout');
      $KUUZU_Language->load('order');

      $this->_page_title = KUUZU::getDef('confirmation_heading');

      if ( $KUUZU_Service->isStarted('Breadcrumb') ) {
        $KUUZU_Breadcrumb->add(KUUZU::getDef('breadcrumb_checkout_confirmation'), KUUZU::getLink(null, 'Checkout', null, 'SSL'));
      }

      if ( isset($_POST['comments']) && isset($_SESSION['comments']) && empty($_POST['comments']) ) {
        unset($_SESSION['comments']);
      } elseif ( !empty($_POST['comments']) ) {
        $_SESSION['comments'] = HTML::sanitize($_POST['comments']);
      }

      if ( DISPLAY_CONDITIONS_ON_CHECKOUT == '1' ) {
        if ( !isset($_POST['conditions']) || ($_POST['conditions'] != '1') ) {
          $KUUZU_MessageStack->add('Checkout', KUUZU::getDef('error_conditions_not_accepted'), 'error');
        }
      }

      if ( Registry::exists('Payment') === false ) {
        Registry::set('Payment', new Payment());
      }

      if ( $KUUZU_ShoppingCart->hasBillingMethod() ) {
        $KUUZU_Payment = Registry::get('Payment');
        $KUUZU_Payment->load($KUUZU_ShoppingCart->getBillingMethod('id'));
      }
    }
  }
?>
