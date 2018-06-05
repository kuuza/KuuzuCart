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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Index;

  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Site\Shop\Products;

  class Controller extends \Kuuzu\KU\Core\Site\Shop\ApplicationAbstract {
    protected function initialize() {
      $KUUZU_Category = Registry::get('Category');
      $KUUZU_Service = Registry::get('Service');
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_Language = Registry::get('Language');
      $KUUZU_Breadcrumb = Registry::get('Breadcrumb');

      $this->_page_title = sprintf(KUUZU::getDef('index_heading'), STORE_NAME);

      if ( $KUUZU_Category->getID() > 0 ) {
        if ( $KUUZU_Service->isStarted('Breadcrumb') ) {
          $Qcategories = $KUUZU_PDO->prepare('select categories_id, categories_name from :table_categories_description where categories_id in (' . implode(',', $KUUZU_Category->getPathArray()) . ') and language_id = :language_id');
          $Qcategories->bindInt(':language_id', $KUUZU_Language->getID());
          $Qcategories->execute();

          $categories = array();

          while ( $Qcategories->fetch() ) {
            $categories[$Qcategories->value('categories_id')] = $Qcategories->valueProtected('categories_name');
          }

          for ( $i=0, $n=sizeof($KUUZU_Category->getPathArray()); $i<$n; $i++ ) {
            $KUUZU_Breadcrumb->add($categories[$KUUZU_Category->getPathArray($i)], KUUZU::getLink(null, 'Index', 'cPath=' . implode('_', array_slice($KUUZU_Category->getPathArray(), 0, ($i+1)))));
          }
        }

        $this->_page_title = $KUUZU_Category->getTitle();

        if ( $KUUZU_Category->hasImage() ) {
//HPDL          $this->_page_image = 'categories/' . $KUUZU_Category->getImage();
        }

        $Qproducts = $KUUZU_PDO->prepare('select products_id from :table_products_to_categories where categories_id = :categories_id limit 1');
        $Qproducts->bindInt(':categories_id', $KUUZU_Category->getID());
        $Qproducts->execute();

        if ( count($Qproducts->fetchAll()) > 0 ) {
          $this->_page_contents = 'product_listing.php';

          $this->_process();
        } else {
          $Qparent = $KUUZU_PDO->prepare('select categories_id from :table_categories where parent_id = :parent_id limit 1');
          $Qparent->bindInt(':parent_id', $KUUZU_Category->getID());
          $Qparent->execute();

          if ( count($Qparent->fetchAll()) > 0 ) {
            $this->_page_contents = 'category_listing.php';
          } else {
            $this->_page_contents = 'product_listing.php';

            $this->_process();
          }
        }
      }
    }

    protected function _process() {
      $KUUZU_Category = Registry::get('Category');

      Registry::set('Products', new Products($KUUZU_Category->getID()));
      $KUUZU_Products = Registry::get('Products');

      if ( isset($_GET['filter']) && is_numeric($_GET['filter']) && ($_GET['filter'] > 0) ) {
        $KUUZU_Products->setManufacturer($_GET['filter']);
      }

      if ( isset($_GET['sort']) && !empty($_GET['sort']) ) {
        if ( strpos($_GET['sort'], '|d') !== false ) {
          $KUUZU_Products->setSortBy(substr($_GET['sort'], 0, -2), '-');
        } else {
          $KUUZU_Products->setSortBy($_GET['sort']);
        }
      }
    }
  }
?>
