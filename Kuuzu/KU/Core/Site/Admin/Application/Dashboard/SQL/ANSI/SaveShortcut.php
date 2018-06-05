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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Dashboard\SQL\ANSI;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class SaveShortcut {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qsc = $KUUZU_PDO->prepare('insert into :table_administrator_shortcuts (administrators_id, module, last_viewed) values (:administrators_id, :module, null)');
      $Qsc->bindInt(':administrators_id', $data['admin_id']);
      $Qsc->bindValue(':module', $data['application']);
      $Qsc->execute();

      return ( ($Qsc->rowCount() === 1) || !$Qsc->isError() );
    }
  }
?>
