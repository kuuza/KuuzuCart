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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Services\Model;

/**
 * @since v3.0.2
 */

  class getInstalled {
    public static function execute() {
      $result = array();
      $result['entries'] = array();

      foreach ( explode(';', MODULE_SERVICES_INSTALLED) as $sm ) {
        $result['entries'][] = array('code' => $sm);
      }

      $result['total'] = count($result['entries']);

      foreach ( $result['entries'] as &$module ) {
        $class = 'Kuuzu\\KU\\Core\\Site\\Admin\\Module\\Service\\' . $module['code'];

        $KUUZU_SM = new $class();

        $module['code'] = $KUUZU_SM->getCode();
        $module['title'] = $KUUZU_SM->getTitle();
        $module['description'] = $KUUZU_SM->getDescription();
        $module['uninstallable'] = $KUUZU_SM->isUninstallable();
        $module['has_keys'] = $KUUZU_SM->hasKeys();
      }

      return $result;
    }
  }
?>
