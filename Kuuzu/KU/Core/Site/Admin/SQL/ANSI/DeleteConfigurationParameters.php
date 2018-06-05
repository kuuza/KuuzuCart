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

  namespace Kuuzu\KU\Core\Site\Admin\SQL\ANSI;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class DeleteConfigurationParameters {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      if ( !is_array($data) ) {
        $data = array($data);
      }

      $error = false;
      $in_transaction = false;

      if ( count($data) > 1 ) {
        $KUUZU_PDO->beginTransaction();

        $in_transaction = true;
      }

      $Qcfg = $KUUZU_PDO->prepare('delete from :table_configuration where configuration_key = :configuration_key');

      foreach ( $data as $key ) {
        $Qcfg->bindValue(':configuration_key', $key);
        $Qcfg->execute();

        if ( $Qcfg->isError() ) {
          if ( $in_transaction === true ) {
            $KUUZU_PDO->rollBack();
          }

          $error = true;

          break;
        }
      }

      if ( ($error === false) && ($in_transaction === true) ) {
        $KUUZU_PDO->commit();
      }

      return !$error;
    }
  }
?>
