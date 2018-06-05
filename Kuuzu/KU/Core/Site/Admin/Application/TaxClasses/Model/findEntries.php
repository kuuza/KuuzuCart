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

  namespace Kuuzu\KU\Core\Site\Admin\Application\TaxClasses\Model;

  use Kuuzu\KU\Core\KUUZU;

  class findEntries {
    public static function execute($search, $tax_class_id) {
      $data = array('keywords' => $search,
                    'tax_class_id' => $tax_class_id);

      return KUUZU::callDB('Admin\TaxClasses\EntryFind', $data);
    }
  }
?>
