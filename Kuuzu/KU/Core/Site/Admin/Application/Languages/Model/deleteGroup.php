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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Languages\Model;

  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Cache;

  class deleteGroup {
    public static function execute($group) {
      $data = array('group' => $group);

      if ( KUUZU::callDB('Admin\Languages\DeleteGroup', $data) ) {
        Cache::clear('languages');

        return true;
      }

      return false;
    }
  }
?>