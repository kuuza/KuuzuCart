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

  namespace Kuuzu\KU\Core\Site\Setup\Application\Install;

  use Kuuzu\KU\Core\KUUZU;

  class Controller extends \Kuuzu\KU\Core\Site\Setup\ApplicationAbstract {
    protected function initialize() {
      $this->_page_contents = 'step_1.php';
      $this->_page_title = KUUZU::getDef('page_title_installation');

      if ( isset($_GET['step']) && is_numeric($_GET['step']) ) {
        switch ( $_GET['step'] ) {
          case '2':
            $this->_page_contents = 'step_2.php';
            break;

          case '3':
            $this->_page_contents = 'step_3.php';
            break;
        }
      }
    }
  }
?>
