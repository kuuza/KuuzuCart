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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Countries\SQL\MySQL\Standard;

  use Kuuzu\KU\Core\Registry;

  class Get {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qcountries = $KUUZU_PDO->prepare('select c.*, count(z.zone_id) as total_zones2 from :table_countries c left join :table_zones z on (c.countries_id = z.zone_country_id) where c.countries_id = :countries_id');
      $Qcountries->bindInt(':countries_id', $data['id']);
      $Qcountries->execute();

      return $Qcountries->fetch();
    }
  }
?>
