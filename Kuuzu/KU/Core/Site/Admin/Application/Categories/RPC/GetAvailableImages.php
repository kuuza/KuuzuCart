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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Categories\RPC;

  use Kuuzu\KU\Core\DirectoryListing;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Site\RPC\Controller as RPC;

/**
 * @since v3.0.2
 */

  class GetAvailableImages {
    public static function execute() {
      $result = array('images' => array());

      $KUUZU_DL = new DirectoryListing(KUUZU::getConfig('dir_fs_public', 'KUUZU') . 'upload');
      $KUUZU_DL->setIncludeDirectories(false);
      $KUUZU_DL->setCheckExtension('gif');
      $KUUZU_DL->setCheckExtension('jpg');
      $KUUZU_DL->setCheckExtension('png');

      foreach ( $KUUZU_DL->getFiles() as $f ) {
        $result['images'][] = $f['name'];
      }

      $result['rpcStatus'] = RPC::STATUS_SUCCESS;

      echo json_encode($result);
    }
  }
?>
