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

  use Kuuzu\KU\Core\Registry;

  class ProductVariants {
    static public function parse($module, $data) {
      if ( class_exists('Kuuzu\\KU\\Core\\Site\\Shop\\Module\\ProductVariant\\' . $module) ) {
        return call_user_func(array('Kuuzu\\KU\\Core\\Site\\Shop\\Module\\ProductVariant\\' . $module, 'parse'), $data);
      }
    }

    static public function getGroupTitle($module, $data) {
      if ( class_exists('Kuuzu\\KU\\Core\\Site\\Shop\\Module\\ProductVariant\\' . $module) ) {
        return call_user_func(array('Kuuzu\\KU\\Core\\Site\\Shop\\Module\\ProductVariant\\' . $module, 'getGroupTitle'), $data);
      }

      return $data['group_title'];
    }

    static public function getValueTitle($module, $data) {
      if ( class_exists('Kuuzu\\KU\\Core\\Site\\Shop\\Module\\ProductVariant\\' . $module) ) {
        return call_user_func(array('Kuuzu\\KU\\Core\\Site\\Shop\\Module\\ProductVariant\\' . $module, 'getValueTitle'), $data);
      }

      return $data['value_title'];
    }

    static public function allowsMultipleValues($module) {
      if ( class_exists('Kuuzu\\KU\\Core\\Site\\Shop\\Module\\ProductVariant\\' . $module) ) {
        return call_user_func(array('Kuuzu\\KU\\Core\\Site\\Shop\\Module\\ProductVariant\\' . $module, 'allowsMultipleValues'));
      }

      return false;
    }

    static public function hasCustomValue($module) {
      if ( class_exists('Kuuzu\\KU\\Core\\Site\\Shop\\Module\\ProductVariant\\' . $module) ) {
        return call_user_func(array('Kuuzu\\KU\\Core\\Site\\Shop\\Module\\ProductVariant\\' . $module, 'hasCustomValue'));
      }

      return false;
    }

    static public function defineJavascript($products) {
      $KUUZU_Currencies = Registry::get('Currencies');

      $string = '<script language="javascript" type="text/javascript">var combos = new Array();' . "\n";

      foreach ( $products as $product_id => $product ) {
        $string .= 'combos[' . $product_id . '] = new Array();' . "\n" .
                   'combos[' . $product_id . '] = { price: "' . addslashes($KUUZU_Currencies->displayPrice($product['data']['price'], $product['data']['tax_class_id'])) . '", model: "' . addslashes($product['data']['model']) . '", availability_shipping: ' . (int)$product['data']['availability_shipping'] . ', values: [] };' . "\n";

        foreach ( $product['values'] as $group_id => $variants ) {
          $check_flag = false;

          foreach ( $variants as $variant ) {
            if ( self::hasCustomValue($variant['module']) === false ) {
              if ( $check_flag === false ) {
                $check_flag = true;

                $string .= 'combos[' . $product_id . ']["values"][' . $group_id . '] = new Array();' . "\n";
              }

              $string .= 'combos[' . $product_id . ']["values"][' . $group_id . '][' . $variant['value_id'] . '] = ' . $variant['value_id'] . ';' . "\n";
            }
          }
        }
      }

      $string .= '</script>';

      return $string;
    }
  }
?>
