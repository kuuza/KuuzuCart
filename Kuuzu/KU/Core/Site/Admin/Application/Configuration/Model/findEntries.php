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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Configuration\Model;

  use Kuuzu\KU\Core\KUUZU;

  class findEntries {
    public static function execute($search, $group_id) {
      $data = array('group_id' => $group_id,
                    'search' => $search);

      $result = KUUZU::callDB('Admin\Configuration\EntryFind', $data);

      foreach ( $result['entries'] as &$row ) {
        if ( !empty($row['use_function']) ) {
          $row['configuration_value'] = callUserFunc::execute($row['use_function'], $row['configuration_value']);
        }
      }

      return $result;
    }
  }
?>
