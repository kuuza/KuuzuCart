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

  namespace Kuuzu\KU\Core\Site\Shop\Module\Content\UpcomingProducts;

  use Kuuzu\KU\Core\DateTime;
  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Shop\Product;

  class Controller extends \Kuuzu\KU\Core\Modules {
    var $_title,
        $_code = 'UpcomingProducts',
        $_author_name = 'Kuuzu',
        $_author_www = 'https://kuuzu.org',
        $_group = 'Content';

    public function __construct() {
      $this->_title = KUUZU::getDef('upcoming_products_title');
    }

    public function initialize() {
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_Language = Registry::get('Language');
      $KUUZU_Currencies = Registry::get('Currencies');

      $Qupcoming = $KUUZU_PDO->prepare('select p.products_id, pa.value as date_expected from :table_products p, :table_templates_boxes tb, :table_product_attributes pa where tb.code = :code and tb.id = pa.id and to_days(str_to_date(pa.value, "%Y-%m-%d")) >= to_days(now()) and pa.products_id = p.products_id and p.products_status = :products_status order by pa.value limit :max_display_upcoming_products');
      $Qupcoming->bindValue(':code', 'DateAvailable');
      $Qupcoming->bindInt(':products_status', 1);
      $Qupcoming->bindInt(':max_display_upcoming_products', (int)MODULE_CONTENT_UPCOMING_PRODUCTS_MAX_DISPLAY);

      if ( MODULE_CONTENT_UPCOMING_PRODUCTS_CACHE > 0 ) {
        $Qupcoming->setCache('upcoming_products-' . $KUUZU_Language->getCode() . '-' . $KUUZU_Currencies->getCode(), MODULE_CONTENT_UPCOMING_PRODUCTS_CACHE);
      }

      $Qupcoming->execute();

      $result = $Qupcoming->fetchAll();

      if ( !empty($result) ) {
        $this->_content = '<ol style="list-style: none;">';

        foreach ( $result as $r ) {
          $KUUZU_Product = new Product($r['products_id']);

          $this->_content .= '<li>' . DateTime::getLong($r['date_expected']) . ': ' . HTML::link(KUUZU::getLink(null, 'Products', $KUUZU_Product->getKeyword()), $KUUZU_Product->getTitle()) . ' ' . $KUUZU_Product->getPriceFormated(true) . '</li>';
        }

        $this->_content .= '</ol>';
      }
    }

    public function install() {
      $KUUZU_PDO = Registry::get('PDO');

      parent::install();

      $KUUZU_PDO->exec("insert into :table_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Maximum Entries To Display', 'MODULE_CONTENT_UPCOMING_PRODUCTS_MAX_DISPLAY', '10', 'Maximum number of upcoming products to display', '6', '0', now())");
      $KUUZU_PDO->exec("insert into :table_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Cache Contents', 'MODULE_CONTENT_UPCOMING_PRODUCTS_CACHE', '1440', 'Number of minutes to keep the contents cached (0 = no cache)', '6', '0', now())");
    }

    public function getKeys() {
      if ( !isset($this->_keys) ) {
        $this->_keys = array('MODULE_CONTENT_UPCOMING_PRODUCTS_MAX_DISPLAY', 'MODULE_CONTENT_UPCOMING_PRODUCTS_CACHE');
      }

      return $this->_keys;
    }
  }
?>
