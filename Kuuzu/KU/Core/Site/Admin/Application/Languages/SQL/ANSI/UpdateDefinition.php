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

  class UpdateDefinition {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qupdate = $KUUZU_PDO->prepare('update :table_languages_definitions set definition_value = :definition_value where definition_key = :definition_key and languages_id = :languages_id and content_group = :content_group');
      $Qupdate->bindValue(':definition_value', $data['value']);
      $Qupdate->bindValue(':definition_key', $data['key']);
      $Qupdate->bindInt(':languages_id', $data['language_id']);
      $Qupdate->bindValue(':content_group', $data['group']);
      $Qupdate->execute();

      return ( ($Qupdate->rowCount() === 1) || !$Qupdate->isError() );
    }
  }
?>
