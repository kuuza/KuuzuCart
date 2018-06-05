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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Customers\SQL\ANSI;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class Get {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $result = array();

      $sql_query = 'select * from :table_customers where ';

      if ( isset($data['email_address']) ) {
        $sql_query .= 'customers_email_address = :customers_email_address';
      } else {
        $sql_query .= 'customers_id = :customers_id';
      }

      $Qcustomer = $KUUZU_PDO->prepare($sql_query);

      if ( isset($data['email_address']) ) {
        $Qcustomer->bindValue(':customers_email_address', $data['email_address']);
      } else {
        $Qcustomer->bindInt(':customers_id', $data['id']);
      }

      $Qcustomer->execute();

      if ( $Qcustomer->fetch() !== false ) {
        $result = $Qcustomer->toArray();

        $result['customers_name'] = $result['customers_firstname'] . ' ' . $result['customers_lastname'];
      }

      return $result;
    }
  }
?>
