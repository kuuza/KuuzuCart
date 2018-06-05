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

  namespace Kuuzu\KU\Core\Site\Admin\Module\Template\Value\html_lang;

  use Kuuzu\KU\Core\KUUZU;

  class Controller extends \Kuuzu\KU\Core\Template\ValueAbstract {
    static public function execute() {
      return KUUZU::getDef('html_lang_code'); // HPDL A better solution is to define the ISO 639-1 value at the language level
    }
  }
?>
