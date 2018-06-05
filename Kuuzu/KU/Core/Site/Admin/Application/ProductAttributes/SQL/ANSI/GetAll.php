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

  namespace Kuuzu\KU\Core\Site\Admin\Application\ProductAttributes\SQL\ANSI;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class GetAll {
    public static function execute() {
      $KUUZU_PDO = Registry::get('PDO');

      $result = array();

      $Qpa = $KUUZU_PDO->prepare('select id, code from :table_templates_boxes where modules_group = :modules_group order by code');
      $Qpa->bindValue(':modules_group', 'ProductAttribute');
      $Qpa->execute();

      $result['entries'] = $Qpa->fetchAll();

      $result['total'] = count($result['entries']);

      return $result;
    }
  }
?>
