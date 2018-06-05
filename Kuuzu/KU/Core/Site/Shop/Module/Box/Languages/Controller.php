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

  namespace Kuuzu\KU\Core\Site\Shop\Module\Box\Languages;

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

  class Controller extends \Kuuzu\KU\Core\Modules {
    var $_title,
        $_code = 'Languages',
        $_author_name = 'Kuuzu',
        $_author_www = 'https://kuuzu.org',
        $_group = 'Box';

    public function __construct() {
      $this->_title = KUUZU::getDef('box_languages_heading');
    }

    function initialize() {
      $KUUZU_Language = Registry::get('Language');

      $this->_content = '';

      $get_params = array();

      foreach ( $_GET as $key => $value ) {
        if ( ($key != 'language') && ($key != Registry::get('Session')->getName()) && ($key != 'x') && ($key != 'y') ) {
          $get_params[] = $key . '=' . $value;
        }
      }

      $get_params = implode($get_params, '&');

      if ( !empty($get_params) ) {
        $get_params .= '&';
      }

      foreach ( $KUUZU_Language->getAll() as $value ) {
        $this->_content .= ' ' . HTML::link(KUUZU::getLink(null, null, $get_params . 'language=' . $value['code'], 'AUTO'), $KUUZU_Language->showImage($value['code'])) . ' ';
      }
    }
  }
?>
