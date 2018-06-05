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

  class GetLanguage {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qlanguage = $KUUZU_PDO->prepare('select * from :table_languages where languages_id = :languages_id');
      $Qlanguage->bindInt(':languages_id', $data['id']);
      $Qlanguage->execute();

      return $Qlanguage->fetch();
    }
  }
?>
