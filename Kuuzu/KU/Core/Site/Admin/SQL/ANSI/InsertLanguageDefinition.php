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

  class InsertLanguageDefinition {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      if ( isset($data['key']) && isset($data['value']) ) {
        $data = array($data);
      }

      $error = false;
      $in_transaction = false;

      if ( count($data) > 1 ) {
        $KUUZU_PDO->beginTransaction();

        $in_transaction = true;
      }

      $Qdef = $KUUZU_PDO->prepare('insert into :table_languages_definitions (languages_id, content_group, definition_key, definition_value) values (:languages_id, :content_group, :definition_key, :definition_value)');

      foreach ( $data as $d ) {
        $Qdef->bindInt(':languages_id', $d['id']);
        $Qdef->bindValue(':content_group', $d['group']);
        $Qdef->bindValue(':definition_key', $d['key']);
        $Qdef->bindValue(':definition_value', $d['value']);
        $Qdef->execute();

        if ( $Qdef->isError() ) {
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
