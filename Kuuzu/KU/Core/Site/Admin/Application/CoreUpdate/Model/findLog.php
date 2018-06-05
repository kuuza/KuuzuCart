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
  use Kuuzu\KU\Core\Site\Admin\Application\CoreUpdate\CoreUpdate;

/**
 * @since v3.0.2
 */

  class findLog {
    public static function execute($log, $search) {
      $data = CoreUpdate::getLog($log);

      $result = array('entries' => array());

      foreach ( $data['entries'] as $l ) {
        if ( stripos($l['message'], $search) !== false ) {
          $result['entries'][] = $l;
        }
      }

      $result['total'] = count($result['entries']);

      return $result;
    }
  }
?>
