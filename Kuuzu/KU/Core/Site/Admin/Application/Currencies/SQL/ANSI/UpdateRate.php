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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Currencies\SQL\ANSI;

  use Kuuzu\KU\Core\Registry;

  class UpdateRate {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qupdate = $KUUZU_PDO->prepare('update :table_currencies set value = :value, last_updated = now() where currencies_id = :currencies_id');
      $Qupdate->bindValue(':value', $data['rate']);
      $Qupdate->bindInt(':currencies_id', $data['id']);
      $Qupdate->execute();

      return ( ($Qupdate->rowCount() === 1) || !$Qupdate->isError() );
    }
  }
?>
