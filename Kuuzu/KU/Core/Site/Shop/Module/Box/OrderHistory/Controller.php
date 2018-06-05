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

  namespace Kuuzu\KU\Core\Site\Shop\Module\Box\OrderHistory;

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;
  
  class Controller extends \Kuuzu\KU\Core\Modules {
    var $_title,
        $_code = 'OrderHistory',
        $_author_name = 'Kuuzu',
        $_author_www = 'https://kuuzu.org',
        $_group = 'Box';

    public function __construct() {
      $this->_title = KUUZU::getDef('box_order_history_heading');
    }

    public function initialize() {
      $KUUZU_Customer = Registry::get('Customer');
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_Language = Registry::get('Language');

      if ( $KUUZU_Customer->isLoggedOn() ) {
        $Qorders = $KUUZU_PDO->prepare('select 
        distinct op.products_id, o.date_purchased
        from :table_orders o, 
        :table_orders_products op, 
        :table_products p 
        where o.customers_id = :customers_id 
        and op.orders_id = o.orders_id 
        and op.products_id = p.products_id 
        and p.products_status = 1 
        group by op.products_id, o.date_purchased 
        order by o.date_purchased desc 
        limit :limit');
        $Qorders->bindInt(':customers_id', $KUUZU_Customer->getID());
        $Qorders->bindInt(':limit', (int)BOX_ORDER_HISTORY_MAX_LIST);
        $Qorders->execute();

        $result = $Qorders->fetchAll();

        if ( count($result) > 0 ) {
          $product_ids = '';

          foreach ( $result as $r ) {
            $product_ids .= $r['products_id'] . ',';
          }

          $product_ids = substr($product_ids, 0, -1);

          $Qproducts = $KUUZU_PDO->prepare('select 
          products_id, products_name, products_keyword 
          from :table_products_description 
          where products_id in (' . $product_ids . ') 
          and language_id = :language_id 
          order by products_name');
          $Qproducts->bindInt(':language_id', (int)$KUUZU_Language->getID());
          $Qproducts->execute();

          $this->_content = '<ol>';      
          
          while ( $Qproducts->fetch() ) {
            $this->_content .= '<li>' . HTML::link(KUUZU::getLink(null, 'Products', $Qproducts->value('products_keyword')), $Qproducts->value('products_name')) . '</li>';
          }
          
          $this->_content .= '</ol>';
        }
      }
    }

    public function install() {
      $KUUZU_PDO = Registry::get('PDO');

      parent::install();

      $KUUZU_PDO->exec("insert into :table_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Maximum List Size', 'BOX_ORDER_HISTORY_MAX_LIST', '5', 'Maximum amount of products to show in the listing', '6', '0', now())");
    }

    public function getKeys() {
      if (!isset($this->_keys)) {
        $this->_keys = array('BOX_ORDER_HISTORY_MAX_LIST');
      }

      return $this->_keys;
    }
  }
?>
