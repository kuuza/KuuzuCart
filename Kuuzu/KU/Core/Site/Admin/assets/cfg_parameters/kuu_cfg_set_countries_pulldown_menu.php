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
  use Kuuzu\KU\Core\Site\Shop\Address;

  function kuu_cfg_set_countries_pulldown_menu($default, $key = null) {
    $name = (!empty($key) ? 'configuration[' . $key . ']' : 'configuration_value');

    $countries_array = array();

    foreach ( Address::getCountries() as $country ) {
      $countries_array[] = array('id' => $country['id'],
                                 'text' => $country['name']);
    }

    return HTML::selectMenu($name, $countries_array, $default);
  }
?>
