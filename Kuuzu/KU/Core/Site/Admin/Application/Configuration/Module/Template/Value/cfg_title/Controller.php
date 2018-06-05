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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Configuration\Module\Template\Value\cfg_title;

  use Kuuzu\KU\Core\ObjectInfo;
  use Kuuzu\KU\Core\Site\Admin\Application\Configuration\Configuration;

  class Controller extends \Kuuzu\KU\Core\Template\ValueAbstract {
    static public function execute() {
      $KUUZU_ObjectInfo = new ObjectInfo(Configuration::getEntry($_GET['pID']));

      return $KUUZU_ObjectInfo->getProtected('configuration_title');
    }
  }
?>
