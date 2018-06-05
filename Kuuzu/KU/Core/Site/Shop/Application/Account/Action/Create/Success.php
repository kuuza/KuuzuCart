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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Account\Action\Create;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\KUUZU;

  class Success {
    public static function execute(ApplicationAbstract $application) {
      $application->setPageTitle(KUUZU::getDef('create_account_success_heading'));
      $application->setPageContent('create_success.php');
    }
  }
?>
