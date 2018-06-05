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

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;

  class Logoff {
    public static function execute(ApplicationAbstract $application) {
      unset($_SESSION[KUUZU::getSite()]);

      Registry::get('MessageStack')->add('header', KUUZU::getDef('ms_success_logged_out'), 'success');

      KUUZU::redirect(KUUZU::getLink(null, KUUZU::getDefaultSiteApplication()));
    }
  }
?>
