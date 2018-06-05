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

  namespace Kuuzu\KU\Core\Site\Setup\Application\Offline;

  use Kuuzu\KU\Core\KUUZU;

  class Controller extends \Kuuzu\KU\Core\Site\Setup\ApplicationAbstract {
    protected function initialize() {
      $this->_page_title = KUUZU::getDef('page_title_authorization_required');
    }
  }
?>
