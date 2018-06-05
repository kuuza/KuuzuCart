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

  use Kuuzu\KU\Core\Site\Admin\Application\Languages\Languages;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Cache;

  class deleteDefinition {
    public static function execute($id) {
      $def = Languages::getDefinition($id);

      $data = array('id' => $id);

      if ( KUUZU::callDB('Admin\Languages\DeleteDefinition', $data) ) {
        Cache::clear('languages-' . Languages::get($def['languages_id'], 'code') . '-' . $def['content_group']);

        return true;
      }

      return false;
    }
  }
?>
