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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Products\Action\TellAFriend;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\Mail;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Shop\Product;

  class Process {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_Customer = Registry::get('Customer');
      $KUUZU_NavigationHistory = Registry::get('NavigationHistory');
      $KUUZU_MessageStack = Registry::get('MessageStack');
      $KUUZU_Service = Registry::get('Service');
      $KUUZU_Breadcrumb = Registry::get('Breadcrumb');

      if ( (ALLOW_GUEST_TO_TELL_A_FRIEND == '-1') && ($KUUZU_Customer->isLoggedOn() === false) ) {
        $KUUZU_NavigationHistory->setSnapshot();

        KUUZU::redirect(KUUZU::getLink(null, 'Account', 'LogIn', 'SSL'));
      }

      $requested_product = null;
      $product_check = false;

      if ( count($_GET) > 3 ) {
        $requested_product = basename(key(array_slice($_GET, 3, 1, true)));

        if ( $requested_product == 'Write' ) {
          unset($requested_product);

          if ( count($_GET) > 4 ) {
            $requested_product = basename(key(array_slice($_GET, 4, 1, true)));
          }
        }
      }

      if ( isset($requested_product) ) {
        if ( Product::checkEntry($requested_product) ) {
          $product_check = true;
        }
      }

      if ( $product_check === false ) {
        $application->setPageContent('not_found.php');

        return false;
      }

      Registry::set('Product', new Product($requested_product));
      $KUUZU_Product = Registry::get('Product');

      if ( empty($_POST['from_name']) ) {
        $KUUZU_MessageStack->add('TellAFriend', KUUZU::getDef('error_tell_a_friend_customers_name_empty'));
      }

      if ( !filter_var($_POST['from_email_address']. FILTER_VALIDATE_EMAIL) ) {
        $KUUZU_MessageStack->add('TellAFriend', KUUZU::getDef('error_tell_a_friend_invalid_customers_email_address'));
      }

      if ( empty($_POST['to_name']) ) {
        $KUUZU_MessageStack->add('TellAFriend', KUUZU::getDef('error_tell_a_friend_friends_name_empty'));
      }

      if ( !filter_var($_POST['to_email_address'], FILTER_VALIDATE_EMAIL) ) {
        $KUUZU_MessageStack->add('TellAFriend', KUUZU::getDef('error_tell_a_friend_invalid_friends_email_address'));
      }

      if ( $KUUZU_MessageStack->size('TellAFriend') < 1 ) {
        $email_subject = sprintf(KUUZU::getDef('email_tell_a_friend_subject'), HTML::sanitize($_POST['from_name']), STORE_NAME);
        $email_body = sprintf(KUUZU::getDef('email_tell_a_friend_intro'), HTML::sanitize($_POST['to_name']), HTML::sanitize($_POST['from_name']), $KUUZU_Product->getTitle(), STORE_NAME) . "\n\n";

        if ( !empty($_POST['message']) ) {
          $email_body .= HTML::sanitize($_POST['message']) . "\n\n";
        }

        $email_body .= sprintf(KUUZU::getDef('email_tell_a_friend_link'), KUUZU::getLink(null, null, $KUUZU_Product->getKeyword(), 'NONSSL', false)) . "\n\n" .
                       sprintf(KUUZU::getDef('email_tell_a_friend_signature'), STORE_NAME . "\n" . HTTP_SERVER . DIR_WS_CATALOG . "\n");

        $pEmail = new Mail(HTML::sanitize($_POST['to_name']), HTML::sanitize($_POST['to_email_address']), HTML::sanitize($_POST['from_name']), HTML::sanitize($_POST['from_email_address']), $email_subject);
        $pEmail->setBodyPlain($email_body);
        $pEmail->send();

        $KUUZU_MessageStack->add('header', sprintf(KUUZU::getDef('success_tell_a_friend_email_sent'), $KUUZU_Product->getTitle(), HTML::outputProtected($_POST['to_name'])), 'success');

        KUUZU::redirect(KUUZU::getLink(null, null, $KUUZU_Product->getKeyword()));
      }

      $application->setPageTitle($KUUZU_Product->getTitle());
      $application->setPageContent('tell_a_friend.php');
    }
  }
?>
