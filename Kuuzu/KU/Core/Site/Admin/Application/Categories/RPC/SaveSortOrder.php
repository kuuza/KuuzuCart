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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Categories\RPC;

  use Kuuzu\KU\Core\Site\Admin\Application\Categories\Categories;
  use Kuuzu\KU\Core\Site\RPC\Controller as RPC;

/**
 * @since v3.0.2
 */

  class SaveSortOrder {
    public static function execute() {
      $result = array();

      $data = array();
      $counter = 0;

      foreach ( $_GET['row'] as $row ) {
        $data[] = array('id' => $row,
                        'sort_order' => $counter);

        $counter++;
      }

      if ( Categories::saveSortOrder($data) ) {
        $result['rpcStatus'] = RPC::STATUS_SUCCESS;
      }

      echo json_encode($result);
    }
  }
?>
