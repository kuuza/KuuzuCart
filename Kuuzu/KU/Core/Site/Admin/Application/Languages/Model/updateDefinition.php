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
  use Kuuzu\KU\Core\Site\Admin\Application\Languages\Languages;

  class updateDefinition {
    public static function execute($data) {
      $definitions = $data['definitions'];

      unset($data['definitions']);

      foreach ( $definitions as $key => $value ) {
        $data['key'] = $key;
        $data['value'] = $value;

        KUUZU::callDB('Admin\Languages\UpdateDefinition', $data);

        Cache::clear('languages-' . Languages::get($data['language_id'], 'code') . '-' . $data['group']);
      }

      return true;
    }
  }
?>
