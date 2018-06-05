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

  namespace Kuuzu\KU\Core\Site\Shop\Module\Box\ShoppingCart;

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

  class Controller extends \Kuuzu\KU\Core\Modules {
    var $_title,
        $_code = 'ShoppingCart',
        $_author_name = 'Kuuzu',
        $_author_www = 'https://kuuzu.org',
        $_group = 'Box';

    public function __construct() {
      $this->_title = KUUZU::getDef('box_shopping_cart_heading');
    }

    public function initialize() {
      $KUUZU_ShoppingCart = Registry::get('ShoppingCart');
      $KUUZU_Currencies = Registry::get('Currencies');

      $this->_title_link = KUUZU::getLink(null, 'Checkout', null, 'SSL');

      if ( $KUUZU_ShoppingCart->hasContents() ) {
        $this->_content = '<table border="0" width="100%" cellspacing="0" cellpadding="0">';

        foreach ( $KUUZU_ShoppingCart->getProducts() as $products ) {
          $this->_content .= '  <tr>' .
                             '    <td align="right" valign="top">' . $products['quantity'] . '&nbsp;x&nbsp;</td>' .
                             '    <td valign="top">' . HTML::link(KUUZU::getLink(null, 'Products', $products['keyword']), $products['name']) . '</td>' .
                             '  </tr>';
        }

        $this->_content .= '</table>' .
                           '<p style="text-align: right">' . KUUZU::getDef('box_shopping_cart_subtotal') . ' ' . $KUUZU_Currencies->format($KUUZU_ShoppingCart->getSubTotal()) . '</p>';
      } else {
        $this->_content = KUUZU::getDef('box_shopping_cart_empty');
      }
    }
  }
?>
