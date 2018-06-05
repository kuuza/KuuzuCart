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

  namespace Kuuzu\KU\Core\Site\Admin\Application\TaxClasses\SQL\PostgreSQL;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class Get {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qclasses = $KUUZU_PDO->prepare('select tc.*, (select count(*) from :table_tax_rates tr where tr.tax_class_id = tc.tax_class_id) as total_tax_rates from :table_tax_class tc where tc.tax_class_id = :tax_class_id');
      $Qclasses->bindInt(':tax_class_id', $data['id']);
      $Qclasses->execute();

      return $Qclasses->fetch();
    }
  }
?>
