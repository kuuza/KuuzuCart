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

  namespace Kuuzu\KU\Core\Site\Admin\Application\TaxClasses\SQL\ANSI;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class EntryDelete {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qrate = $KUUZU_PDO->prepare('delete from :table_tax_rates where tax_rates_id = :tax_rates_id');
      $Qrate->bindInt(':tax_rates_id', $data['id']);
      $Qrate->execute();

      return ( $Qrate->rowCount() === 1 );
    }
  }
?>
