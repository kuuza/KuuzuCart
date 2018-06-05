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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Administrators\Model;

  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\DirectoryListing;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Access;

  class getAccessModules {
    public static function execute() {
      $KUUZU_Language = Registry::get('Language');

      $module_files = array();

      $DLapps = new DirectoryListing(KUUZU::BASE_DIRECTORY . 'Core/Site/' . KUUZU::getSite() . '/Application');
      $DLapps->setIncludeFiles(false);

      foreach ( $DLapps->getFiles() as $file ) {
        if ( !in_array($file['name'], call_user_func(array('Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Controller', 'getGuestApplications'))) && file_exists($DLapps->getDirectory() . '/' . $file['name'] . '/Controller.php') ) {
          $module_files[] = $file['name'];
        }
      }

      $DLcapps = new DirectoryListing(KUUZU::BASE_DIRECTORY . 'Custom/Site/' . KUUZU::getSite() . '/Application');
      $DLcapps->setIncludeFiles(false);

      foreach ( $DLcapps->getFiles() as $file ) {
        if ( !in_array($file['name'], $module_files) && !in_array($file['name'], call_user_func(array('Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Controller', 'getGuestApplications'))) && file_exists($DLcapps->getDirectory() . '/' . $file['name'] . '/Controller.php') ) {
          $module_files[] = $file['name'];
        }
      }

      $modules = array();

      foreach ( $module_files as $module ) {
        $application_class = 'Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Application\\' . $module . '\\Controller';

        if ( class_exists($application_class) ) {
          if ( $module == KUUZU::getSiteApplication() ) {
            $KUUZU_Application = Registry::get('Application');
          } else {
            Registry::get('Language')->loadIniFile($module . '.php');
            $KUUZU_Application = new $application_class(false);
          }

          $modules[Access::getGroupTitle($KUUZU_Application->getGroup())][] = array('id' => $module,
                                                                                    'text' => $KUUZU_Application->getTitle(),
                                                                                    'icon' => $KUUZU_Application->getIcon());
        }
      }

      ksort($modules);

      return $modules;
    }
  }
?>
