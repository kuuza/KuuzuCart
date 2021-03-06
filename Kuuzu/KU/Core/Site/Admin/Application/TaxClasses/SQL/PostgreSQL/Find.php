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

  namespace Kuuzu\KU\Core\Site\Admin\Application\TaxClasses\SQL\PostgreSQL;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class Find {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $result = array();

      $sql_query = 'select distinct tc.*, (select count(*) from :table_tax_rates tr where tr.tax_class_id = tc.tax_class_id) as total_tax_rates from :table_tax_class tc left join :table_tax_rates tr on (tc.tax_class_id = tr.tax_class_id) where (tc.tax_class_title ilike :tax_class_title or tr.tax_description ilike :tax_description) order by tc.tax_class_title';

      if ( $data['batch_pageset'] !== -1 ) {
        $sql_query .= ' limit :batch_max_results offset :batch_pageset';
      }

      $Qclasses = $KUUZU_PDO->prepare($sql_query);
      $Qclasses->bindValue(':tax_class_title', '%' . $data['keywords'] . '%');
      $Qclasses->bindValue(':tax_description', '%' . $data['keywords'] . '%');

      if ( $data['batch_pageset'] !== -1 ) {
        $Qclasses->bindInt(':batch_pageset', $KUUZU_PDO->getBatchFrom($data['batch_pageset'], $data['batch_max_results']));
        $Qclasses->bindInt(':batch_max_results', $data['batch_max_results']);
      }

      $Qclasses->execute();

      $result['entries'] = $Qclasses->fetchAll();

      $Qtotal = $KUUZU_PDO->prepare('select count(distinct tc.tax_class_id) from :table_tax_class tc left join :table_tax_rates tr on (tc.tax_class_id = tr.tax_class_id) where (tc.tax_class_title ilike :tax_class_title or tr.tax_description ilike :tax_description)');
      $Qtotal->bindValue(':tax_class_title', '%' . $data['keywords'] . '%');
      $Qtotal->bindValue(':tax_description', '%' . $data['keywords'] . '%');
      $Qtotal->execute();

      $result['total'] = $Qtotal->fetchColumn();

      return $result;
    }
  }
?>
