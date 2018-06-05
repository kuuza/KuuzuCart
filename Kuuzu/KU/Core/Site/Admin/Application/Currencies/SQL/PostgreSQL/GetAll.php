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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Currencies\SQL\PostgreSQL;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class GetAll {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $result = array();

      $sql_query = 'select * from :table_currencies order by title';

      if ( $data['batch_pageset'] !== -1 ) {
        $sql_query .= ' limit :batch_max_results offset :batch_pageset';
      }

      $Qcurrencies = $KUUZU_PDO->prepare($sql_query);

      if ( $data['batch_pageset'] !== -1 ) {
        $Qcurrencies->bindInt(':batch_pageset', $KUUZU_PDO->getBatchFrom($data['batch_pageset'], $data['batch_max_results']));
        $Qcurrencies->bindInt(':batch_max_results', $data['batch_max_results']);
      }

      $Qcurrencies->execute();

      $result['entries'] = $Qcurrencies->fetchAll();

      $Qtotal = $KUUZU_PDO->query('select count(*) from :table_currencies');
      $Qtotal->execute();

      $result['total'] = $Qtotal->fetchColumn();

      return $result;
    }
  }
?>
