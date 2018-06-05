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

  class deleteImage {
    public static function execute($id) {
      if ( Registry::exists('CategoryTree') ) {
        $KUUZU_CategoryTree = Registry::get('CategoryTree');
      } else {
        $KUUZU_CategoryTree = new CategoryTree();
        Registry::set('CategoryTree', $KUUZU_CategoryTree);
      }

      $data = $KUUZU_CategoryTree->getData($id);

      if ( !empty($data['image']) && file_exists(KUUZU::getConfig('dir_fs_public', 'KUUZU') . 'categories/' . $data['image']) ) {
        unlink(KUUZU::getConfig('dir_fs_public', 'KUUZU') . 'categories/' . $data['image']);
      }
    }
  }
?>
