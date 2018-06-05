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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Search\Action;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;

  class Help {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_Template = Registry::get('Template');
      $KUUZU_NavigationHistory = Registry::get('NavigationHistory');

// HPDL
      $KUUZU_Template->setHasHeader(false);
      $KUUZU_Template->setHasFooter(false);
      $KUUZU_Template->setHasBoxModules(false);
      $KUUZU_Template->setHasContentModules(false);
      $KUUZU_Template->setShowDebugMessages(false);

      $KUUZU_NavigationHistory->removeCurrentPage();

      $application->setPageTitle(KUUZU::getDef('search_heading'));
      $application->setPageContent('help.php');
    }
  }
?>
