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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Login\SQL\Microsoft\SqlServer;

  use Kuuzu\KU\Core\Registry;

  class GetAdmin {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qadmin = $KUUZU_PDO->prepare('select top 1 id, user_name, user_password from :table_administrators where user_name = :user_name');
      $Qadmin->bindValue(':user_name', $data['username']);
      $Qadmin->execute();

      return $Qadmin->fetch();
    }
  }
?>
