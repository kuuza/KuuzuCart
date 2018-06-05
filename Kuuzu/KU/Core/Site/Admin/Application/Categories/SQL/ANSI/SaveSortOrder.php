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

  class SaveSortOrder {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $error = false;

      $KUUZU_PDO->beginTransaction();

      foreach ( $data as $c ) {
        $Qcategory = $KUUZU_PDO->prepare('update :table_categories set sort_order = :sort_order, last_modified = now() where categories_id = :categories_id');
        $Qcategory->bindInt(':sort_order', $c['sort_order']);
        $Qcategory->bindInt(':categories_id', $c['id']);
        $Qcategory->execute();

        if ( $Qcategory->isError() ) {
          $error = true;
          break;
        }
      }

      if ( $error === false ) {
        $KUUZU_PDO->commit();

        return true;
      }

      $KUUZU_PDO->rollBack();

      return false;
    }
  }
?>
