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

  namespace Kuuzu\KU\Core\Site\Shop\Module\Box\ManufacturerInfo;

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

  class Controller extends \Kuuzu\KU\Core\Modules {
    var $_title,
        $_code = 'ManufacturerInfo',
        $_author_name = 'Kuuzu',
        $_author_www = 'https://kuuzu.org',
        $_group = 'Box';

    public function __construct() {
      $this->_title = KUUZU::getDef('box_manufacturer_info_heading');
    }

    public function initialize() {
      $KUUZU_Product = ( Registry::exists('Product') ) ? Registry::get('Product') : null;
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_Language = Registry::get('Language');

      if ( isset($KUUZU_Product) && ($KUUZU_Product instanceof \Kuuzu\KU\Site\Shop\Product) && $KUUZU_Product->isValid() ) {
        $Qmanufacturer = $KUUZU_PDO->query('select m.manufacturers_id, m.manufacturers_name, m.manufacturers_image, mi.manufacturers_url from :table_manufacturers m left join :table_manufacturers_info mi on (m.manufacturers_id = mi.manufacturers_id and mi.languages_id = :languages_id), :table_products p  where p.products_id = :products_id and p.manufacturers_id = m.manufacturers_id');
        $Qmanufacturer->bindInt(':languages_id', $KUUZU_Language->getID());
        $Qmanufacturer->bindInt(':products_id', $KUUZU_Product->getID());
        $Qmanufacturer->execute();

        $result = $Qmanufacturer->fetch();

        if ( !empty($result) ) {
          $this->_content = '';

          if ( strlen($result['manufacturers_image']) > 0 ) {
            $this->_content .= '<div style="text-align: center;">' .
                               HTML::link(KUUZU::getLink(null, 'Index', 'Manufacturers=' . $result['manufacturers_id']), HTML::image('public/manufacturers/' . $result['manufacturers_image'], $result['manufacturers_name'])) .
                               '</div>';
          }

          $this->_content .= '<ol style="list-style: none; margin: 0; padding: 0;">';

          if ( strlen($result['manufacturers_url']) > 0 ) {
            $this->_content .= '<li>' . HTML::link(KUUZU::getLink(null, 'Redirct', 'Manufacturer=' . $result['manufacturers_id']), sprintf(KUUZU::getDef('box_manufacturer_info_website'), $result['manufacturers_name']), 'target="_blank"') . '</li>';
          }

          $this->_content .= '<li>' . HTML::link(KUUZU::getLink(null, 'Index', 'Manufacturers=' . $result['manufacturers_id']), KUUZU::getDef('box_manufacturer_info_products')) . '</li>';

          $this->_content .= '</ol>';
        }
      }
    }
  }
?>
