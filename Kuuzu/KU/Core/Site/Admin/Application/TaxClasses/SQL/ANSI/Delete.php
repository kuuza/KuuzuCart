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

  class Delete {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qclass = $KUUZU_PDO->prepare('delete from :table_tax_class where tax_class_id = :tax_class_id');
      $Qclass->bindInt(':tax_class_id', $data['id']);
      $Qclass->execute();

      return ( $Qclass->rowCount() === 1 );
    }
  }
?>
