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

  namespace Kuuzu\KU\Core\Site\Admin\Application\CoreUpdate\Action\Apply;

  use Kuuzu\KU\Core\Access;
  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Site\Admin\Application\CoreUpdate\CoreUpdate;;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;

  class Process {
    public static function execute(ApplicationAbstract $application) {
      if ( !CoreUpdate::localPackageExists() || (CoreUpdate::getPackageInfo('version_from') != KUUZU::getVersion()) ) {
        Registry::get('MessageStack')->add(null, KUUZU::getDef('ms_error_wrong_version_to_update_from'), 'error');

        KUUZU::redirect(KUUZU::getLink());
      }

      if ( CoreUpdate::canApplyPackage() ) {
        if ( CoreUpdate::applyPackage() ) {
          CoreUpdate::deletePackage();

// Refresh access list for new/deleted Applications
          $_SESSION[KUUZU::getSite()]['access'] = Access::getUserLevels($_SESSION[KUUZU::getSite()]['id']);

          Registry::get('MessageStack')->add(null, KUUZU::getDef('ms_success_action_performed'), 'success');
        } else {
          Registry::get('MessageStack')->add(null, KUUZU::getDef('ms_error_action_not_performed'), 'error');
        }
      } else {
        Registry::get('MessageStack')->add(null, KUUZU::getDef('ms_error_check_target_permissions'), 'error');

        KUUZU::redirect(KUUZU::getLink(null, null, 'Apply&v=' . $_GET['v']));
      }

      KUUZU::redirect(KUUZU::getLink());
    }
  }
?>
