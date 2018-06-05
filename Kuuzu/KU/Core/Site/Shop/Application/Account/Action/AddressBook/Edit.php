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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Account\Action\AddressBook;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Site\Shop\AddressBook;

  class Edit {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_MessageStack = Registry::get('MessageStack');
      $KUUZU_Service = Registry::get('Service');
      $KUUZU_Breadcrumb = Registry::get('Breadcrumb');
      $KUUZU_Template = Registry::get('Template');

      if ( AddressBook::checkEntry($_GET['Edit']) === false ) {
        $KUUZU_MessageStack->add('AddressBook', KUUZU::getDef('error_address_book_entry_non_existing'), 'error');

        KUUZU::redirect(KUUZU::getLink(null, null, 'AddressBook', 'SSL'));
      }

      if ( $KUUZU_Service->isStarted('Breadcrumb') ) {
        $KUUZU_Breadcrumb->add(KUUZU::getDef('breadcrumb_address_book_edit_entry'), KUUZU::getLink(null, null, 'AddressBook&Edit=' . $_GET['Edit'], 'SSL'));
      }

      $application->setPageTitle(KUUZU::getDef('address_book_edit_entry_heading'));
      $application->setPageContent('address_book_process.php');

      $KUUZU_Template->addJavascriptPhpFilename(KUUZU::BASE_DIRECTORY . 'Core/Site/Shop/assets/form_check.js.php');
    }
  }
?>
