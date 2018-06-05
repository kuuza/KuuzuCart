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

  namespace Kuuzu\KU\Core\Site\Admin\Module\Template\Value\total_shortcuts;

  use Kuuzu\KU\Core\Access;
  use Kuuzu\KU\Core\KUUZU;

  class Controller extends \Kuuzu\KU\Core\Template\ValueAbstract {
    static public function execute() {
      $total_shortcuts = 0;

      if ( isset($_SESSION[KUUZU::getSite()]['id']) && Access::hasShortcut() ) {
        $total_shortcuts = count(Access::getShortcuts());
      }

      return $total_shortcuts;
    }
  }
?>
