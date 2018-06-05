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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Languages;

  use Kuuzu\KU\Core\KUUZU;

  class Controller extends \Kuuzu\KU\Core\Site\Admin\ApplicationAbstract {
    protected $_group = 'configuration';
    protected $_icon = 'languages.png';
    protected $_sort_order = 400;

    protected function initialize() {
      $this->_title = KUUZU::getDef('app_title');
    }

    protected function process() {
      $this->_page_title = KUUZU::getDef('heading_title');

      if ( isset($_GET['id']) && is_numeric($_GET['id']) && Languages::exists($_GET['id']) ) {
        $this->_page_contents = 'groups.php';
        $this->_page_title .= ': ' . Languages::get($_GET['id'], 'name');

        if ( isset($_GET['group']) && Languages::isGroup($_GET['id'], $_GET['group']) ) {
          $this->_page_contents = 'definitions.php';
          $this->_page_title .= ': ' . $_GET['group'];
        }
      }
    }
  }
?>
