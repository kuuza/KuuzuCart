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

  namespace Kuuzu\KU\Core\Site\Admin\Application\CreditCards\RPC;

  use Kuuzu\KU\Core\Site\Admin\Application\CreditCards\CreditCards;
  use Kuuzu\KU\Core\Site\RPC\Controller as RPC;

  class GetAll {
    public static function execute() {
      if ( !isset($_GET['search']) ) {
        $_GET['search'] = '';
      }

      if ( !isset($_GET['page']) || !is_numeric($_GET['page']) ) {
        $_GET['page'] = 1;
      }

      if ( !empty($_GET['search']) ) {
        $result = CreditCards::find($_GET['search'], $_GET['page']);
      } else {
        $result = CreditCards::getAll($_GET['page']);
      }

      $result['rpcStatus'] = RPC::STATUS_SUCCESS;

      echo json_encode($result);
    }
  }
?>
