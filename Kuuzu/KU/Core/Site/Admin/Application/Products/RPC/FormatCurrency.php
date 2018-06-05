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

  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\RPC\Controller as RPC;
  use Kuuzu\KU\Core\Site\Shop\Currencies;

/**
 * @since v3.0.3
 */

  class FormatCurrency {
    public static function execute() {
      if ( !Registry::exists('Currencies') ) {
        Registry::set('Currencies', new Currencies());
      }

      $KUUZU_Currencies = Registry::get('Currencies');

      $result = array('value' => $KUUZU_Currencies->format($_GET['value']),
                      'rpcStatus' => RPC::STATUS_SUCCESS);

      echo json_encode($result);
    }
  }
?>
