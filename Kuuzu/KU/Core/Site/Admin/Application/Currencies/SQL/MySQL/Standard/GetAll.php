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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Currencies\SQL\MySQL\Standard;

  use Kuuzu\KU\Core\Registry;

  class GetAll {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $result = array();

      $sql_query = 'select SQL_CALC_FOUND_ROWS * from :table_currencies order by title';

      if ( $data['batch_pageset'] !== -1 ) {
        $sql_query .= ' limit :batch_pageset, :batch_max_results';
      }

      $sql_query .= '; select found_rows();';

      $Qcurrencies = $KUUZU_PDO->prepare($sql_query);

      if ( $data['batch_pageset'] !== -1 ) {
        $Qcurrencies->bindInt(':batch_pageset', $KUUZU_PDO->getBatchFrom($data['batch_pageset'], $data['batch_max_results']));
        $Qcurrencies->bindInt(':batch_max_results', $data['batch_max_results']);
      }

      $Qcurrencies->execute();

      $result['entries'] = $Qcurrencies->fetchAll();

      $Qcurrencies->nextRowset();

      $result['total'] = $Qcurrencies->fetchColumn();

      return $result;
    }
  }
?>
