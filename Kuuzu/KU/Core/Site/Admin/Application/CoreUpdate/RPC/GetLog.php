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

  namespace Kuuzu\KU\Core\Site\Admin\Application\CoreUpdate\RPC;

  use Kuuzu\KU\Core\Site\Admin\Application\CoreUpdate\CoreUpdate;
  use Kuuzu\KU\Core\Site\RPC\Controller as RPC;

/**
 * @since v3.0.2
 */

  class GetLog {
    public static function execute() {
      if ( !isset($_GET['search']) ) {
        $_GET['search'] = '';
      }

      if ( !empty($_GET['search']) ) {
        $result = CoreUpdate::findLog($_GET['log'], $_GET['search']);
      } else {
        $result = CoreUpdate::getLog($_GET['log']);
      }

      $result['rpcStatus'] = RPC::STATUS_SUCCESS;

      echo json_encode($result);
    }
  }
?>
