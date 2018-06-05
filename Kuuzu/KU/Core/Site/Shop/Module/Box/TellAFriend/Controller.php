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

  namespace Kuuzu\KU\Core\Site\Shop\Module\Box\TellAFriend;

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

  class Controller extends \Kuuzu\KU\Core\Modules {
    var $_title,
        $_code = 'TellAFriend',
        $_author_name = 'Kuuzu',
        $_author_www = 'https://kuuzu.org',
        $_group = 'Box';

    public function __construct() {
      $this->_title = KUUZU::getDef('box_tell_a_friend_heading');
    }

    public function initialize() {
      $KUUZU_Product = ( Registry::exists('Product') ) ? Registry::get('Product') : null;

      if ( isset($KUUZU_Product) && ($KUUZU_Product instanceof \Kuuzu\KU\Site\Shop\Product) && $KUUZU_Product->isValid() ) { // HPDL && ($Kuu_Template->getModule() != 'tell_a_friend')) {
        $this->_content = '<form name="tell_a_friend" action="' . KUUZU::getLink(null, null, 'TellAFriend&' . $KUUZU_Product->getKeyword()) . '" method="post">' . "\n" .
                          HTML::inputField('to_email_address', null, 'style="width: 80%;"') . '&nbsp;' . HTML::submitImage('button_tell_a_friend.gif', KUUZU::getDef('box_tell_a_friend_text')) . '<br />' . KUUZU::getDef('box_tell_a_friend_text') . "\n" .
                          '</form>' . "\n";
      }
    }
  }
?>
