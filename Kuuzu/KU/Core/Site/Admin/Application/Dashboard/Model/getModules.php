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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Dashboard\Model;

  use Kuuzu\KU\Core\DirectoryListing;
  use Kuuzu\KU\Core\KUUZU;

  class getModules {
    public static function execute() {
      $KUUZU_DirectoryListing = new DirectoryListing(KUUZU::BASE_DIRECTORY . 'Core/Site/Admin/Module/Dashboard');
      $KUUZU_DirectoryListing->setIncludeDirectories(false);

      $result = array();

      foreach ( $KUUZU_DirectoryListing->getFiles() as $file ) {
        $module = substr($file['name'], 0, strrpos($file['name'], '.'));
        $module_class = 'Kuuzu\\KU\\Core\\Site\\Admin\\Module\\Dashboard\\' . $module;

        $KUUZU_Admin_DB_Module = new $module_class();

        if ( $KUUZU_Admin_DB_Module->hasData() ) {
          $result[] = array('module' => $module,
                            'title' => $KUUZU_Admin_DB_Module->getTitle(),
                            'link' => $KUUZU_Admin_DB_Module->hasTitleLink() ? $KUUZU_Admin_DB_Module->getTitleLink() : null,
                            'data' => $KUUZU_Admin_DB_Module->getData());
        }
      }

      return $result;
    }
  }
?>
