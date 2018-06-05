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

  use Kuuzu\KU\Core\Cache;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Admin\CategoryTree;
  use Kuuzu\KU\Core\Site\Admin\Application\Categories\Categories;

/**
 * @since v3.0.2
 */

  class delete {
    public static function execute($id) {
      if ( Registry::exists('CategoryTree') ) {
        $KUUZU_CategoryTree = Registry::get('CategoryTree');
      } else {
        $KUUZU_CategoryTree = new CategoryTree();
        Registry::set('CategoryTree', $KUUZU_CategoryTree);
      }

      $data = array('id' => $id);

      foreach ( array_merge(array($data['id']), $KUUZU_CategoryTree->getChildren($data['id'])) as $c ) {
        Categories::deleteImage($c);
      }

      if ( KUUZU::callDB('Admin\Categories\Delete', $data) ) {
        Cache::clear('categories');
        Cache::clear('category_tree');
        Cache::clear('also_purchased');

        return true;
      }

      return false;
    }
  }
?>
