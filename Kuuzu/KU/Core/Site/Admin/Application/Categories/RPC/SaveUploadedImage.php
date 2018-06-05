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

  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Upload;

/**
 * @since v3.0.2
 */

  class SaveUploadedImage {
    public static function execute() {
      $error = true;

      $image = new Upload('qqfile', KUUZU::getConfig('dir_fs_public', 'KUUZU') . 'upload', null, array('gif', 'jpg', 'png'));

      if ( $image->check() && $image->save() ) {
        $error = false;
      }

      if ( $error === false ) {
        $result = array('success' => true, 'filename' => $image->getFilename());
      } else {
        $result = array('error' => 'Error');
      }

      echo json_encode($result);
    }
  }
?>
