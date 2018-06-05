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

  namespace Kuuzu\KU\Core\Site\Admin\Application\PaymentModules\SQL\ANSI;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class Save {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $error = false;

      $KUUZU_PDO->beginTransaction();

      foreach ( $data['configuration'] as $key => $value ) {
        $Qupdate = $KUUZU_PDO->prepare('update :table_configuration set configuration_value = :configuration_value where configuration_key = :configuration_key');
        $Qupdate->bindValue(':configuration_value', is_array($data['configuration'][$key]) ? implode(',', $data['configuration'][$key]) : $value);
        $Qupdate->bindValue(':configuration_key', $key);
        $Qupdate->execute();

        if ( $Qupdate->isError() ) {
          $error = true;
          break;
        }
      }

      if ( $error === false ) {
        $KUUZU_PDO->commit();

        return true;
      }

      $KUUZU_PDO->rollBack();

      return false;
    }
  }
?>
