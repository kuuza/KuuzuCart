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

  namespace Kuuzu\KU\Core\Site\Admin\Module\Template\Value\page_icon;

  use Kuuzu\KU\Core\Registry;

  class Controller extends \Kuuzu\KU\Core\Template\ValueAbstract {
    static public function execute() {
      $KUUZU_Application = Registry::get('Application');
      $KUUZU_Template = Registry::get('Template');

      return $KUUZU_Template->getIcon(32, $KUUZU_Application->getIcon());
    }
  }
?>
