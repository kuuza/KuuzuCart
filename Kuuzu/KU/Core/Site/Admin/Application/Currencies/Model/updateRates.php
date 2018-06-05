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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Currencies\Model;

  use Kuuzu\KU\Core\Site\Admin\Application\Currencies\Currencies;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Cache;

  class updateRates {
    public static function execute($service) {
      $updated = array('0' => array(),
                       '1' => array());

      $currencies = Currencies::getAll(-1);
      $currencies = $currencies['entries'];

      foreach ( $currencies as $currency ) {
        $data = array('id' => $currency['currencies_id'],
                      'rate' => call_user_func('quote_' . $service . '_currency', $currency['code']));

        if ( !empty($data['rate']) && KUUZU::callDB('Admin\Currencies\UpdateRate', $data) ) {
          $updated[1][] = array('title' => $currency['title'],
                                'code' => $currency['code']);
        } else {
          $updated[0][] = array('title' => $currency['title'],
                                'code' => $currency['code']);
        }
      }

      if ( !empty($updated[1]) ) {
        Cache::clear('currencies');
      }

      return $updated;
    }
  }
?>
