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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Administrators\Model;

  use Kuuzu\KU\Core\Site\Admin\Application\Administrators\Administrators;
  use Kuuzu\KU\Core\KUUZU;

  class setAccessLevels {
    public static function execute($id, $modules, $mode = Administrators::ACCESS_MODE_ADD) {
      $data = array('id' => $id,
                    'modules' => $modules,
                    'mode' => $mode);

      if ( in_array('0', $data['modules']) ) {
        $data['modules'] = array('*');
      }

      return KUUZU::callDB('Admin\Administrators\SavePermissions', $data);
    }
  }
?>
