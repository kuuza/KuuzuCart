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

  namespace Kuuzu\KU\Core\Site\Shop\Module\Box\CheckoutTrail;

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

  class Controller extends \Kuuzu\KU\Core\Modules {
    var $_title,
        $_code = 'CheckoutTrail',
        $_author_name = 'Kuuzu',
        $_author_www = 'https://kuuzu.org',
        $_group = 'Box';

    public function __construct() {
      $this->_title = KUUZU::getDef('box_ordering_steps_heading');
    }

    public function initialize() {
      $KUUZU_ShoppingCart = Registry::get('ShoppingCart');
      $KUUZU_Template = Registry::get('Template');

      $steps = array();

      if ( $KUUZU_ShoppingCart->getContentType() != 'virtual' ) {
        $steps[] = array('title' => KUUZU::getDef('box_ordering_steps_delivery'),
                         'code' => 'shipping',
                         'active' => (($KUUZU_Template->getModule() == 'Shipping') || ($KUUZU_Template->getModule() == 'ShippingAddress') ? true : false));
      }

      $steps[] = array('title' => KUUZU::getDef('box_ordering_steps_payment'),
                       'code' => 'payment',
                       'active' => (($KUUZU_Template->getModule() == 'Payment') || ($KUUZU_Template->getModule() == 'PaymentAddress') ? true : false));

      $steps[] = array('title' => KUUZU::getDef('box_ordering_steps_confirmation'),
                       'code' => 'confirmation',
                       'active' => ($KUUZU_Template->getModule() == 'Confirmation' ? true : false));

      $steps[] = array('title' => KUUZU::getDef('box_ordering_steps_complete'),
                       'active' => ($KUUZU_Template->getModule() == 'Success' ? true : false));


      $content = HTML::image('templates/' . $KUUZU_Template->getCode() . '/images/icons/32x32/checkout_preparing_to_ship.gif') . '<br />';

      $counter = 0;

      foreach ( $steps as $step ) {
        $counter++;

        $content .= '<span style="white-space: nowrap;">&nbsp;' . HTML::image('templates/' . $KUUZU_Template->getCode() . '/images/icons/24x24/checkout_' . $counter . ($step['active'] === true ? '_on' : '') . '.gif', $step['title'], 24, 24, 'align="absmiddle"');

        if ( isset($step['code']) ) {
          $content .= HTML::link(KUUZU::getLink(null, 'Checkout', $step['code'], 'SSL'), $step['title'], 'class="boxCheckoutTrail' . ($step['active'] === true ? 'Active' : '') . '"');
        } else {
          $content .= '<span class="boxCheckoutTrail' . ($step['active'] === true ? 'Active' : '') . '">' . $step['title'] . '</span>';
        }

        $content .= '</span><br />';
      }

      $content .= HTML::image('templates/' . $KUUZU_Template->getCode() . '/images/icons/32x32/checkout_ready_to_ship.gif');

      $this->_content = $content;
    }
  }
?>
