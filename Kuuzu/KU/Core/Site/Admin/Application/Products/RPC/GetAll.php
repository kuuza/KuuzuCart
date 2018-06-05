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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Products\RPC;

  use Kuuzu\KU\Core\Site\Admin\Application\Products\Products;
  use Kuuzu\KU\Core\Site\RPC\Controller as RPC;

/**
 * @since v3.0.3
 */

  class GetAll {
    public static function execute() {
      if ( !isset($_GET['search']) ) {
        $_GET['search'] = '';
      }

      if ( !isset($_GET['cid']) ) {
        $_GET['cid'] = 0;
      }

      if ( !empty($_GET['search']) ) {
        $result = Products::find($_GET['search'], $_GET['cid']);
      } else {
        $result = Products::getAll($_GET['cid']);
      }

      $result['rpcStatus'] = RPC::STATUS_SUCCESS;

      echo json_encode($result);
    }
  }
?>
