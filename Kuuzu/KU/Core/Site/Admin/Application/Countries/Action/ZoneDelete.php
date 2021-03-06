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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Countries\Action;

  use Kuuzu\KU\Core\ApplicationAbstract;

  class ZoneDelete {
    public static function execute(ApplicationAbstract $application) {
      $application->setPageContent('zones_delete.php');
    }
  }
?>
