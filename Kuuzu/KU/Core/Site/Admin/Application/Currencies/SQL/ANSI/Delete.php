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

  class Delete {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qcheck = $KUUZU_PDO->prepare('select code from :table_currencies where currencies_id = :currencies_id');
      $Qcheck->bindInt(':currencies_id', $data['id']);
      $Qcheck->execute();

      if ( $Qcheck->value('code') != DEFAULT_CURRENCY ) {
        $Qdelete = $KUUZU_PDO->prepare('delete from :table_currencies where currencies_id = :currencies_id');
        $Qdelete->bindInt(':currencies_id', $data['id']);
        $Qdelete->execute();

        return ( $Qdelete->rowCount() === 1 );
      }

      return false;
    }
  }
?>
