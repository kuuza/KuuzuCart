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

  namespace Kuuzu\KU\Core\SQL\ANSI;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class GetTemplates {
    public static function execute($data) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qtemplates = $KUUZU_PDO->prepare('select id, code, title from :table_templates');
      $Qtemplates->setCache('templates');
      $Qtemplates->execute();

      return $Qtemplates->fetchAll();
    }
  }
?>
