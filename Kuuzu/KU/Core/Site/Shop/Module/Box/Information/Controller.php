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

  namespace Kuuzu\KU\Core\Site\Shop\Module\Box\Information;

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;

  class Controller extends \Kuuzu\KU\Core\Modules {
    var $_title,
        $_code = 'Information',
        $_author_name = 'Kuuzu',
        $_author_www = 'https://kuuzu.org',
        $_group = 'Box';

    public function __construct() {
      $this->_title = KUUZU::getDef('box_information_heading');
    }

    function initialize() {
      $this->_title_link = KUUZU::getLink(null, 'Info');

      $this->_content = '<ol style="list-style: none; margin: 0; padding: 0;">' .
                        '  <li>' . HTML::link(KUUZU::getLink(null, 'Info', 'Shipping'), KUUZU::getDef('box_information_shipping')) . '</li>' .
                        '  <li>' . HTML::link(KUUZU::getLink(null, 'Info', 'Privacy'), KUUZU::getDef('box_information_privacy')) . '</li>' .
                        '  <li>' . HTML::link(KUUZU::getLink(null, 'Info', 'Conditions'), KUUZU::getDef('box_information_conditions')) . '</li>' .
                        '  <li>' . HTML::link(KUUZU::getLink(null, 'Info', 'Contact'), KUUZU::getDef('box_information_contact')) . '</li>' .
                        '  <li>' . HTML::link(KUUZU::getLink(null, 'Info', 'Sitemap'), KUUZU::getDef('box_information_sitemap')) . '</li>' .
                        '</ol>';
    }
  }
?>
