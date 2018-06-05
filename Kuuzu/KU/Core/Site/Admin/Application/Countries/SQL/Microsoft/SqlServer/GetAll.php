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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Countries\SQL\Microsoft\SqlServer;

  use Kuuzu\KU\Core\Registry;

  class GetAll {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $result = array();

      $Qcountries = $KUUZU_PDO->prepare('EXEC CountriesGetAll :batch_pageset, :batch_max_results');
      $Qcountries->bindInt(':batch_pageset', $data['batch_pageset']);
      $Qcountries->bindInt(':batch_max_results', $data['batch_max_results']);
      $Qcountries->execute();

      $result['entries'] = $Qcountries->fetchAll();

      $Qcountries->nextRowset();

      $result['total'] = $Qcountries->fetchColumn();

      return $result;
    }
  }
?>
