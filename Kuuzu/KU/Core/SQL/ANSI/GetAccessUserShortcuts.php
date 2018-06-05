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

  class GetAccessUserShortcuts {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qshortcuts = $KUUZU_PDO->prepare('select module from :table_administrator_shortcuts where administrators_id = :administrators_id');
      $Qshortcuts->bindInt(':administrators_id', $data['id']);
      $Qshortcuts->execute();

      return $Qshortcuts->fetchAll();
    }
  }
?>
