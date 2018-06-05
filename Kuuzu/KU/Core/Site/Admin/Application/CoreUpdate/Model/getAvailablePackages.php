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

  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\HttpRequest;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\DateTime;

  class getAvailablePackages {
    public static function execute() {
      $KUUZU_Cache = Registry::get('Cache');

      $result = array('entries' => array());

      if ( $KUUZU_Cache->read('coreupdate-availablepackages', 360) ) {
        $versions = $KUUZU_Cache->getCache();
      } else {
        $versions = HttpRequest::getResponse(array('url' => 'https://kuuzu.org/version/cart/1', 'method' => 'get'));

        $KUUZU_Cache->write($versions);
      }

      $versions_array = explode("\n", $versions);

      $counter = 0;

      foreach ( $versions_array as $v ) {
        $v_info = explode('|', $v);

        if ( version_compare(KUUZU::getVersion(), $v_info[0], '<') ) {
          $result['entries'][] = array('key' => $counter,
                                       'version' => $v_info[0],
                                       'date' => DateTime::getShort(DateTime::fromUnixTimestamp(DateTime::getTimestamp($v_info[1], 'Ymd'))),
                                       'announcement' => $v_info[2],
                                       'update_package' => (isset($v_info[3]) ? $v_info[3] : null));

          $counter++;
        }
      }

      usort($result['entries'], function ($a, $b) {
        return version_compare($a['version'], $b['version'], '>');
      });


      $result['total'] = count($result['entries']);

      return $result;
    }
  }
?>
