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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Account\Action\AddressBook\Delete;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Site\Shop\AddressBook;

  class Process {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_MessageStack = Registry::get('MessageStack');

      if ( AddressBook::deleteEntry($_GET['Delete']) ) {
        $KUUZU_MessageStack->add('AddressBook', KUUZU::getDef('success_address_book_entry_deleted'), 'success');
      }

      KUUZU::redirect(KUUZU::getLink(null, null, 'AddressBook', 'SSL'));
    }
  }
?>
