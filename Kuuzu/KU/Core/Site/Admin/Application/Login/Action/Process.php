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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Login\Action;

  use Kuuzu\KU\Core\Access;
  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Admin\Application\Login\Login;

  class Process {
    public static function execute(ApplicationAbstract $application) {
      $data = array('username' => $_POST['user_name'],
                    'password' => $_POST['user_password']);

      if ( Login::isValidCredentials($data) ) {
        Registry::get('Session')->recreate();

        $admin = Login::getAdmin($data['username']);

        $_SESSION[KUUZU::getSite()]['id'] = (int)$admin['id'];
        $_SESSION[KUUZU::getSite()]['username'] = $admin['user_name'];
        $_SESSION[KUUZU::getSite()]['access'] = Access::getUserLevels($admin['id']);

        $to_application = KUUZU::getDefaultSiteApplication();

        if ( isset($_SESSION[KUUZU::getSite()]['redirect_origin']) ) {
          $to_application = $_SESSION[KUUZU::getSite()]['redirect_origin'];

          unset($_SESSION[KUUZU::getSite()]['redirect_origin']);
        }

        KUUZU::redirect(KUUZU::getLink(null, $to_application));
      } else {
        Registry::get('MessageStack')->add('header', KUUZU::getDef('ms_error_login_invalid'), 'error');

        if ( !empty($_POST['user_name']) && !empty($_POST['user_password']) ) {
          Registry::get('Template')->setValue('show_password', true);
        }
      }
    }
  }
?>
