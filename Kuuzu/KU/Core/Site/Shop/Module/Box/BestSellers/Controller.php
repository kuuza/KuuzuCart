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

  namespace Kuuzu\KU\Core\Site\Shop\Module\Box\BestSellers;

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

  class Controller extends \Kuuzu\KU\Core\Modules {
    var $_title,
        $_code = 'BestSellers',
        $_author_name = 'Kuuzu',
        $_author_www = 'https://kuuzu.org',
        $_group = 'Box';

    public function __construct() {
      $this->_title = KUUZU::getDef('box_best_sellers_heading');
    }

    public function initialize() {
      global $current_category_id;

      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_Language = Registry::get('Language');

      if ( isset($current_category_id) && ($current_category_id > 0) ) {
        $Qbestsellers = $KUUZU_PDO->prepare('select distinct p.products_id, pd.products_name, pd.products_keyword from :table_products p, :table_products_description pd, :table_products_to_categories p2c, :table_categories c where p.products_status = 1 and p.products_ordered > 0 and p.products_id = pd.products_id and pd.language_id = :language_id and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and :current_category_id in (c.categories_id, c.parent_id) order by p.products_ordered desc, pd.products_name limit :max_display_bestsellers');
        $Qbestsellers->bindInt(':language_id', $KUUZU_Language->getID());
        $Qbestsellers->bindInt(':current_category_id', $current_category_id);
        $Qbestsellers->bindInt(':max_display_bestsellers', (int)BOX_BEST_SELLERS_MAX_LIST);

        if ( BOX_BEST_SELLERS_CACHE > 0 ) {
          $Qbestsellers->setCache('box_best_sellers-' . $current_category_id . '-' . $KUUZU_Language->getCode(), BOX_BEST_SELLERS_CACHE);
        }

        $Qbestsellers->execute();
      } else {
        $Qbestsellers = $KUUZU_PDO->prepare('select pd.products_id, pd.products_name, pd.products_keyword from :table_products p, :table_products_description pd where p.products_status = 1 and p.products_ordered > 0 and p.products_id = pd.products_id and pd.language_id = :language_id order by p.products_ordered desc, pd.products_name limit :max_display_bestsellers');
        $Qbestsellers->bindInt(':language_id', $KUUZU_Language->getID());
        $Qbestsellers->bindInt(':max_display_bestsellers', (int)BOX_BEST_SELLERS_MAX_LIST);

        if ( BOX_BEST_SELLERS_CACHE > 0 ) {
          $Qbestsellers->setCache('box_best_sellers-0-' . $KUUZU_Language->getCode(), BOX_BEST_SELLERS_CACHE);
        }

        $Qbestsellers->execute();
      }

      $result = $Qbestsellers->fetchAll();

      if ( count($result) >= BOX_BEST_SELLERS_MIN_LIST ) {
        $this->_content = '<ol style="margin: 0; padding: 0 0 0 20px;">';

        foreach ( $result as $r ) {
          $this->_content .= '<li>' . HTML::link(KUUZU::getLink(null, 'Products', $r['products_keyword']), $r['products_name']) . '</li>';
        }
 
        $this->_content .= '</ol>';
      }
    }

    public function install() {
      $KUUZU_PDO = Registry::get('PDO');

      parent::install();

      $KUUZU_PDO->exec("insert into :table_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Minimum List Size', 'BOX_BEST_SELLERS_MIN_LIST', '3', 'Minimum amount of products that must be shown in the listing', '6', '0', now())");
      $KUUZU_PDO->exec("insert into :table_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Maximum List Size', 'BOX_BEST_SELLERS_MAX_LIST', '10', 'Maximum amount of products to show in the listing', '6', '0', now())");
      $KUUZU_PDO->exec("insert into :table_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Cache Contents', 'BOX_BEST_SELLERS_CACHE', '60', 'Number of minutes to keep the contents cached (0 = no cache)', '6', '0', now())");
    }

    public function getKeys() {
      if (!isset($this->_keys)) {
        $this->_keys = array('BOX_BEST_SELLERS_MIN_LIST',
                             'BOX_BEST_SELLERS_MAX_LIST',
                             'BOX_BEST_SELLERS_CACHE');
      }

      return $this->_keys;
    }
  }
?>
