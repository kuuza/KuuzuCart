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

  class DeleteModule {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qdel = $KUUZU_PDO->prepare('delete from :table_modules where code = :code and modules_group = :modules_group');
      $Qdel->bindValue(':code', $data['code']);
      $Qdel->bindValue(':modules_group', $data['group']);
      $Qdel->execute();

      return !$Qdel->isError();
    }
  }
?>
