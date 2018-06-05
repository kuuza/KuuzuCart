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

  use \GlobIterator;

  use Kuuzu\KU\Core\KUUZU;

/**
 * @since v3.0.2
 */

  class getLogs {
    public static function execute() {
      $result = array();

      $it = new GlobIterator(KUUZU::BASE_DIRECTORY . 'Work/Logs/update-*.txt');

      foreach ( $it as $f ) {
        $result[] = $f->getFilename();
      }

      return $result;
    }
  }
?>
