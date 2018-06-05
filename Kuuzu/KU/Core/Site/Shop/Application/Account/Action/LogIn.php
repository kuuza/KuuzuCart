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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Account\Action;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;

  class LogIn {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_Session = Registry::get('Session');
      $KUUZU_Service = Registry::get('Service');
      $KUUZU_Breadcrumb = Registry::get('Breadcrumb');

// redirect the customer to a friendly cookies-must-be-enabled page if cookies
// are disabled (or the session has not started)
      if ( $KUUZU_Session->hasStarted() === false ) {
        KUUZU::redirect(KUUZU::getLink(null, 'Info', 'Cookies'));
      }

      $application->setPageTitle(KUUZU::getDef('sign_in_heading'));
      $application->setPageContent('login.php');

      if ( $KUUZU_Service->isStarted('Breadcrumb') ) {
        $KUUZU_Breadcrumb->add(KUUZU::getDef('breadcrumb_sign_in'), KUUZU::getLink(null, null, 'LogIn', 'SSL'));
      }
    }
  }
?>
