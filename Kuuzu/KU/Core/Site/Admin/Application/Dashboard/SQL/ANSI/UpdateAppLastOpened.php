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

  class UpdateAppLastOpened {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qreset = $KUUZU_PDO->prepare('update :table_administrator_shortcuts set last_viewed = now() where administrators_id = :administrators_id and module = :module');
      $Qreset->bindInt(':administrators_id', $data['admin_id']);
      $Qreset->bindValue(':module', $data['application']);
      $Qreset->execute();

      return ( ($Qreset->rowCount() === 1) || !$Qreset->isError() );
    }
  }
?>
