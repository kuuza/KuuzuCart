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

  namespace Kuuzu\KU\Core\Site\Shop\Module\Box\ProductNotifications;

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

  class Controller extends \Kuuzu\KU\Core\Modules {
    var $_title,
        $_code = 'ProductNotifications',
        $_author_name = 'Kuuzu',
        $_author_www = 'https://kuuzu.org',
        $_group = 'Box';

    public function __construct() {
      $this->_title = KUUZU::getDef('box_product_notifications_heading');
    }

    public function initialize() {
      $KUUZU_Product = ( Registry::exists('Product') ) ? Registry::get('Product') : null;
      $KUUZU_Customer = Registry::get('Customer');
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_Language = Registry::get('Language');

      $this->_title_link = KUUZU::getLink(null, 'Account', 'Notifications', 'SSL');

      if ( isset($KUUZU_Product) && ($KUUZU_Product instanceof \Kuuzu\KU\Site\Shop\Product) && $KUUZU_Product->isValid() ) {
        if ( $KUUZU_Customer->isLoggedOn() ) {
          $Qcheck = $KUUZU_PDO->prepare('select global_product_notifications from :table_customers where customers_id = :customers_id');
          $Qcheck->bindInt(':customers_id', $KUUZU_Customer->getID());
          $Qcheck->execute();

          if ( $Qcheck->valueInt('global_product_notifications') === 0 ) {
            $get_params = array();

            foreach ( $_GET as $key => $value ) {
              if ( ($key != 'action') && ($key != Registry::get('Session')->getName()) && ($key != 'x') && ($key != 'y') ) {
                $get_params[] = $key . '=' . $value;
              }
            }

            $get_params = implode($get_params, '&');

            if ( !empty($get_params) ) {
              $get_params .= '&';
            }

            $Qcheck = $KUUZU_PDO->prepare('select products_id from :table_products_notifications where products_id = :products_id and customers_id = :customers_id limit 1');
            $Qcheck->bindInt(':products_id', $KUUZU_Product->getID());
            $Qcheck->bindInt(':customers_id', $KUUZU_Customer->getID());
            $Qcheck->execute();

            $result = $Qcheck->fetch();

            if ( !empty($result) ) {
              $this->_content = '<div style="float: left; width: 55px;">' . HTML::link(KUUZU::getLink(null, null, $get_params . 'action=notify_remove', 'AUTO'), HTML::image(DIR_WS_IMAGES . 'box_products_notifications_remove.gif', sprintf(KUUZU::getDef('box_product_notifications_remove'), $KUUZU_Product->getTitle()))) . '</div>' .
                                HTML::link(KUUZU::getLink(null, null, $get_params . 'action=notify_remove', 'AUTO'), sprintf(KUUZU::getDef('box_product_notifications_remove'), $KUUZU_Product->getTitle()));
            } else {
              $this->_content = '<div style="float: left; width: 55px;">' . HTML::link(KUUZU::getLink(null, null, $get_params . 'action=notify_add', 'AUTO'), HTML::image(DIR_WS_IMAGES . 'box_products_notifications.gif', sprintf(KUUZU::getDef('box_product_notifications_add'), $KUUZU_Product->getTitle()))) . '</div>' .
                                HTML::link(KUUZU::getLink(null, null, $get_params . 'action=notify_add', 'AUTO'), sprintf(KUUZU::getDef('box_product_notifications_add'), $KUUZU_Product->getTitle()));
            }

            $this->_content .= '<div style="clear: both;"></div>';
          }
        }
      }
    }
  }
?>
