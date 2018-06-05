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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Customers\RPC;

  use Kuuzu\KU\Core\Site\RPC\Controller as RPC;
  use Kuuzu\KU\Core\Site\Shop\Address;

/**
 * @since v3.0.2
 */

  class GetZones {
    public static function execute() {
      $result = array('zones' => Address::getZones($_GET['country_id']),
                      'rpcStatus' => RPC::STATUS_SUCCESS);

      echo json_encode($result);
    }
  }
?>
