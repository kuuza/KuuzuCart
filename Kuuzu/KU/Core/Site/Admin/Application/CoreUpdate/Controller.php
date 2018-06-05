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

  namespace Kuuzu\KU\Core\Site\Admin\Application\CoreUpdate;

  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Site\Admin\Application\CoreUpdate\CoreUpdate;

  class Controller extends \Kuuzu\KU\Core\Site\Admin\ApplicationAbstract {
    protected $_group = 'tools';
    protected $_icon = 'coreupdate.png';
    protected $_sort_order = 5;

    protected function initialize() {
      $this->_title = KUUZU::getDef('app_title');
    }

    protected function process() {
      $this->_page_title = KUUZU::getDef('heading_title');
    }

/**
 * @since v3.0.2
 */

    public function getLogList() {
      $array = array(array('id' => '',
                           'text' => KUUZU::getDef('select_log_to_view'),
                           'params' => 'disabled="disabled"'));

      foreach ( CoreUpdate::getLogs() as $f ) {
        $array[] = array('id' => substr($f, 0, -4),
                         'text' => substr($f, 0, -4));
      }

      return $array;
    }
  }
?>
