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

  namespace Kuuzu\KU\Core\Site\Admin\Application\ErrorLog\Model;

  use Kuuzu\KU\Core\ErrorHandler;
  use Kuuzu\KU\Core\DateTime;

  class getShortcutNotification {
    public static function execute($datetime) {
      $errors = ErrorHandler::getAll(100);

      $from_timestamp = DateTime::getTimestamp($datetime, 'Y-m-d H:i:s');

      $result = 0;

      foreach ( $errors as $error ) {
        if ( $error['timestamp'] > $from_timestamp ) {
          $result++;
        }
      }

      return $result;
    }
  }
?>
