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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Customers\SQL\ANSI;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class GetAddressBook {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qab = $KUUZU_PDO->prepare('select ab.address_book_id, ab.entry_gender as gender, ab.entry_firstname as firstname, ab.entry_lastname as lastname, ab.entry_company as company, ab.entry_street_address as street_address, ab.entry_suburb as suburb, ab.entry_city as city, ab.entry_postcode as postcode, ab.entry_state as state, ab.entry_zone_id as zone_id, ab.entry_country_id as country_id, ab.entry_telephone as telephone_number, ab.entry_fax as fax_number, z.zone_code as zone_code, c.countries_name as country_title from :table_address_book ab left join :table_zones z on (ab.entry_zone_id = z.zone_id), :table_countries c where ab.customers_id = :customers_id and ab.entry_country_id = c.countries_id');
      $Qab->bindInt(':customers_id', $data['customer_id']);
      $Qab->execute();

      return $Qab->fetchAll();
    }
  }
?>
