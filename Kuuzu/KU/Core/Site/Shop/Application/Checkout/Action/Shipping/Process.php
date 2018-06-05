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
  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

  class Process {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_Shipping = Registry::get('Shipping');
      $KUUZU_ShoppingCart = Registry::get('ShoppingCart');

      if ( !empty($_POST['comments']) ) {
        $_SESSION['comments'] = HTML::sanitize($_POST['comments']);
      }

      if ( $KUUZU_Shipping->hasQuotes() ) {
        if ( isset($_POST['shipping_mod_sel']) && strpos($_POST['shipping_mod_sel'], '_') ) {
          list($module, $method) = explode('_', $_POST['shipping_mod_sel']);

          if ( Registry::exists('Shipping_' . $module) && Registry::get('Shipping_' . $module)->isEnabled() ) {
            $quote = $KUUZU_Shipping->getQuote($_POST['shipping_mod_sel']);

            if ( isset($quote['error']) ) {
              $KUUZU_ShoppingCart->resetShippingMethod();
            } else {
              $KUUZU_ShoppingCart->setShippingMethod($quote);

              KUUZU::redirect(KUUZU::getLink(null, null, null, 'SSL'));
            }
          } else {
            $KUUZU_ShoppingCart->resetShippingMethod();
          }
        }
      } else {
        $KUUZU_ShoppingCart->resetShippingMethod();

        KUUZU::redirect(KUUZU::getLink(null, null, null, 'SSL'));
      }
    }
  }
?>
