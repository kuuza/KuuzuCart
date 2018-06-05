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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Languages\SQL\ANSI;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class InsertDefinition {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qdef = $KUUZU_PDO->prepare('insert into :table_languages_definitions (languages_id, content_group, definition_key, definition_value) values (:languages_id, :content_group, :definition_key, :definition_value)');
      $Qdef->bindInt(':languages_id', $data['language_id']);
      $Qdef->bindValue(':content_group', $data['group']);
      $Qdef->bindValue(':definition_key', $data['key']);
      $Qdef->bindValue(':definition_value', $data['value']);
      $Qdef->execute();

      return ( ($Qdef->rowCount() === 1) || !$Qdef->isError() );
    }
  }
?>
