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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Account\Action\Newsletters;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;

  class Process {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_Customer = Registry::get('Customer');
      $KUUZU_MessageStack = Registry::get('MessageStack');

      if ( isset($_POST['newsletter_general']) && is_numeric($_POST['newsletter_general']) ) {
        $newsletter_general = (int)$_POST['newsletter_general'];
      } else {
        $newsletter_general = 0;
      }

// HPDL Should be moved to the customers class!
      $Qnewsletter = $KUUZU_PDO->prepare('select customers_newsletter from :table_customers where customers_id = :customers_id');
      $Qnewsletter->bindInt(':customers_id', $KUUZU_Customer->getID());
      $Qnewsletter->execute();

      if ( $newsletter_general !== $Qnewsletter->valueInt('customers_newsletter') ) {
        $newsletter_general = (($Qnewsletter->value('customers_newsletter') == '1') ? '0' : '1');

        $Qupdate = $KUUZU_PDO->prepare('update :table_customers set customers_newsletter = :customers_newsletter where customers_id = :customers_id');
        $Qupdate->bindInt(':customers_newsletter', $newsletter_general);
        $Qupdate->bindInt(':customers_id', $KUUZU_Customer->getID());
        $Qupdate->execute();

        if ( $Qupdate->rowCount() === 1 ) {
          $KUUZU_MessageStack->add('Account', KUUZU::getDef('success_newsletter_updated'), 'success');
        }
      }

      KUUZU::redirect(KUUZU::getLink(null, null, null, 'SSL'));
    }
  }
?>
