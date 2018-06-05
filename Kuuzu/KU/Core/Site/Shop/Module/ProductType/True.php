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

  use Kuuzu\KU\Core\Site\Shop\Product;

  class True {
    public static function getTitle() {
      return 'True';
    }

    public static function getDescription() {
      return 'Pass action with true';
    }

    public static function isValid(Product $KUUZU_Product) {
      return true;
    }
  }
?>
