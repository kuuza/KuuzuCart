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

  namespace Kuuzu\KU\Core\Site\Shop\SQL\ANSI;

  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class GetConfiguration {
    public static function execute() {
      $KUUZU_PDO = Registry::get('PDO');

      $Qcfg = $KUUZU_PDO->prepare('select configuration_key as cfgkey, configuration_value as cfgvalue from :table_configuration');
      $Qcfg->setCache('configuration');
      $Qcfg->execute();

      return $Qcfg->fetchAll();
    }
  }
?>
