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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Login;

  use Kuuzu\KU\Core\KUUZU;

  class Controller extends \Kuuzu\KU\Core\Site\Admin\ApplicationAbstract {
    protected $_link_to = false;
    protected $_icon = 'login.png';
    protected $_page_contents = 'main.html'; // HPDL (html should be the default)

    protected function initialize() {}

    protected function process() {
      $this->_page_title = KUUZU::getDef('heading_title');
    }
  }
?>
