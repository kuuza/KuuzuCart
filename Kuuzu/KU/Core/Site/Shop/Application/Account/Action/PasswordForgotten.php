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

  class PasswordForgotten {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_Template = Registry::get('Template');
      $KUUZU_Service = Registry::get('Service');
      $KUUZU_Breadcrumb = Registry::get('Breadcrumb');

      $application->setPageTitle(KUUZU::getDef('password_forgotten_heading'));
      $application->setPageContent('password_forgotten.php');

      $KUUZU_Template->addJavascriptPhpFilename(KUUZU::BASE_DIRECTORY . 'Core/Site/Shop/assets/form_check.js.php');

      if ( $KUUZU_Service->isStarted('Breadcrumb') ) {
        $KUUZU_Breadcrumb->add(KUUZU::getDef('breadcrumb_password_forgotten'), KUUZU::getLink(null, null, 'PasswordForgotten', 'SSL'));
      }
    }
  }
?>
