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

  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Admin\CategoryTree;

/**
 * @since v3.0.2
 */

  class getAll {
    public static function execute($parent_id = 0) {
      if ( Registry::exists('CategoryTree') ) {
        $KUUZU_CategoryTree = Registry::get('CategoryTree');
      } else {
        $KUUZU_CategoryTree = new CategoryTree();
        Registry::set('CategoryTree', $KUUZU_CategoryTree);
      }

      $KUUZU_CategoryTree->reset();
      $KUUZU_CategoryTree->setMaximumLevel(1);
      $KUUZU_CategoryTree->setBreadcrumbUsage(false);

      $result = $KUUZU_CategoryTree->getArray($parent_id);

      foreach ( $result as &$c ) {
        $c['products'] = $KUUZU_CategoryTree->getData($c['id'], 'count');
      }

      return array('entries' => $result,
                   'total' => count($result));
    }
  }
?>
