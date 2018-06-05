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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Countries\SQL\ANSI;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class Delete {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qcountry = $KUUZU_PDO->prepare('delete from :table_countries where countries_id = :countries_id');
      $Qcountry->bindInt(':countries_id', $data['id']);
      $Qcountry->execute();

      return ( $Qcountry->rowCount() === 1 );
    }
  }
?>
