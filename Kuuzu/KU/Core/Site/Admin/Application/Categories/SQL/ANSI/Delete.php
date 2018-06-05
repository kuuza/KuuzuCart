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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Categories\SQL\ANSI;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class Delete {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qdelete = $KUUZU_PDO->prepare('delete from :table_categories where categories_id = :categories_id');
      $Qdelete->bindInt(':categories_id', $data['id']);
      $Qdelete->execute();

      return ( $Qdelete->rowCount() === 1 );
    }
  }
?>
