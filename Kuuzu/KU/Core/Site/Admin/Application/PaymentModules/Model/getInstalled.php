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

  namespace Kuuzu\KU\Core\Site\Admin\Application\PaymentModules\Model;

  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;

  class getInstalled {
    public static function execute() {
      $KUUZU_Language = Registry::get('Language');

      $result = KUUZU::callDB('Admin\PaymentModules\GetAll');

      foreach ( $result['entries'] as &$module ) {
        $class = 'Kuuzu\\KU\\Core\\Site\\Admin\\Module\\Payment\\' . $module['code'];

        $KUUZU_Language->injectDefinitions('modules/payment/' . $module['code'] . '.xml');

        $KUUZU_PM = new $class();

        $module['code'] = $KUUZU_PM->getCode();
        $module['title'] = $KUUZU_PM->getTitle();
        $module['sort_order'] = $KUUZU_PM->getSortOrder();
        $module['status'] = $KUUZU_PM->isInstalled() && $KUUZU_PM->isEnabled();
      }

      return $result;
    }
  }
?>
