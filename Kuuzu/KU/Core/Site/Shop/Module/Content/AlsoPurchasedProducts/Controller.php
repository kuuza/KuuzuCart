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

  namespace Kuuzu\KU\Core\Site\Shop\Module\Content\AlsoPurchasedProducts;

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

  class Controller extends \Kuuzu\KU\Core\Modules {
    var $_title,
        $_code = 'AlsoPurchasedProducts',
        $_author_name = 'Kuuzu',
        $_author_www = 'https://kuuzu.org',
        $_group = 'Content';

    public function __construct() {
      $this->_title = KUUZU::getDef('customers_also_purchased_title');
    }

    public function initialize() {
      if ( Registry::exists('Product') ) {
        $KUUZU_PDO = Registry::get('PDO');
        $KUUZU_Product = Registry::get('Product');
        $KUUZU_Language = Registry::get('Language');
        $KUUZU_Image = Registry::get('Image');

        $Qorders = $KUUZU_PDO->prepare('select 
        p.products_id, pd.products_name, pd.products_keyword, i.image 
        from 
        :table_orders_products opa, :table_orders_products opb, 
        :table_orders o, :table_products p 
        left join 
        :table_products_images i on (p.products_id = i.products_id and i.default_flag = :default_flag), 
        :table_products_description pd 
        where opa.products_id = :products_id 
        and opa.orders_id = opb.orders_id 
        and opb.products_id != :products_id 
        and opb.products_id = p.products_id 
        and opb.orders_id = o.orders_id 
        and p.products_status = 1 
        and p.products_id = pd.products_id 
        and pd.language_id = :language_id 
        group by p.products_id 
        order by o.date_purchased desc limit :limit');
        $Qorders->bindInt(':default_flag', 1);
        $Qorders->bindInt(':products_id', $KUUZU_Product->getID());
        $Qorders->bindInt(':language_id', $KUUZU_Language->getID());
        $Qorders->bindInt(':limit', (int)MODULE_CONTENT_ALSO_PURCHASED_MAX_DISPLAY);

        if ( MODULE_CONTENT_ALSO_PURCHASED_PRODUCTS_CACHE > 0 ) {
          $Qorders->setCache('also_purchased-' . $KUUZU_Product->getID(), MODULE_CONTENT_ALSO_PURCHASED_PRODUCTS_CACHE);
        }

        $Qorders->execute();

        $result = $Qorders->fetchAll();

        if ( count($result) >= MODULE_CONTENT_ALSO_PURCHASED_MIN_DISPLAY ) {
          $this->_content = '<div style="overflow: auto;">';

          foreach ( $result as $p ) {
            $this->_content .= '<span style="width: 33%; float: left; text-align: center;">';

            if ( strlen($p['image']) > 0 ) {
              $this->_content .= HTML::link(KUUZU::getLink(null, 'Products', $p['products_keyword']), $KUUZU_Image->show($p['image'], $p['products_name'])) . '<br />';
            }

            $this->_content .= HTML::link(KUUZU::getLink(null, 'Products', $p['products_keyword']), $p['products_name']) .
                               '</span>';
          }

          $this->_content .= '</div>';
        }
      }
    }

    public function install() {
      $KUUZU_PDO = Registry::get('PDO');

      parent::install();

      $KUUZU_PDO->exec("insert into :table_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Minimum Entries To Display', 'MODULE_CONTENT_ALSO_PURCHASED_MIN_DISPLAY', '1', 'Minimum number of also purchased products to display', '6', '0', now())");
      $KUUZU_PDO->exec("insert into :table_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Maximum Entries To Display', 'MODULE_CONTENT_ALSO_PURCHASED_MAX_DISPLAY', '6', 'Maximum number of also purchased products to display', '6', '0', now())");
      $KUUZU_PDO->exec("insert into :table_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Cache Contents', 'MODULE_CONTENT_ALSO_PURCHASED_PRODUCTS_CACHE', '60', 'Number of minutes to keep the contents cached (0 = no cache)', '6', '0', now())");
    }

    public function getKeys() {
      if ( !isset($this->_keys) ) {
        $this->_keys = array('MODULE_CONTENT_ALSO_PURCHASED_MIN_DISPLAY', 'MODULE_CONTENT_ALSO_PURCHASED_MAX_DISPLAY', 'MODULE_CONTENT_ALSO_PURCHASED_PRODUCTS_CACHE');
      }

      return $this->_keys;
    }
  }
?>
