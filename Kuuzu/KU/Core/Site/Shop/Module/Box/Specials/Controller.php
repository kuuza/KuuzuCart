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

  namespace Kuuzu\KU\Core\Site\Shop\Module\Box\Specials;

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

  class Controller extends \Kuuzu\KU\Core\Modules {
    var $_title,
        $_code = 'Specials',
        $_author_name = 'Kuuzu',
        $_author_www = 'https://kuuzu.org',
        $_group = 'Box';

    public function __construct() {
      $this->_title = KUUZU::getDef('box_specials_heading');
    }

    public function initialize() {
      $KUUZU_Service = Registry::get('Service');
      $KUUZU_Cache = Registry::get('Cache');
      $KUUZU_Language = Registry::get('Language');
      $KUUZU_Currencies = Registry::get('Currencies');
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_Image = Registry::get('Image');

      $this->_title_link = KUUZU::getLink(null, 'Products', 'Specials');

      if ( $KUUZU_Service->isStarted('Specials') ) {
        if ( (BOX_SPECIALS_CACHE > 0) && $KUUZU_Cache->read('box-specials-' . $KUUZU_Language->getCode() . '-' . $KUUZU_Currencies->getCode(), BOX_SPECIALS_CACHE)) {
          $data = $KUUZU_Cache->getCache();
        } else {
          $Qspecials = $KUUZU_PDO->prepare('select p.products_id, p.products_price, p.products_tax_class_id, pd.products_name, pd.products_keyword, s.specials_new_products_price, i.image from :table_products p left join :table_products_images i on (p.products_id = i.products_id and i.default_flag = :default_flag), :table_products_description pd, :table_specials s where s.status = 1 and s.products_id = p.products_id and p.products_status = 1 and p.products_id = pd.products_id and pd.language_id = :language_id order by s.specials_date_added desc limit :max_random_select_specials');
          $Qspecials->bindInt(':default_flag', 1);
          $Qspecials->bindInt(':language_id', $KUUZU_Language->getID());
          $Qspecials->bindInt(':max_random_select_specials', (int)BOX_SPECIALS_RANDOM_SELECT);
          $Qspecials->execute();

          $data = $Qspecials->fetchAll();

          if ( count($data) > 0 ) {
            $data = $result[rand(0, count($result) - 1)];

            $data['products_price'] = '<s>' . $KUUZU_Currencies->displayPrice($data['products_price'], $data['products_tax_class_id']) . '</s>&nbsp;<span class="productSpecialPrice">' . $KUUZU_Currencies->displayPrice($data['specials_new_products_price'], $data['products_tax_class_id']) . '</span>';

            $KUUZU_Cache->write($data);
          }
        }

        if ( !empty($data) ) {
          $this->_content = '';

          if ( !empty($data['image']) ) {
            $this->_content = HTML::link(KUUZU::getLink(null, 'Products', $data['products_keyword']), $KUUZU_Image->show($data['image'], $data['products_name'])) . '<br />';
          }

          $this->_content .= HTML::link(KUUZU::getLink(null, 'Products', $data['products_keyword']), $data['products_name']) . '<br />' . $data['products_price'];
        }
      }
    }

    public function install() {
      $KUUZU_PDO = Registry::get('PDO');

      parent::install();

      $KUUZU_PDO->exec("insert into :table_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Random Product Specials Selection', 'BOX_SPECIALS_RANDOM_SELECT', '10', 'Select a random product on special from this amount of the newest products on specials available', '6', '0', now())");
      $KUUZU_PDO->exec("insert into :table_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Cache Contents', 'BOX_SPECIALS_CACHE', '1', 'Number of minutes to keep the contents cached (0 = no cache)', '6', '0', now())");
    }

    public function getKeys() {
      if (!isset($this->_keys)) {
        $this->_keys = array('BOX_SPECIALS_RANDOM_SELECT', 'BOX_SPECIALS_CACHE');
      }

      return $this->_keys;
    }
  }
?>
