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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Languages\SQL\ANSI;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class DeleteGroup {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qdel = $KUUZU_PDO->prepare('delete from :table_languages_definitions where content_group = :content_group');
      $Qdel->bindValue(':content_group', $data['group']);
      $Qdel->execute();

      return ( $Qdel->rowCount() > 0 );
    }
  }
?>
