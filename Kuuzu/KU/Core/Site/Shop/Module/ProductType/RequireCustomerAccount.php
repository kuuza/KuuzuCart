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

  class RequireCustomerAccount {
    public static function getTitle() {
      return 'Require Customer Account';
    }

    public static function getDescription() {
      return 'Require customer account';
    }

    public static function isValid(Product $KUUZU_Product) {
      $KUUZU_Customer = Registry::get('Customer');

      return $KUUZU_Customer->isLoggedOn();
    }

    public static function onFail(Product $KUUZU_Product) {
      $KUUZU_NavigationHistory = Registry::get('NavigationHistory');

      $KUUZU_NavigationHistory->setSnapshot();

      KUUZU::redirect(KUUZU::getLink(null, 'Account', 'LogIn', 'SSL'));
    }
  }
?>
