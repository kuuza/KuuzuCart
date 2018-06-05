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
  use Kuuzu\KU\Core\Site\Admin\Application\PaymentModules\PaymentModules;
  use Kuuzu\KU\Core\DirectoryListing;
  use Kuuzu\KU\Core\KUUZU;

  class getUninstalled {
    public static function execute() {
      $KUUZU_Language = Registry::get('Language');

      $installed_modules = PaymentModules::getInstalled();
      $installed = array();

      foreach ( $installed_modules['entries'] as $module ) {
        $installed[] = $module['code'];
      }

      $result = array('entries' => array());

      $DLpm = new DirectoryListing(KUUZU::BASE_DIRECTORY . 'Core/Site/Admin/Module/Payment');
      $DLpm->setIncludeDirectories(false);

      foreach ( $DLpm->getFiles() as $file ) {
        $module = substr($file['name'], 0, strrpos($file['name'], '.'));

        if ( !in_array($module, $installed) ) {
          $class = 'Kuuzu\\KU\\Core\\Site\\Admin\\Module\\Payment\\' . $module;

          $KUUZU_Language->injectDefinitions('modules/payment/' . $module . '.xml');

          $KUUZU_PM = new $class();

          $result['entries'][] = array('code' => $KUUZU_PM->getCode(),
                                       'title' => $KUUZU_PM->getTitle(),
                                       'sort_order' => $KUUZU_PM->getSortOrder(),
                                       'status' => $KUUZU_PM->isEnabled());
        }
      }

      $result['total'] = count($result['entries']);

      return $result;
    }
  }
?>
