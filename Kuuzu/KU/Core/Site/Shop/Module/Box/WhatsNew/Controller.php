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

  namespace Kuuzu\KU\Core\Site\Shop\Module\Box\WhatsNew;

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Shop\Product;

  class Controller extends \Kuuzu\KU\Core\Modules {
    var $_title,
        $_code = 'WhatsNew',
        $_author_name = 'Kuuzu',
        $_author_www = 'https://kuuzu.org',
        $_group = 'Box';

    public function __construct() {
      $this->_title = KUUZU::getDef('box_whats_new_heading');
    }

    function initialize() {
      $KUUZU_Cache = Registry::get('Cache');
      $KUUZU_Language = Registry::get('Language');
      $KUUZU_Currencies = Registry::get('Currencies');
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_Image = Registry::get('Image');

      $this->_title_link = KUUZU::getLink(null, 'Products', 'All');

      $data = array();

      if ( (BOX_WHATS_NEW_CACHE > 0) && $KUUZU_Cache->read('box-whats_new-' . $KUUZU_Language->getCode() . '-' . $KUUZU_Currencies->getCode(), BOX_WHATS_NEW_CACHE) ) {
        $data = $KUUZU_Cache->getCache();
      } else {
        $Qnew = $KUUZU_PDO->prepare('select products_id from :table_products where products_status = :products_status order by products_date_added desc limit :max_random_select_new');
        $Qnew->bindInt(':products_status', 1);
        $Qnew->bindInt(':max_random_select_new', (int)BOX_WHATS_NEW_RANDOM_SELECT);
        $Qnew->execute();

        $result = $Qnew->fetchAll();

        if ( count($result) > 0 ) {
          $result = $result[rand(0, count($result) - 1)];

          $KUUZU_Product = new Product($result['products_id']);

          $data = $KUUZU_Product->getData();

          $data['display_price'] = $KUUZU_Product->getPriceFormated(true);
          $data['display_image'] = $KUUZU_Product->getImage();
        }

        $KUUZU_Cache->write($data);
      }

      if ( !empty($data) ) {
        $this->_content = '';

        if ( !empty($data['display_image']) ) {
          $this->_content .= HTML::link(KUUZU::getLink(null, 'Products', $data['keyword']), $KUUZU_Image->show($data['display_image'], $data['name'])) . '<br />';
        }

        $this->_content .= HTML::link(KUUZU::getLink(null, 'Products', $data['keyword']), $data['name']) . '<br />' . $data['display_price'];
      }
    }

    function install() {
      $KUUZU_PDO = Registry::get('PDO');

      parent::install();

      $KUUZU_PDO->exec("insert into :table_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Random New Product Selection', 'BOX_WHATS_NEW_RANDOM_SELECT', '10', 'Select a random new product from this amount of the newest products available', '6', '0', now())");
      $KUUZU_PDO->exec("insert into :table_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Cache Contents', 'BOX_WHATS_NEW_CACHE', '1', 'Number of minutes to keep the contents cached (0 = no cache)', '6', '0', now())");
    }

    function getKeys() {
      if ( !isset($this->_keys) ) {
        $this->_keys = array('BOX_WHATS_NEW_RANDOM_SELECT', 'BOX_WHATS_NEW_CACHE');
      }

      return $this->_keys;
    }
  }
?>
