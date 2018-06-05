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

  class save {
    public static function execute($id = null, $data) {
      if ( Registry::exists('CategoryTree') ) {
        $KUUZU_CategoryTree = Registry::get('CategoryTree');
      } else {
        $KUUZU_CategoryTree = new CategoryTree();
        Registry::set('CategoryTree', $KUUZU_CategoryTree);
      }

      if ( is_numeric($id) ) {
        $data['id'] = $id;
      }

// Prevent another big bang and check if category is not being moved to a child category
      if ( isset($data['id']) && ($KUUZU_CategoryTree->getParentID($data['id']) != $data['parent_id']) ) {
        if ( in_array($data['id'], explode('_', $KUUZU_CategoryTree->buildBreadcrumb($data['parent_id']))) ) {
          return false;
        }
      }

      if ( isset($data['image']) ) {
        $new_image = $data['image'];

        while ( file_exists(KUUZU::getConfig('dir_fs_public', 'KUUZU') . 'categories/' . $new_image) ) {
          $new_image = rand(10, 99) . $new_image;
        }

        if ( rename(KUUZU::getConfig('dir_fs_public', 'KUUZU') . 'upload/' . $data['image'], KUUZU::getConfig('dir_fs_public', 'KUUZU') . 'categories/' . $new_image) ) {
          if ( is_numeric($id) ) {
            $old_image = Categories::get($id, 'categories_image');

            unlink(KUUZU::getConfig('dir_fs_public', 'KUUZU') . 'categories/' . $old_image);
          }

          $data['image'] = $new_image;
        } else {
          $data['image'] = null;
        }
      }

      if ( KUUZU::callDB('Admin\Categories\Save', $data) ) {
        Cache::clear('categories');
        Cache::clear('category_tree');
        Cache::clear('also_purchased');

        return true;
      }

      return false;
    }
  }
?>
