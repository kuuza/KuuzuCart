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

  class findDefinitions {
    public static function execute($language_id, $group, $search) {
      $data = array('id' => $language_id,
                    'group' => $group,
                    'keywords' => $search);

      return KUUZU::callDB('Admin\Languages\FindDefinitions', $data);
    }
  }
?>
