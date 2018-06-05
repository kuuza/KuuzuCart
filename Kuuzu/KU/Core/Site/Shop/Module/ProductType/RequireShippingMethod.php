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

  class RequireShippingMethod {
    public static function getTitle() {
      return 'Require Shipping Method';
    }

    public static function getDescription() {
      return 'Require shipping method';
    }

    public static function isValid(Product $KUUZU_Product) {
      $KUUZU_ShoppingCart = Registry::get('ShoppingCart');

      return $KUUZU_ShoppingCart->hasShippingMethod();
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
