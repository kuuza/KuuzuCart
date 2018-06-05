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

  namespace Kuuzu\KU\Core\Site\Admin\Application\ProductAttributes\Model;

  use Kuuzu\KU\Core\DirectoryListing;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Admin\Application\ProductAttributes\ProductAttributes;

/**
 * @since v3.0.3
 */

  class getUninstalled {
    public static function execute() {
      $installed_modules = ProductAttributes::getInstalled();
      $installed = array();

      foreach ( $installed_modules['entries'] as $module ) {
        $installed[] = $module['code'];
      }

      $result = array('entries' => array());

      $DLpa = new DirectoryListing(KUUZU::BASE_DIRECTORY . 'Core/Site/Admin/Module/ProductAttribute');
      $DLpa->setIncludeDirectories(false);

      foreach ( $DLpa->getFiles() as $file ) {
        $module = substr($file['name'], 0, strrpos($file['name'], '.'));

        if ( !in_array($module, $installed) ) {
          $class = 'Kuuzu\\KU\\Core\\Site\\Admin\\Module\\ProductAttribute\\' . $module;

          $KUUZU_PA = new $class();

          $result['entries'][] = array('code' => $KUUZU_PA->getCode(),
                                       'title' => $KUUZU_PA->getTitle());
        }
      }

      $result['total'] = count($result['entries']);

      return $result;
    }
  }
?>
