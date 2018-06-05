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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Account\Action\PasswordForgotten;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Hash;
  use Kuuzu\KU\Core\Mail;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Shop\Account;

  class Process {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_MessageStack = Registry::get('MessageStack');

      $Qcheck = $KUUZU_PDO->prepare('select customers_id, customers_firstname, customers_lastname, customers_gender, customers_email_address, customers_password from :table_customers where customers_email_address = :customers_email_address limit 1');
      $Qcheck->bindValue(':customers_email_address', $_POST['email_address']);
      $Qcheck->execute();

      if ( $Qcheck->fetch() !== false ) {
        $password = Hash::getRandomString(ACCOUNT_PASSWORD);

        if ( Account::savePassword($password, $Qcheck->valueInt('customers_id')) ) {
          if ( ACCOUNT_GENDER > -1 ) {
             if ( $Qcheck->value('customers_gender') == 'm' ) {
               $email_text = sprintf(KUUZU::getDef('email_addressing_gender_male'), $Qcheck->valueProtected('customers_lastname')) . "\n\n";
             } else {
               $email_text = sprintf(KUUZU::getDef('email_addressing_gender_female'), $Qcheck->valueProtected('customers_lastname')) . "\n\n";
             }
          } else {
            $email_text = sprintf(KUUZU::getDef('email_addressing_gender_unknown'), $Qcheck->valueProtected('customers_firstname') . ' ' . $Qcheck->valueProtected('customers_lastname')) . "\n\n";
          }

          $email_text .= sprintf(KUUZU::getDef('email_password_reminder_body'), KUUZU::getIPAddress(), STORE_NAME, $password, STORE_OWNER_EMAIL_ADDRESS);

          $pEmail = new Mail($Qcheck->valueProtected('customers_firstname') . ' ' . $Qcheck->valueProtected('customers_lastname'), $Qcheck->valueProtected('customers_email_address'), STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, sprintf(KUUZU::getDef('email_password_reminder_subject'), STORE_NAME));
          $pEmail->setBodyPlain($email_text);
          $pEmail->send();

          $KUUZU_MessageStack->add('LogIn', KUUZU::getDef('success_password_forgotten_sent'), 'success');
        }

        KUUZU::redirect(KUUZU::getLink(null, null, 'LogIn', 'SSL'));
      } else {
        $KUUZU_MessageStack->add('PasswordForgotten', KUUZU::getDef('error_password_forgotten_no_email_address_found'));
      }
    }
  }
?>
