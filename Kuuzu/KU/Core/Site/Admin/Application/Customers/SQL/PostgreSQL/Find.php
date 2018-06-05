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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Customers\SQL\PostgreSQL;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class Find {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $result = array();

      $sql_query = 'select c.customers_id, c.customers_gender, c.customers_firstname, c.customers_lastname, c.customers_status, c.date_account_created, a.entry_country_id from :table_customers c left join :table_address_book a on (c.customers_id = a.customers_id and c.customers_default_address_id = a.address_book_id) where (c.customers_firstname ilike :customers_firstname or c.customers_lastname ilike :customers_lastname) order by c.customers_lastname, c.customers_firstname';

      if ( $data['batch_pageset'] !== -1 ) {
        $sql_query .= ' limit :batch_max_results offset :batch_pageset';
      }

      $Qcustomers = $KUUZU_PDO->prepare($sql_query);
      $Qcustomers->bindValue(':customers_firstname', '%' . $data['keywords'] . '%');
      $Qcustomers->bindValue(':customers_lastname', '%' . $data['keywords'] . '%');

      if ( $data['batch_pageset'] !== -1 ) {
        $Qcustomers->bindInt(':batch_pageset', $KUUZU_PDO->getBatchFrom($data['batch_pageset'], $data['batch_max_results']));
        $Qcustomers->bindInt(':batch_max_results', $data['batch_max_results']);
      }

      $Qcustomers->execute();

      $result['entries'] = $Qcustomers->fetchAll();

      $Qtotal = $KUUZU_PDO->prepare('select count(*) from :table_customers where (customers_firstname ilike :customers_firstname or customers_lastname ilike :customers_lastname)');
      $Qtotal->bindValue(':customers_firstname', '%' . $data['keywords'] . '%');
      $Qtotal->bindValue(':customers_lastname', '%' . $data['keywords'] . '%');
      $Qtotal->execute();

      $result['total'] = $Qtotal->fetchColumn();

      return $result;
    }
  }
?>
