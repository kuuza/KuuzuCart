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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Products\Model;

  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class getAll {
    public static function execute($category_id = null, $pageset = 1) {
      $KUUZU_Language = Registry::get('Language');
      $KUUZU_CategoryTree = Registry::get('CategoryTree');
      $KUUZU_Currencies = Registry::get('Currencies');

      if ( !is_numeric($category_id) ) {
        $category_id = 0;
      }

      $data = array('language_id' => $KUUZU_Language->getID(),
                    'batch_pageset' => $pageset,
                    'batch_max_results' => MAX_DISPLAY_SEARCH_RESULTS);

      if ( !is_numeric($data['batch_pageset']) || (floor($data['batch_pageset']) != $data['batch_pageset']) ) {
        $data['batch_pageset'] = 1;
      }

      if ( $category_id > 0 ) {
        $KUUZU_CategoryTree->reset();
        $KUUZU_CategoryTree->setBreadcrumbUsage(false);

        $in_categories = array($category_id);

        foreach ( $KUUZU_CategoryTree->getArray($category_id) as $category ) {
          $in_categories[] = $category['id'];
        }

        $data['categories'] = $in_categories;
      }

      $result = KUUZU::callDB('Admin\Products\GetAll', $data);

      foreach ( $result['entries'] as &$p ) {
        if ( $p['has_children'] === 1 ) {
          $p['products_price_formatted'] = $KUUZU_Currencies->format($p['products_price_min']);

          if ( $p['products_price_min'] != $p['products_price_max'] ) {
            $p['products_price_formatted'] .= ' - ' . $KUUZU_Currencies->format($p['products_price_max']);
          }

          $p['products_quantity'] = '(' . $p['products_quantity_variants'] . ')';
        } else {
          $p['products_price_formatted'] = $KUUZU_Currencies->format($p['products_price']);
        }
      }

      return $result;
    }
  }
?>
