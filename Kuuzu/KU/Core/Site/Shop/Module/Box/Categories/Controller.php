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

  namespace Kuuzu\KU\Core\Site\Shop\Module\Box\Categories;

  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

  class Controller extends \Kuuzu\KU\Core\Modules {
    var $_title,
        $_code = 'Categories',
        $_author_name = 'Kuuzu',
        $_author_www = 'https://kuuzu.org',
        $_group = 'Box';

    public function __construct() {
      $this->_title = KUUZU::getDef('box_categories_heading');
    }

    public function initialize() {
      $KUUZU_CategoryTree = Registry::get('CategoryTree');
      $KUUZU_Category = Registry::get('Category');

      $KUUZU_CategoryTree->reset();
      $KUUZU_CategoryTree->setCategoryPath($KUUZU_Category->getPath(), '<b>', '</b>');
      $KUUZU_CategoryTree->setParentGroupString('', '');
      $KUUZU_CategoryTree->setParentString('', '-&gt;');
      $KUUZU_CategoryTree->setChildString('', '<br />');
      $KUUZU_CategoryTree->setSpacerString('&nbsp;', 2);
      $KUUZU_CategoryTree->setShowCategoryProductCount((BOX_CATEGORIES_SHOW_PRODUCT_COUNT == '1') ? true : false);

      $this->_content = $KUUZU_CategoryTree->getTree();
    }

    function install() {
      $KUUZU_PDO = Registry::get('PDO');

      parent::install();

      $KUUZU_PDO->exec("insert into :table_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, use_function, set_function, date_added) values ('Show Product Count', 'BOX_CATEGORIES_SHOW_PRODUCT_COUNT', '1', 'Show the amount of products each category has', '6', '0', 'kuu_cfg_use_get_boolean_value', 'kuu_cfg_set_boolean_value(array(1, -1))', now())");
    }

    function getKeys() {
      if (!isset($this->_keys)) {
        $this->_keys = array('BOX_CATEGORIES_SHOW_PRODUCT_COUNT');
      }

      return $this->_keys;
    }
  }
?>
