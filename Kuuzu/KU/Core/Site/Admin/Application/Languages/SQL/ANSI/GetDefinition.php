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

  class GetDefinition {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qdef = $KUUZU_PDO->prepare('select * from :table_languages_definitions where id = :id');
      $Qdef->bindInt(':id', $data['id']);
      $Qdef->execute();

      return $Qdef->fetch();
    }
  }
?>
