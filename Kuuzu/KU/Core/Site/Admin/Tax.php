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

  namespace Kuuzu\KU\Core\Site\Admin;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class Tax extends \Kuuzu\KU\Core\Site\Shop\Tax {
    public function getTaxRate($class_id, $country_id = null, $zone_id = null) {
      if ( !isset($country_id) && !isset($zone_id)) {
        $country_id = STORE_COUNTRY;
        $zone_id = STORE_ZONE;
      }

      return parent::getTaxRate($class_id, $country_id, $zone_id);
    }

    public static function getClasses() {
      $KUUZU_PDO = Registry::get('PDO');

      $Qtc = $KUUZU_PDO->query('select tax_class_id, tax_class_title from :table_tax_class order by tax_class_title');
      $Qtc->execute();

      return $Qtc->fetchAll();
    }
  }
?>
