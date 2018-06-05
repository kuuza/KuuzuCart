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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Account\Action\LogIn;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Shop\Account;
  use Kuuzu\KU\Core\KUUZU;

  class Process {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_NavigationHistory = Registry::get('NavigationHistory');
      $KUUZU_MessageStack = Registry::get('MessageStack');

      if ( !empty($_POST['email_address']) && !empty($_POST['password']) && Account::logIn($_POST['email_address'], $_POST['password']) ) {
        $KUUZU_NavigationHistory->removeCurrentPage();

        if ( $KUUZU_NavigationHistory->hasSnapshot() ) {
          $KUUZU_NavigationHistory->redirectToSnapshot();
        } else {
          KUUZU::redirect(KUUZU::getLink(null, KUUZU::getDefaultSiteApplication(), null, 'AUTO'));
        }
      }

      $KUUZU_MessageStack->add('LogIn', KUUZU::getDef('error_login_no_match'));
    }
  }
?>
