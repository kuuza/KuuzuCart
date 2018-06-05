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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Administrators\Action\BatchSave;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Site\Admin\Application\Administrators\Administrators;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Access;

  class Process {
    public static function execute(ApplicationAbstract $application) {
      $error = false;

      foreach ( $_POST['batch'] as $id ) {
        if ( !Administrators::setAccessLevels($id, $_POST['modules'], $_POST['mode']) ) {
          $error = true;
          break;
        }
      }

      if ( $error === false ) {
        Registry::get('MessageStack')->add(null, KUUZU::getDef('ms_success_action_performed'), 'success');

        if ( in_array($_SESSION[KUUZU::getSite()]['id'], $_POST['batch']) ) {
          $_SESSION[KUUZU::getSite()]['access'] = Access::getUserLevels($_SESSION[KUUZU::getSite()]['id']);
        }
      } else {
        Registry::get('MessageStack')->add(null, KUUZU::getDef('ms_error_action_not_performed'), 'error');
      }

      KUUZU::redirect(KUUZU::getLink());
    }
  }
?>
