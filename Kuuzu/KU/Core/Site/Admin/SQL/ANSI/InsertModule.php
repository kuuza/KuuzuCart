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

  namespace Kuuzu\KU\Core\Site\Admin\SQL\ANSI;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class InsertModule {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qinstall = $KUUZU_PDO->prepare('insert into :table_modules (title, code, author_name, author_www, modules_group) values (:title, :code, :author_name, :author_www, :modules_group)');
      $Qinstall->bindValue(':title', $data['title']);
      $Qinstall->bindValue(':code', $data['code']);
      $Qinstall->bindValue(':author_name', $data['author_name']);
      $Qinstall->bindValue(':author_www', $data['author_www']);
      $Qinstall->bindValue(':modules_group', $data['group']);
      $Qinstall->execute();

      return !$Qinstall->isError();
    }
  }
?>
