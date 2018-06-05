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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Dashboard\Model;

  use Kuuzu\KU\Core\KUUZU;

  class deleteShortcut {
    public static function execute($admin_id, $application) {
      $data = array('admin_id' => $admin_id,
                    'application' => $application);

      return KUUZU::callDB('Admin\Dashboard\DeleteShortcut', $data);
    }
  }
?>
