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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Administrators\SQL\ANSI;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class Get {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qadmin = $KUUZU_PDO->prepare('select * from :table_administrators where id = :id');
      $Qadmin->bindInt(':id', $data['id']);
      $Qadmin->execute();

      $result = $Qadmin->fetch();

      $result['access_modules'] = array();

      $Qaccess = $KUUZU_PDO->prepare('select module from :table_administrators_access where administrators_id = :administrators_id');
      $Qaccess->bindInt(':administrators_id', $data['id']);
      $Qaccess->execute();

      while ( $row = $Qaccess->fetch() ) {
        $result['access_modules'][] = $row['module'];
      }

      return $result;
    }
  }
?>
