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

  class RequireStock {
    public static function getTitle() {
      return 'Require Products In Stock';
    }

    public static function getDescription() {
      return 'Require products to be in stock';
    }

    public static function isValid(Product $KUUZU_Product) {
      $KUUZU_ShoppingCart = Registry::get('ShoppingCart');

      return ( ($KUUZU_Product->getQuantity() - $KUUZU_ShoppingCart->getQuantity( $KUUZU_ShoppingCart->getBasketID($KUUZU_Product->getID()) ))  > 0 );
    }

    public static function onFail(Product $KUUZU_Product) {
      $KUUZU_NavigationHistory = Registry::get('NavigationHistory');

      $KUUZU_NavigationHistory->setSnapshot();

      KUUZU::redirect(KUUZU::getLink(null, 'Cart', null, 'SSL'));
    }
  }
?>
