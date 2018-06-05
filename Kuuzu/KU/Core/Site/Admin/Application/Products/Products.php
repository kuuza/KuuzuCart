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

/**
 * @since v3.0.3
 */

  class Products extends \Kuuzu\KU\Core\ApplicationModelAbstract { }

/*
  require('includes/applications/products/classes/products.php');
  require('includes/applications/product_attributes/classes/product_attributes.php');
  require('../includes/classes/variants.php');

  class Kuu_Application_Products extends Kuu_Template_Admin {

    protected $_module = 'products',
              $_page_title,
              $_page_contents = 'main.php';

    function __construct() {
      global $Kuu_Language, $Kuu_MessageStack, $Kuu_Currencies, $Kuu_Tax, $Kuu_CategoryTree, $Kuu_Image, $current_category_id;

      $this->_page_title = $Kuu_Language->get('heading_title');

      $current_category_id = 0;

      if ( isset($_GET['cID']) && is_numeric($_GET['cID']) ) {
        $current_category_id = $_GET['cID'];
      } else {
        $_GET['cID'] = $current_category_id;
      }

      require('../includes/classes/currencies.php');
      $Kuu_Currencies = new Kuu_Currencies();

      require('includes/classes/tax.php');
      $Kuu_Tax = new Kuu_Tax_Admin();

      require('includes/classes/category_tree.php');
      $Kuu_CategoryTree = new Kuu_CategoryTree_Admin();
      $Kuu_CategoryTree->setSpacerString('&nbsp;', 2);

      require('includes/classes/image.php');
      $Kuu_Image = new Kuu_Image_Admin();

// check if the catalog image directory exists
      if (is_dir(realpath('../images/products'))) {
        if (!is_writeable(realpath('../images/products'))) {
          $Kuu_MessageStack->add('header', sprintf($Kuu_Language->get('ms_error_image_directory_not_writable'), realpath('../images/products')), 'error');
        }
      } else {
        $Kuu_MessageStack->add('header', sprintf($Kuu_Language->get('ms_error_image_directory_non_existant'), realpath('../images/products')), 'error');
      }
    }
  }
*/
?>
