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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Dashboard\Action;

  use Kuuzu\KU\Core\Access;
  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Admin\Application\Dashboard\Dashboard;

  class RemoveShortcut {
    public static function execute(ApplicationAbstract $application) {
      if ( !empty($_GET['shortcut']) ) {
        $application = HTML::sanitize($_GET['shortcut']);

        if ( KUUZU::siteApplicationExists($application) ) {
          if ( Dashboard::deleteShortcut($_SESSION[KUUZU::getSite()]['id'], $application) ) {
            $_SESSION[KUUZU::getSite()]['access'] = Access::getUserLevels($_SESSION[KUUZU::getSite()]['id']);

            Registry::get('MessageStack')->add('header', KUUZU::getDef('ms_success_shortcut_removed'), 'success');

            KUUZU::redirect(KUUZU::getLink(null, $application));
          }
        }
      }

      KUUZU::redirect(KUUZU::getLink());
    }
  }
?>
