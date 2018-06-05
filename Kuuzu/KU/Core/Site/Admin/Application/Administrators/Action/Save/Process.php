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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Administrators\Action\Save;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Site\Admin\Application\Administrators\Administrators;
  use Kuuzu\KU\Core\Access;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;

  class Process {
    public static function execute(ApplicationAbstract $application) {
      $data = array('id' => (isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : null),
                    'username' => $_POST['user_name'],
                    'password' => $_POST['user_password'],
                    'modules' => (isset($_POST['modules']) ? $_POST['modules'] : null));

      switch ( Administrators::save($data) ) {
        case 1:
          if ( isset($_GET['id']) && is_numeric($_GET['id']) && ($_GET['id'] == $_SESSION[KUUZU::getSite()]['id']) ) {
            $_SESSION[KUUZU::getSite()]['access'] = Access::getUserLevels($_GET['id']);
          }

          Registry::get('MessageStack')->add(null, KUUZU::getDef('ms_success_action_performed'), 'success');

          KUUZU::redirect(KUUZU::getLink());

          break;

        case -1:
          Registry::get('MessageStack')->add(null, KUUZU::getDef('ms_error_action_not_performed'), 'error');

          KUUZU::redirect(KUUZU::getLink());

          break;

        case -2:
          Registry::get('MessageStack')->add(null, KUUZU::getDef('ms_error_username_already_exists'), 'error');

          break;
      }
    }
  }
?>
