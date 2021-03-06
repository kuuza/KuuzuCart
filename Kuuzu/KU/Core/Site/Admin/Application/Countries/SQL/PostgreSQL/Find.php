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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Countries\SQL\PostgreSQL;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class Find {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $result = array();

      $sql_query = 'select distinct c.*, (select count(*) from :table_zones z where z.zone_country_id = c.countries_id) as total_zones from :table_countries c left join :table_zones z on (c.countries_id = z.zone_country_id) where (c.countries_name ilike :countries_name or c.countries_iso_code_2 ilike :countries_iso_code_2 or c.countries_iso_code_3 ilike :countries_iso_code_3 or z.zone_name ilike :zone_name or z.zone_code ilike :zone_code) order by c.countries_name';

      if ( $data['batch_pageset'] !== -1 ) {
        $sql_query .= ' limit :batch_max_results offset :batch_pageset';
      }

      $Qcountries = $KUUZU_PDO->prepare($sql_query);
      $Qcountries->bindValue(':countries_name', '%' . $data['keywords'] . '%');
      $Qcountries->bindValue(':countries_iso_code_2', '%' . $data['keywords'] . '%');
      $Qcountries->bindValue(':countries_iso_code_3', '%' . $data['keywords'] . '%');
      $Qcountries->bindValue(':zone_name', '%' . $data['keywords'] . '%');
      $Qcountries->bindValue(':zone_code', '%' . $data['keywords'] . '%');

      if ( $data['batch_pageset'] !== -1 ) {
        $Qcountries->bindInt(':batch_pageset', $KUUZU_PDO->getBatchFrom($data['batch_pageset'], $data['batch_max_results']));
        $Qcountries->bindInt(':batch_max_results', $data['batch_max_results']);
      }

      $Qcountries->execute();

      $result['entries'] = $Qcountries->fetchAll();

      $Qtotal = $KUUZU_PDO->prepare('select count(distinct c.countries_id) from :table_countries c left join :table_zones z on (c.countries_id = z.zone_country_id) where (c.countries_name ilike :countries_name or c.countries_iso_code_2 ilike :countries_iso_code_2 or c.countries_iso_code_3 ilike :countries_iso_code_3 or z.zone_name ilike :zone_name or z.zone_code ilike :zone_code)');
      $Qtotal->bindValue(':countries_name', '%' . $data['keywords'] . '%');
      $Qtotal->bindValue(':countries_iso_code_2', '%' . $data['keywords'] . '%');
      $Qtotal->bindValue(':countries_iso_code_3', '%' . $data['keywords'] . '%');
      $Qtotal->bindValue(':zone_name', '%' . $data['keywords'] . '%');
      $Qtotal->bindValue(':zone_code', '%' . $data['keywords'] . '%');
      $Qtotal->execute();

      $result['total'] = $Qtotal->fetchColumn();

      return $result;
    }
  }
?>
