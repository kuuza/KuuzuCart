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

  class AddressBook {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_Customer = Registry::get('Customer');
      $KUUZU_NavigationHistory = Registry::get('NavigationHistory');
      $KUUZU_Service = Registry::get('Service');
      $KUUZU_Breadcrumb = Registry::get('Breadcrumb');
      $KUUZU_Template = Registry::get('Template');

      if ( $KUUZU_Customer->isLoggedOn() === false ) {
        $KUUZU_NavigationHistory->setSnapshot();

        KUUZU::redirect(KUUZU::getLink(null, null, 'LogIn', 'SSL'));
      }

      $application->setPageTitle(KUUZU::getDef('address_book_heading'));
      $application->setPageContent('address_book.php');

      if ( $KUUZU_Service->isStarted('Breadcrumb') ) {
        $KUUZU_Breadcrumb->add(KUUZU::getDef('breadcrumb_address_book'), KUUZU::getLink(null, null, 'AddressBook', 'SSL'));
      }

      if ( $KUUZU_Customer->hasDefaultAddress() === false ) {
        $application->setPageTitle(KUUZU::getDef('address_book_add_entry_heading'));
        $application->setPageContent('address_book_process.php');

        $KUUZU_Template->addJavascriptPhpFilename(KUUZU::BASE_DIRECTORY . 'Core/Site/Shop/assets/form_check.js.php');
      }
    }
  }
?>
