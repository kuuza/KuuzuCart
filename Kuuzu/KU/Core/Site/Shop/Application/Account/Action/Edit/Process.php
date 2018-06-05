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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Account\Action\Edit;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Site\Shop\Account;

  class Process {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_MessageStack = Registry::get('MessageStack');
      $KUUZU_Customer = Registry::get('Customer');

      $data = array();

      if ( ACCOUNT_GENDER >= 0 ) {
        if ( isset($_POST['gender']) && (($_POST['gender'] == 'm') || ($_POST['gender'] == 'f')) ) {
          $data['gender'] = $_POST['gender'];
        } else {
          $KUUZU_MessageStack->add('Edit', KUUZU::getDef('field_customer_gender_error'));
        }
      }

      if ( isset($_POST['firstname']) && (strlen(trim($_POST['firstname'])) >= ACCOUNT_FIRST_NAME) ) {
        $data['firstname'] = $_POST['firstname'];
      } else {
        $KUUZU_MessageStack->add('Edit', sprintf(KUUZU::getDef('field_customer_first_name_error'), ACCOUNT_FIRST_NAME));
      }

      if ( isset($_POST['lastname']) && (strlen(trim($_POST['lastname'])) >= ACCOUNT_LAST_NAME) ) {
        $data['lastname'] = $_POST['lastname'];
      } else {
        $KUUZU_MessageStack->add('Edit', sprintf(KUUZU::getDef('field_customer_last_name_error'), ACCOUNT_LAST_NAME));
      }

      if ( ACCOUNT_DATE_OF_BIRTH == '1' ) {
        if ( isset($_POST['dob_days']) && isset($_POST['dob_months']) && isset($_POST['dob_years']) && checkdate($_POST['dob_months'], $_POST['dob_days'], $_POST['dob_years']) ) {
          $data['dob'] = mktime(0, 0, 0, $_POST['dob_months'], $_POST['dob_days'], $_POST['dob_years']);
        } else {
          $KUUZU_MessageStack->add('Edit', KUUZU::getDef('field_customer_date_of_birth_error'));
        }
      }

      if ( isset($_POST['email_address']) && (strlen(trim($_POST['email_address'])) >= ACCOUNT_EMAIL_ADDRESS) ) {
        if ( filter_var($_POST['email_address'], FILTER_VALIDATE_EMAIL) ) {
          if ( Account::checkDuplicateEntry($_POST['email_address']) === false ) {
            $data['email_address'] = $_POST['email_address'];
          } else {
            $KUUZU_MessageStack->add('Edit', KUUZU::getDef('field_customer_email_address_exists_error'));
          }
        } else {
          $KUUZU_MessageStack->add('Edit', KUUZU::getDef('field_customer_email_address_check_error'));
        }
      } else {
        $KUUZU_MessageStack->add('Edit', sprintf(KUUZU::getDef('field_customer_email_address_error'), ACCOUNT_EMAIL_ADDRESS));
      }

      if ( $KUUZU_MessageStack->size('Edit') === 0 ) {
        if ( Account::saveEntry($data) ) {
// reset the session variables
          if ( ACCOUNT_GENDER > -1 ) {
            $KUUZU_Customer->setGender($data['gender']);
          }

          $KUUZU_Customer->setFirstName(trim($data['firstname']));
          $KUUZU_Customer->setLastName(trim($data['lastname']));
          $KUUZU_Customer->setEmailAddress($data['email_address']);

          $KUUZU_MessageStack->add('Account', KUUZU::getDef('success_account_updated'), 'success');
        }

        KUUZU::redirect(KUUZU::getLink(null, null, null, 'SSL'));
      }
    }
  }
?>
