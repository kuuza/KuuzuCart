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

  namespace Kuuzu\KU\Core\Site\Admin\Application\ZoneGroups\RPC;

  use Kuuzu\KU\Core\Site\Admin\Application\ZoneGroups\ZoneGroups;
  use Kuuzu\KU\Core\Site\RPC\Controller as RPC;

  class GetAllEntries {
    public static function execute() {
      if ( !isset($_GET['search']) ) {
        $_GET['search'] = '';
      }

      if ( !empty($_GET['search']) ) {
        $result = ZoneGroups::findEntries($_GET['search'], $_GET['id']);
      } else {
        $result = ZoneGroups::getAllEntries($_GET['id']);
      }

      $result['rpcStatus'] = RPC::STATUS_SUCCESS;

      echo json_encode($result);
    }
  }
?>
