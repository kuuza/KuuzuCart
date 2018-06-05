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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Products;

  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Admin\CategoryTree;
  use Kuuzu\KU\Core\Site\Admin\Image;
  use Kuuzu\KU\Core\Site\Admin\Tax;
  use Kuuzu\KU\Core\Site\Shop\Currencies;
  use Kuuzu\KU\Core\Site\Shop\ProductVariants;
  use Kuuzu\KU\Core\Site\Shop\Weight;

/**
 * @since v3.0.3
 */

  class Controller extends \Kuuzu\KU\Core\Site\Admin\ApplicationAbstract {
    protected $_group = 'products';
    protected $_icon = 'products.png';
    protected $_sort_order = 100;

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

      Registry::set('Currencies', new Currencies());

      Registry::set('Tax', new Tax());

      Registry::set('Image', new Image());

// check if the products image directory exists
      if ( is_dir(KUUZU::getConfig('dir_fs_public', 'KUUZU') . 'products') ) {
        if ( !is_writeable(KUUZU::getConfig('dir_fs_public', 'KUUZU') . 'products') ) {
          $KUUZU_MessageStack->add('header', sprintf(KUUZU::getDef('ms_error_image_directory_not_writable'), KUUZU::getConfig('dir_fs_public', 'KUUZU') . 'products'), 'error');
        }
      } else {
        $KUUZU_MessageStack->add('header', sprintf(KUUZU::getDef('ms_error_image_directory_non_existant'), KUUZU::getConfig('dir_fs_public', 'KUUZU') . 'products'), 'error');
      }

// check for imagemagick or GD
      if ( !Image::hasGDSupport() && ((strlen(CFG_APP_IMAGEMAGICK_CONVERT) < 1) || !file_exists(CFG_APP_IMAGEMAGICK_CONVERT)) ) {
        $KUUZU_MessageStack->add('header', KUUZU::getDef('ms_warning_image_processor_not_available'), 'warning');
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

    public function getTaxClassesList() {
      $result = array(array('id' => '0',
                            'text' => KUUZU::getDef('none')));

      foreach ( Tax::getClasses() as $c ) {
        $result[] = array('id' => $c['tax_class_id'],
                          'text' => $c['tax_class_title']);
      }

      return $result;
    }

    public function getWeightClassesList() {
      $weight_class_array = array();

      foreach ( Weight::getClasses() as $wc ) {
        $weight_class_array[] = array('id' => $wc['id'],
                                      'text' => $wc['title']);
      }

      return $weight_class_array;
    }

    public function getProductVariants($id) {
      $KUUZU_Language = Registry::get('Language');

      $data = array('id' => $id,
                    'language_id' => $KUUZU_Language->getID());

      $result = KUUZU::callDB('Admin\Products\GetProductVariants', $data);

      $variants = array();

      foreach ( $result as $pv ) {
        $variants[(int)$pv['products_id']] = array('combos' => $pv['combos'],
                                                   'default' => $pv['default'],
                                                   'tax_class_id' => (int)$pv['products_tax_class_id'],
                                                   'price' => $pv['products_price'],
                                                   'model' => $pv['products_model'],
                                                   'quantity' => (int)$pv['products_quantity'],
                                                   'weight' => $pv['products_weight'],
                                                   'weight_class_id' => (int)$pv['products_weight_class'],
                                                   'status' => (int)$pv['products_status']);
      }

      return $variants;
    }

    public function getVariantGroups() {
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_Language = Registry::get('Language');

      $vg = array();

      $Qvgroups = $KUUZU_PDO->prepare('select id, title, module from :table_products_variants_groups where languages_id = :languages_id order by sort_order, title');
      $Qvgroups->bindInt(':languages_id', $KUUZU_Language->getID());
      $Qvgroups->execute();

      while ( $Qvgroups->fetch() ) {
        $has_multiple_value_groups = ProductVariants::allowsMultipleValues($Qvgroups->value('module'));

        $vg[$Qvgroups->valueInt('id')] = array('title' => $Qvgroups->value('title'),
                                               'values' => array(),
                                               'allow_multiple_values' => $has_multiple_value_groups);

        $Qvvalues = $KUUZU_PDO->prepare('select id, title from :table_products_variants_values where products_variants_groups_id = :products_variants_groups_id and languages_id = :languages_id order by sort_order, title');
        $Qvvalues->bindInt(':products_variants_groups_id', $Qvgroups->valueInt('id'));
        $Qvvalues->bindInt(':languages_id', $KUUZU_Language->getID());
        $Qvvalues->execute();

        while ( $Qvvalues->fetch() ) {
          $vg[$Qvgroups->valueInt('id')]['values'][$Qvvalues->valueInt('id')] = array('title' => $Qvvalues->value('title'));
        }
      }

      return $vg;
    }
  }
?>
