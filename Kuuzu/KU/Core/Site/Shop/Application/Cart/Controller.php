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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Cart;

  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Site\Shop\Product;

  class Controller extends \Kuuzu\KU\Core\Site\Shop\ApplicationAbstract {
    protected function initialize() {
      $KUUZU_Language = Registry::get('Language');
      $KUUZU_ShoppingCart = Registry::get('ShoppingCart');
      $KUUZU_Service = Registry::get('Service');
      $KUUZU_Breadcrumb = Registry::get('Breadcrumb');

      $KUUZU_Language->load('checkout');

      $this->_page_title = KUUZU::getDef('shopping_cart_heading');

      if ( !$KUUZU_ShoppingCart->hasContents() ) {
        $this->_page_contents = 'empty.php';
      }

      if ( $KUUZU_Service->isStarted('Breadcrumb') ) {
        $KUUZU_Breadcrumb->add(KUUZU::getDef('breadcrumb_checkout_shopping_cart'), KUUZU::getLink(null, null, null, 'SSL'));
      }
    }

    public function requireCustomerAccount() {
      $KUUZU_ShoppingCart = Registry::get('ShoppingCart');

      foreach ( $KUUZU_ShoppingCart->getProducts() as $product ) {
        $KUUZU_Product = new Product($product['id']);

        if ( $KUUZU_Product->isTypeActionAllowed(array('PerformOrder', 'RequireCustomerAccount'), null, false) ) {
          return true;
        }
      }

      return false;
    }
  }
?>
