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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Info\Action\Contact;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\Mail;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

  class Process {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_MessageStack = Registry::get('MessageStack');

      $name = HTML::sanitize($_POST['name']);
      $email_address = HTML::sanitize($_POST['email']);
      $enquiry = HTML::sanitize($_POST['enquiry']);

      if ( filter_var($email_address, FILTER_VALIDATE_EMAIL) ) {
        $email = new Mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, $name, $email_address, KUUZU::getDef('contact_email_subject'));
        $email->setBodyPlain($enquiry);
        $email->send();

        KUUZU::redirect(KUUZU::getLink(null, null, 'Contact&Success'));
      } else {
        $KUUZU_MessageStack->add('Contact', KUUZU::getDef('field_customer_email_address_check_error'));
      }
    }
  }
?>
