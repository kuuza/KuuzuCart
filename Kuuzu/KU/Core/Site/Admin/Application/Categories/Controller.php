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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Categories;

  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Admin\CategoryTree;

/**
 * @since v3.0.2
 */

  class Controller extends \Kuuzu\KU\Core\Site\Admin\ApplicationAbstract {
    protected $_group = 'products';
    protected $_icon = 'categories.png';
    protected $_sort_order = 200;

    protected $_category_id = 0;
    protected $_tree = array();

    protected function initialize() {
      $this->_title = KUUZU::getDef('app_title');
    }

    protected function process() {
      $KUUZU_MessageStack = Registry::get('MessageStack');

      $this->_page_title = KUUZU::getDef('heading_title');

      if ( isset($_GET['cid']) && is_numeric($_GET['cid']) ) {
        $this->_category_id = $_GET['cid'];
      }

      $this->_tree = new CategoryTree();
      Registry::set('CategoryTree', $this->_tree);

// check if the categories image directory exists
      if ( is_dir(KUUZU::getConfig('dir_fs_public', 'KUUZU') . 'categories') ) {
        if ( !is_writeable(KUUZU::getConfig('dir_fs_public', 'KUUZU') . 'categories') ) {
          $KUUZU_MessageStack->add('header', sprintf(KUUZU::getDef('ms_error_image_directory_not_writable'), KUUZU::getConfig('dir_fs_public', 'KUUZU') . 'categories'), 'error');
        }
      } else {
        $KUUZU_MessageStack->add('header', sprintf(KUUZU::getDef('ms_error_image_directory_non_existant'), KUUZU::getConfig('dir_fs_public', 'KUUZU') . 'categories'), 'error');
      }
    }

    public function getCurrentCategoryID() {
      return $this->_category_id;
    }

    public function getTree() {
      return $this->_tree;
    }

    public function getCategoryList() {
      $CT = $this->_tree;

      $CT->reset();
      $CT->setSpacerString('&nbsp;');

      $categories_array = array();

      foreach ( $CT->getArray() as $value ) {
        $cpath = explode('_', $value['id']); // end() only accepts variables

        $categories_array[] = array('id' => end($cpath),
                                    'text' => $value['title']);
      }

      return $categories_array;
    }
  }
?>
