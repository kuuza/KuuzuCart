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

  class insertDefinition {
    public static function execute($data) {
      $languages = Languages::getAll(-1);
      $languages = $languages['entries'];

      $values = $data['values'];

      unset($data['values']);

      foreach ( $languages as $l ) {
        $data['language_id'] = $l['languages_id'];
        $data['value'] = $values[$l['languages_id']];

        KUUZU::callDB('Admin\Languages\InsertDefinition', $data);

        Cache::clear('languages-' . $l['code'] . '-' . $data['group']);
      }

      return true;
    }
  }
?>
