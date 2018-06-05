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

  class Create {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_Service = Registry::get('Service');
      $KUUZU_Breadcrumb = Registry::get('Breadcrumb');
      $KUUZU_Template = Registry::get('Template');
      $KUUZU_MessageStack = Registry::get('MessageStack');

      if ( $KUUZU_Service->isStarted('Breadcrumb') ) {
        $KUUZU_Breadcrumb->add(KUUZU::getDef('breadcrumb_address_book_add_entry'), KUUZU::getLink(null, null, 'AddressBook&Create', 'SSL'));
      }

      $application->setPageTitle(KUUZU::getDef('address_book_add_entry_heading'));
      $application->setPageContent('address_book_process.php');

      $KUUZU_Template->addJavascriptPhpFilename(KUUZU::BASE_DIRECTORY . 'Core/Site/Shop/assets/form_check.js.php');

      if ( AddressBook::numberOfEntries() >= MAX_ADDRESS_BOOK_ENTRIES ) {
        $KUUZU_MessageStack->add('AddressBook', KUUZU::getDef('error_address_book_full'));

        $application->setPageTitle(KUUZU::getDef('address_book_heading'));
        $application->setPageContent('address_book.php');

        return true;
      }
    }
  }
?>
