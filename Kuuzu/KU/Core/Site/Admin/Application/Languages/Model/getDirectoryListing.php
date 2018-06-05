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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Languages\Model;

  use Kuuzu\KU\Core\DirectoryListing;
  use Kuuzu\KU\Core\KUUZU;

  class getDirectoryListing {
    public static function execute() {
      $result = array();

      $KUUZU_DirectoryListing = new DirectoryListing(KUUZU::BASE_DIRECTORY . 'Core/Site/Shop/Languages');
      $KUUZU_DirectoryListing->setIncludeDirectories(false);
      $KUUZU_DirectoryListing->setCheckExtension('xml');

      foreach ( $KUUZU_DirectoryListing->getFiles() as $file ) {
        $result[] = substr($file['name'], 0, strrpos($file['name'], '.'));
      }

      return $result;
    }
  }
?>
