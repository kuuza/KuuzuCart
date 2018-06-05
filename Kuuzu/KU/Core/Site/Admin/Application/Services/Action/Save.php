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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Services\Action;

  use Kuuzu\KU\Core\ApplicationAbstract;

/**
 * @since v3.0.2
 */

  class Save {
    public static function execute(ApplicationAbstract $application) {
      $application->setPageContent('edit.php');
    }
  }
?>
