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

  class Save {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $KUUZU_PDO->beginTransaction();

      if ( is_numeric($data['id']) ) {
        $Qcurrency = $KUUZU_PDO->prepare('update :table_currencies set title = :title, code = :code, symbol_left = :symbol_left, symbol_right = :symbol_right, decimal_places = :decimal_places, value = :value where currencies_id = :currencies_id');
        $Qcurrency->bindInt(':currencies_id', $data['id']);
      } else {
        $Qcurrency = $KUUZU_PDO->prepare('insert into :table_currencies (title, code, symbol_left, symbol_right, decimal_places, value) values (:title, :code, :symbol_left, :symbol_right, :decimal_places, :value)');
      }

      $Qcurrency->bindValue(':title', $data['title']);
      $Qcurrency->bindValue(':code', $data['code']);
      $Qcurrency->bindValue(':symbol_left', $data['symbol_left']);
      $Qcurrency->bindValue(':symbol_right', $data['symbol_right']);
      $Qcurrency->bindInt(':decimal_places', $data['decimal_places']);
      $Qcurrency->bindValue(':value', $data['value']);
      $Qcurrency->execute();

      if ( !$Qcurrency->isError() ) {
        if ( $data['set_default'] === true ) {
          $Qupdate = $KUUZU_PDO->prepare('update :table_configuration set configuration_value = :configuration_value where configuration_key = :configuration_key');
          $Qupdate->bindValue(':configuration_value', $data['code']);
          $Qupdate->bindValue(':configuration_key', 'DEFAULT_CURRENCY');
          $Qupdate->execute();
        }

        $KUUZU_PDO->commit();

        return true;
      }

      $KUUZU_PDO->rollBack();

      return false;
    }
  }
?>
