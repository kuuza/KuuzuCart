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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Configuration\Module\Template\Value\cfg_input_field;

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\ObjectInfo;
  use Kuuzu\KU\Core\Site\Admin\Application\Configuration\Configuration;

  class Controller extends \Kuuzu\KU\Core\Template\ValueAbstract {
    static public function execute() {
      $KUUZU_ObjectInfo = new ObjectInfo(Configuration::getEntry($_GET['pID']));

      if ( strlen($KUUZU_ObjectInfo->get('set_function')) > 0 ) {
        $value_field = Configuration::callUserFunc($KUUZU_ObjectInfo->get('set_function'), $KUUZU_ObjectInfo->get('configuration_value'), $KUUZU_ObjectInfo->get('configuration_key'));
      } else {
        $value_field = HTML::inputField('configuration[' . $KUUZU_ObjectInfo->get('configuration_key') . ']', $KUUZU_ObjectInfo->get('configuration_value'));
      }

      return $value_field;
    }
  }
?>
