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

  class Get {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Q = $KUUZU_PDO->prepare('EXEC CountriesGet :countries_id');
      $Q->bindInt(':countries_id', $data['id']);
      $Q->execute();

      $result_1 = $Q->toArray();

      $Q->nextResultSet();

      $result_2 = $Q->toArray();

      return array_merge($result_1, $result_2);
    }
  }
?>
