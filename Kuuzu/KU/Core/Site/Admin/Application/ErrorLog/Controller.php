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

  namespace Kuuzu\KU\Core\Site\Admin\Application\ErrorLog;

  use Kuuzu\KU\Core\KUUZU;

  class Controller extends \Kuuzu\KU\Core\Site\Admin\ApplicationAbstract {
    protected $_group = 'tools';
    protected $_icon = 'errorlog.png';
    protected $_sort_order = 10;
    protected $_shortcut_callback = 'new_errors';

    protected function initialize() {
      $this->_title = KUUZU::getDef('app_title');
    }

    protected function process() {
      $this->_page_title = KUUZU::getDef('heading_title');
    }
  }
?>
