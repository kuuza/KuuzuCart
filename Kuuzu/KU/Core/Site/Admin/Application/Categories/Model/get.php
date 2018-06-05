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

  class get {
    public static function execute($id, $key = null, $language_id = null) {
      $KUUZU_Language = Registry::get('Language');

      if ( Registry::exists('CategoryTree') ) {
        $KUUZU_CategoryTree = Registry::get('CategoryTree');
      } else {
        $KUUZU_CategoryTree = new CategoryTree();
        Registry::set('CategoryTree', $KUUZU_CategoryTree);
      }

      if ( !isset($language_id) ) {
        $language_id = $KUUZU_Language->getID();
      }

      $data = array('id' => $id,
                    'language_id' => $language_id);

      $result = KUUZU::callDB('Admin\Categories\Get', $data);

      $result['children_count'] = count($KUUZU_CategoryTree->getChildren($id));
      $result['product_count'] = $KUUZU_CategoryTree->getNumberOfProducts($id);

      if ( isset($key) ) {
        $result = $result[$key] ?: null;
      }

      return $result;
    }
  }
?>
