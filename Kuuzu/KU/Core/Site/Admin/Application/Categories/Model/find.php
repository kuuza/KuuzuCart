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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Categories\Model;

  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Admin\CategoryTree;

/**
 * @since v3.0.2
 */

  class find {
    public static function execute($search, $parent_id = 0) {
      if ( Registry::exists('CategoryTree') ) {
        $KUUZU_CategoryTree = Registry::get('CategoryTree');
      } else {
        $KUUZU_CategoryTree = new CategoryTree();
        Registry::set('CategoryTree', $KUUZU_CategoryTree);
      }

      $KUUZU_CategoryTree->reset();
      $KUUZU_CategoryTree->setRootCategoryID($parent_id);
      $KUUZU_CategoryTree->setBreadcrumbUsage(false);

      $categories = array();

      foreach ( $KUUZU_CategoryTree->getArray() as $c ) {
        if ( stripos($c['title'], $search) !== false ) {
          if ( $c['id'] != $parent_id ) {
            $category_path = $KUUZU_CategoryTree->getPathArray($c['id']);
            $top_category_id = $category_path[0]['id'];

            if ( !in_array($top_category_id, $categories) ) {
              $categories[] = $top_category_id;
            }
          }
        }
      }

      $result = array('entries' => array());

      foreach ( $categories as $c ) {
        $result['entries'][] = array('id' => $KUUZU_CategoryTree->getData($c, 'id'),
                                     'title' => $KUUZU_CategoryTree->getData($c, 'name'),
                                     'products' => $KUUZU_CategoryTree->getData($c, 'count'));
      }

      $result['total'] = count($result['entries']);

      return $result;
    }
  }
?>
