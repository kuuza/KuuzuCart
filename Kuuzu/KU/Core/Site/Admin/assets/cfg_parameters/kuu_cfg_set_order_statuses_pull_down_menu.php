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
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

  function kuu_cfg_set_order_statuses_pull_down_menu($default, $key = null) {
    $KUUZU_PDO = Registry::get('PDO');
    $KUUZU_Language = Registry::get('Language');

    $name = (empty($key)) ? 'configuration_value' : 'configuration[' . $key . ']';

    $statuses_array = array(array('id' => '0',
                                  'text' => KUUZU::getDef('default_entry')));

    $Qstatuses = $KUUZU_PDO->prepare('select orders_status_id, orders_status_name from :table_orders_status where language_id = :language_id order by orders_status_name');
    $Qstatuses->bindInt(':language_id', $KUUZU_Language->getID());
    $Qstatuses->execute();

    while ( $Qstatuses->fetch() ) {
      $statuses_array[] = array('id' => $Qstatuses->valueInt('orders_status_id'),
                                'text' => $Qstatuses->value('orders_status_name'));
    }

    return HTML::selectMenu($name, $statuses_array, $default);
  }
?>
