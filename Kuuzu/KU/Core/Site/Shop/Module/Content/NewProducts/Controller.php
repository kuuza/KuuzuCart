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

  namespace Kuuzu\KU\Core\Site\Shop\Module\Content\NewProducts;

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Shop\Product;

  class Controller extends \Kuuzu\KU\Core\Modules {
    var $_title,
        $_code = 'NewProducts',
        $_author_name = 'Kuuzu',
        $_author_www = 'https://kuuzu.org',
        $_group = 'Content';

    public function __construct() {
      $this->_title = KUUZU::getDef('new_products_title');
    }

    public function initialize() {
      $KUUZU_Cache = Registry::get('Cache');
      $KUUZU_Language = Registry::get('Language');
      $KUUZU_Currencies = Registry::get('Currencies');
      $KUUZU_Category = Registry::get('Category');
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_Image = Registry::get('Image');

      $data = array();

      if ( (MODULE_CONTENT_NEW_PRODUCTS_CACHE > 0) && $KUUZU_Cache->read('new_products-' . $KUUZU_Language->getCode() . '-' . $KUUZU_Currencies->getCode() . '-' . $KUUZU_Category->getID(), MODULE_CONTENT_NEW_PRODUCTS_CACHE) ) {
        $data = $KUUZU_Cache->getCache();
      } else {
        if ( $KUUZU_Category->getID() < 1 ) {
          $Qproducts = $KUUZU_PDO->prepare('select products_id from :table_products where products_status = :products_status and parent_id is null order by products_date_added desc limit :max_display_new_products');
        } else {
          $Qproducts = $KUUZU_PDO->prepare('select distinct p2c.products_id from :table_products p, :table_products_to_categories p2c, :table_categories c where c.parent_id = :category_parent_id and c.categories_id = p2c.categories_id and p2c.products_id = p.products_id and p.products_status = :products_status and p.parent_id is null order by p.products_date_added desc limit :max_display_new_products');
          $Qproducts->bindInt(':category_parent_id', $KUUZU_Category->getID());
        }

        $Qproducts->bindInt(':products_status', 1);
        $Qproducts->bindInt(':max_display_new_products', (int)MODULE_CONTENT_NEW_PRODUCTS_MAX_DISPLAY);
        $Qproducts->execute();

        while ( $Qproducts->fetch() ) {
          $KUUZU_Product = new Product($Qproducts->valueInt('products_id'));

          $data[$KUUZU_Product->getID()] = $KUUZU_Product->getData();
          $data[$KUUZU_Product->getID()]['display_price'] = $KUUZU_Product->getPriceFormated(true);
          $data[$KUUZU_Product->getID()]['display_image'] = $KUUZU_Product->getImage();
        }

        $KUUZU_Cache->write($data);
      }

      if ( !empty($data) ) {
        $this->_content = '<div style="overflow: auto; height: 100%;">';

        foreach ( $data as $product ) {
          $this->_content .= '<span style="width: 33%; float: left; text-align: center;">' .
                             HTML::link(KUUZU::getLink(null, 'Products', $product['keyword']), $KUUZU_Image->show($product['display_image'], $product['name'])) . '<br />' .
                             HTML::link(KUUZU::getLink(null, 'Products', $product['keyword']), $product['name']) . '<br />' .
                             $product['display_price'] .
                             '</span>';
        }

        $this->_content .= '</div>';
      }
    }

    function install() {
      $KUUZU_PDO = Registry::get('PDO');

      parent::install();

      $KUUZU_PDO->exec("insert into :table_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Maximum Entries To Display', 'MODULE_CONTENT_NEW_PRODUCTS_MAX_DISPLAY', '9', 'Maximum number of new products to display', '6', '0', now())");
      $KUUZU_PDO->exec("insert into :table_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Cache Contents', 'MODULE_CONTENT_NEW_PRODUCTS_CACHE', '60', 'Number of minutes to keep the contents cached (0 = no cache)', '6', '0', now())");
    }

    function getKeys() {
      if ( !isset($this->_keys) ) {
        $this->_keys = array('MODULE_CONTENT_NEW_PRODUCTS_MAX_DISPLAY', 'MODULE_CONTENT_NEW_PRODUCTS_CACHE');
      }

      return $this->_keys;
    }
  }
?>
