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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Services;

  use Kuuzu\KU\Core\KUUZU;

/**
 * @since v3.0.2
 */

  class Controller extends \Kuuzu\KU\Core\Site\Admin\ApplicationAbstract {
    protected $_group = 'modules';
    protected $_icon = 'services.png';
    protected $_sort_order = 500;

    protected function initialize() {
      $this->_title = KUUZU::getDef('app_title');
    }

    protected function process() {
      $this->_page_title = KUUZU::getDef('heading_title');
    }
  }
?>
