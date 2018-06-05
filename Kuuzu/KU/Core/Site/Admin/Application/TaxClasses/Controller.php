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

  namespace Kuuzu\KU\Core\Site\Admin\Application\TaxClasses;

  use Kuuzu\KU\Core\KUUZU;

  class Controller extends \Kuuzu\KU\Core\Site\Admin\ApplicationAbstract {
    protected $_group = 'configuration';
    protected $_icon = 'taxclasses.png';
    protected $_sort_order = 800;

    protected function initialize() {
      $this->_title = KUUZU::getDef('app_title');
    }

    protected function process() {
      $this->_page_title = KUUZU::getDef('heading_title');

      if ( isset($_GET['id']) && is_numeric($_GET['id']) ) {
        $this->_page_contents = 'entries.php';
        $this->_page_title .= ': ' . TaxClasses::get($_GET['id'], 'tax_class_title');
      }
    }
  }
?>
