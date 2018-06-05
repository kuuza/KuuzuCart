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

  class Delete {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Q = $KUUZU_PDO->prepare('delete from :table_countries where countries_id = :countries_id');
      $Q->bindInt(':countries_id', $data['id']);
      $Q->execute();

      return !$Q->isError();
    }
  }
?>
