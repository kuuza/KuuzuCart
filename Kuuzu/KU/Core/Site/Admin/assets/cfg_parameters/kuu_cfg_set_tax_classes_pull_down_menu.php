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

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;

  function kuu_cfg_set_tax_classes_pull_down_menu($default, $key = null) {
    $KUUZU_Language = Registry::get('Language');
    $KUUZU_PDO = Registry::get('PDO');

    $name = (empty($key)) ? 'configuration_value' : 'configuration[' . $key . ']';

    $tax_class_array = array(array('id' => '0',
                                   'text' => KUUZU::getDef('parameter_none')));

    $Qclasses = $KUUZU_PDO->query('select tax_class_id, tax_class_title from :table_tax_class order by tax_class_title');
    $Qclasses->execute();

    while ( $Qclasses->fetch() ) {
      $tax_class_array[] = array('id' => $Qclasses->valueInt('tax_class_id'),
                                 'text' => $Qclasses->value('tax_class_title'));
    }

    return HTML::selectMenu($name, $tax_class_array, $default);
  }
?>
