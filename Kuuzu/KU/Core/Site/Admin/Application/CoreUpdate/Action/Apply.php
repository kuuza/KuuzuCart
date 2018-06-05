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

  namespace Kuuzu\KU\Core\Site\Admin\Application\CoreUpdate\Action;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Site\Admin\Application\CoreUpdate\CoreUpdate;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;

  class Apply {
    public static function execute(ApplicationAbstract $application) {
      if ( !isset($_GET['v']) || !CoreUpdate::packageExists($_GET['v']) ) {
        Registry::get('MessageStack')->add(null, KUUZU::getDef('ms_error_select_version_to_view'), 'error');

        KUUZU::redirect(KUUZU::getLink());
      }

      if ( CoreUpdate::localPackageExists() && (CoreUpdate::getPackageInfo('version_to') != $_GET['v']) ) {
        CoreUpdate::deletePackage();
      }

      if ( !CoreUpdate::localPackageExists() && !CoreUpdate::downloadPackage($_GET['v']) ) {
        Registry::get('MessageStack')->add(null, KUUZU::getDef('ms_error_local_update_package_does_not_exist'), 'error');

        KUUZU::redirect(KUUZU::getLink());
      }

      $application->setPageContent('package_contents.php');
      $application->setPageTitle(sprintf(KUUZU::getDef('action_heading_apply'), CoreUpdate::getPackageInfo('version_from'), CoreUpdate::getPackageInfo('version_to')));
    }
  }
?>
