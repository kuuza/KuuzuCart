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

  namespace Kuuzu\KU\Core\Site\Shop\Module\Shipping;

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

  class Flat extends \Kuuzu\KU\Core\Site\Shop\Shipping {
    protected $icon;
    protected $_title;
    protected $_code = 'Flat';
    protected $_status = false;
    protected $_sort_order;

    public function __construct() {
      $this->icon = '';

      $this->_title = KUUZU::getDef('shipping_flat_title');
      $this->_description = KUUZU::getDef('shipping_flat_description');
      $this->_status = (defined('MODULE_SHIPPING_FLAT_STATUS') && (MODULE_SHIPPING_FLAT_STATUS == 'True') ? true : false);
      $this->_sort_order = (defined('MODULE_SHIPPING_FLAT_SORT_ORDER') ? MODULE_SHIPPING_FLAT_SORT_ORDER : null);
    }

    public function initialize() {
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_ShoppingCart = Registry::get('ShoppingCart');

      $this->tax_class = MODULE_SHIPPING_FLAT_TAX_CLASS;

      if ( ($this->_status === true) && ((int)MODULE_SHIPPING_FLAT_ZONE > 0) ) {
        $check_flag = false;

        $Qcheck = $KUUZU_PDO->prepare('select zone_id from :table_zones_to_geo_zones where geo_zone_id = :geo_zone_id and zone_country_id = :zone_country_id order by zone_id');
        $Qcheck->bindInt(':geo_zone_id', MODULE_SHIPPING_FLAT_ZONE);
        $Qcheck->bindInt(':zone_country_id', $KUUZU_ShoppingCart->getShippingAddress('country_id'));
        $Qcheck->execute();

        while ( $Qcheck->fetch() ) {
          if ( $Qcheck->valueInt('zone_id') < 1 ) {
            $check_flag = true;
            break;
          } elseif ( $Qcheck->valueInt('zone_id') == $KUUZU_ShoppingCart->getShippingAddress('zone_id') ) {
            $check_flag = true;
            break;
          }
        }

        if ( $check_flag === false ) {
          $this->_status = false;
        }
      }
    }

    public function quote() {
      $this->quotes = array('id' => $this->_code,
                            'module' => $this->_title,
                            'methods' => array(array('id' => $this->_code,
                                                     'title' => KUUZU::getDef('shipping_flat_method'),
                                                     'cost' => MODULE_SHIPPING_FLAT_COST)),
                            'tax_class_id' => $this->tax_class);

      if (!empty($this->icon)) $this->quotes['icon'] = HTML::image($this->icon, $this->_title);

      return $this->quotes;
    }
  }
?>
