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

  namespace Kuuzu\KU\Core\Site\Admin\Application\CoreUpdate\Model;

  use Kuuzu\KU\Core\DateTime;
  use Kuuzu\KU\Core\KUUZU;

/**
 * @since v3.0.2
 */

  class getLog {
    public static function execute($log) {
      $log = basename($log);

      if ( substr($log, 0, -4) != '.txt' ) {
        $log .= '.txt';
      }

      $result = array('entries' => array());

      foreach ( file(KUUZU::BASE_DIRECTORY . 'Work/Logs/' . $log) as $l ) {
        if ( preg_match('/^\[([0-9]{2})-([A-Za-z]{3})-([0-9]{4}) ([0-9]{2}):([0-5][0-9]):([0-5][0-9])\] (.*)$/', $l) ) {
          $result['entries'][] = array('date' => DateTime::getShort(DateTime::fromUnixTimestamp(DateTime::getTimestamp(substr($l, 1, 20), 'd-M-Y H:i:s')), true),
                                       'message' => substr($l, 23));
        }
      }

      $result['total'] = count($result['entries']);

      return $result;
    }
  }
?>
