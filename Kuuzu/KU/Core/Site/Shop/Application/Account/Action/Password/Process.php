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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Account\Action\Password;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Site\Shop\Account;

  class Process {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_MessageStack = Registry::get('MessageStack');

      if ( !isset($_POST['password_current']) || (strlen(trim($_POST['password_current'])) < ACCOUNT_PASSWORD) ) {
        $KUUZU_MessageStack->add('Password', sprintf(KUUZU::getDef('field_customer_password_current_error'), ACCOUNT_PASSWORD));
      } elseif ( !isset($_POST['password_new']) || (strlen(trim($_POST['password_new'])) < ACCOUNT_PASSWORD) ) {
        $KUUZU_MessageStack->add('Password', sprintf(KUUZU::getDef('field_customer_password_new_error'), ACCOUNT_PASSWORD));
      } elseif ( !isset($_POST['password_confirmation']) || (trim($_POST['password_new']) != trim($_POST['password_confirmation'])) ) {
        $KUUZU_MessageStack->add('Password', KUUZU::getDef('field_customer_password_new_mismatch_with_confirmation_error'));
      }

      if ( $KUUZU_MessageStack->size('Password') === 0 ) {
        if ( Account::checkPassword(trim($_POST['password_current'])) ) {
          if ( Account::savePassword(trim($_POST['password_new'])) ) {
            $KUUZU_MessageStack->add('Account', KUUZU::getDef('success_password_updated'), 'success');

            KUUZU::redirect(KUUZU::getLink(null, null, null, 'SSL'));
          } else {
            $KUUZU_MessageStack->add('Password', sprintf(KUUZU::getDef('field_customer_password_new_error'), ACCOUNT_PASSWORD));
          }
        } else {
          $KUUZU_MessageStack->add('Password', KUUZU::getDef('error_current_password_not_matching'));
        }
      }
    }
  }
?>
