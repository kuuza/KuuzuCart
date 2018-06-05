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

  class Find {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $result = array();

      $sql_query = 'select * from :table_currencies where (title ilike :title or code ilike :code or symbol_left ilike :symbol_left or symbol_right ilike :symbol_right) order by title';

      if ( $data['batch_pageset'] !== -1 ) {
        $sql_query .= ' limit :batch_max_results offset :batch_pageset';
      }

      $Qcurrencies = $KUUZU_PDO->prepare($sql_query);
      $Qcurrencies->bindValue(':title', '%' . $data['keywords'] . '%');
      $Qcurrencies->bindValue(':code', '%' . $data['keywords'] . '%');
      $Qcurrencies->bindValue(':symbol_left', '%' . $data['keywords'] . '%');
      $Qcurrencies->bindValue(':symbol_right', '%' . $data['keywords'] . '%');

      if ( $data['batch_pageset'] !== -1 ) {
        $Qcurrencies->bindInt(':batch_pageset', $KUUZU_PDO->getBatchFrom($data['batch_pageset'], $data['batch_max_results']));
        $Qcurrencies->bindInt(':batch_max_results', $data['batch_max_results']);
      }

      $Qcurrencies->execute();

      $result['entries'] = $Qcurrencies->fetchAll();

      $Qtotal = $KUUZU_PDO->prepare('select count(*) from :table_currencies where (title ilike :title or code ilike :code or symbol_left ilike :symbol_left or symbol_right ilike :symbol_right)');
      $Qtotal->bindValue(':title', '%' . $data['keywords'] . '%');
      $Qtotal->bindValue(':code', '%' . $data['keywords'] . '%');
      $Qtotal->bindValue(':symbol_left', '%' . $data['keywords'] . '%');
      $Qtotal->bindValue(':symbol_right', '%' . $data['keywords'] . '%');
      $Qtotal->execute();

      $result['total'] = $Qtotal->fetchColumn();

      return $result;
    }
  }
?>
