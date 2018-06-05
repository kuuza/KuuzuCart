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

  namespace Kuuzu\KU\Core\Site\Admin\Application\CoreUpdate\Model;

  use Kuuzu\KU\Core\Site\Admin\Application\CoreUpdate\CoreUpdate;
  use Kuuzu\KU\Core\HttpRequest;
  use Kuuzu\KU\Core\KUUZU;

  class downloadPackage {
    public static function execute($version = null) {
      if ( empty($version) ) {
        $link = CoreUpdate::getAvailablePackageInfo('update_package');
      } else {
        $versions = CoreUpdate::getAvailablePackages();

        foreach ( $versions['entries'] as $v ) {
          if ( $v['version'] == $version ) {
            $link = $v['update_package'];

            break;
          }
        }
      }

      $response = HttpRequest::getResponse(array('url' => $link, 'parameters' => 'check=true'));

      return file_put_contents(KUUZU::BASE_DIRECTORY . 'Work/CoreUpdate/update.phar', $response);
    }
  }
?>
