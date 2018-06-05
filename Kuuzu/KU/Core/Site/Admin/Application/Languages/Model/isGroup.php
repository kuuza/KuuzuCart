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

  class isGroup {
    public static function execute($language_id, $group) {
      $result = KUUZU::callDB('Admin\Languages\GetGroup', array('group' => $group));

      foreach ( $result['entries'] as $entry ) {
        if ( $entry['languages_id'] == $language_id ) {
          return true;
        }
      }

      return false;
    }
  }
?>
