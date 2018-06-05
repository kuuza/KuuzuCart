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

  namespace Kuuzu\KU\Core\Site\Shop;

  interface ProductVariantInterface {
    public static function parse($data);

    public static function allowsMultipleValues();

    public static function hasCustomValue();

    public static function getGroupTitle($data);

    public static function getValueTitle($data);
  }
?>
