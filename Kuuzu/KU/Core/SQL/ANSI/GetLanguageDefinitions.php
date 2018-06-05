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

  namespace Kuuzu\KU\Core\SQL\ANSI;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class GetLanguageDefinitions {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qdef = $KUUZU_PDO->prepare('select * from :table_languages_definitions where languages_id = :languages_id and content_group = :content_group');
      $Qdef->bindInt(':languages_id', $data['language_id']);
      $Qdef->bindValue(':content_group', $data['group']);
      $Qdef->setCache('languages-' . $data['language_id'] . '-' . $data['group']);
      $Qdef->execute();

      return $Qdef->fetchAll();
    }
  }
?>
