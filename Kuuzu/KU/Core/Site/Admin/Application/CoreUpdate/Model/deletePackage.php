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

  use \Phar;
  use Kuuzu\KU\Core\KUUZU;

  class deletePackage {
    public static function execute() {
      return Phar::unlinkArchive(KUUZU::BASE_DIRECTORY . 'Work/CoreUpdate/update.phar');
    }
  }
?>
