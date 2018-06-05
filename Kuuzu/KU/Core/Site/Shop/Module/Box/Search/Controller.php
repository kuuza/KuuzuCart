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

  namespace Kuuzu\KU\Core\Site\Shop\Module\Box\Search;

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;

  class Controller extends \Kuuzu\KU\Core\Modules {
    var $_title,
        $_code = 'Search',
        $_author_name = 'Kuuzu',
        $_author_www = 'https://kuuzu.org',
        $_group = 'Box';

    public function __construct() {
      $this->_title = KUUZU::getDef('box_search_heading');
    }

    function initialize() {
      $this->_title_link = KUUZU::getLink(null, 'Search');

      $this->_content = '<form name="search" action="' . KUUZU::getLink() . '" method="get">' . HTML::hiddenField('Search', null) .
                        HTML::inputField('Q', null, 'style="width: 80%;" maxlength="30"') . '&nbsp;' . HTML::hiddenSessionIDField() . HTML::button(array('icon' => 'search', 'title' => KUUZU::getDef('box_search_heading'))) .
                        '</form>';
    }
  }
?>
