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

  use Kuuzu\KU\Core\DirectoryListing;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Admin\Application\Services\Services;

/**
 * @since v3.0.2
 */

  class getUninstalled {
    public static function execute() {
      $installed_modules = Services::getInstalled();
      $installed = array();

      foreach ( $installed_modules['entries'] as $module ) {
        $installed[] = $module['code'];
      }

      $result = array('entries' => array());

      $DLsm = new DirectoryListing(KUUZU::BASE_DIRECTORY . 'Core/Site/Admin/Module/Service');
      $DLsm->setIncludeDirectories(false);

      foreach ( $DLsm->getFiles() as $file ) {
        $module = substr($file['name'], 0, strrpos($file['name'], '.'));

        if ( !in_array($module, $installed) ) {
          $class = 'Kuuzu\\KU\\Core\\Site\\Admin\\Module\\Service\\' . $module;

          $KUUZU_SM = new $class();

          $result['entries'][] = array('code' => $KUUZU_SM->getCode(),
                                       'title' => $KUUZU_SM->getTitle());
        }
      }

      $result['total'] = count($result['entries']);

      return $result;
    }
  }
?>
