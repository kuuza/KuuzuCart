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

  namespace Kuuzu\KU\Core\Site\Admin\Application\CreditCards\SQL\ANSI;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class SetStatus {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qcc = $KUUZU_PDO->prepare('update :table_credit_cards set credit_card_status = :credit_card_status where id = :id');
      $Qcc->bindInt(':credit_card_status', ($data['status'] === true) ? 1 : 0);
      $Qcc->bindInt(':id', $data['id']);
      $Qcc->execute();

      return ( ($Qcc->rowCount() === 1) || !$Qcc->isError() );
    }
  }
?>
