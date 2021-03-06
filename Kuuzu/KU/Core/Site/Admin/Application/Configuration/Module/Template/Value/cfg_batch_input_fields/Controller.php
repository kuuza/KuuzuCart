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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Configuration\Module\Template\Value\cfg_batch_input_fields;

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\Site\Admin\Application\Configuration\Configuration;

  class Controller extends \Kuuzu\KU\Core\Template\ValueAbstract {
    static public function execute() {
      $cfg_input_fields = array();

      foreach ( array_unique(array_filter($_POST['batch'], 'is_numeric')) as $cfg_id ) {
        $cfg = Configuration::getEntry($cfg_id);

        $rumpel = array();

        if ( strlen($cfg['set_function']) > 0 ) {
          $rumpel['input_field'] = Configuration::callUserFunc($cfg['set_function'], $cfg['configuration_value'], $cfg['configuration_key']);
        } else {
          $rumpel['input_field'] = HTML::inputField('configuration[' . $cfg['configuration_key'] . ']', $cfg['configuration_value']);
        }

        $rumpel['key'] = $cfg['configuration_key'];
        $rumpel['title'] = HTML::outputProtected($cfg['configuration_title']);
        $rumpel['description'] = $cfg['configuration_description'];

        $cfg_input_fields[] = $rumpel;
      }

      return $cfg_input_fields;
    }
  }
?>
