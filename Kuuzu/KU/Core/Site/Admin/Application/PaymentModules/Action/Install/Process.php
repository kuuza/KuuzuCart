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

  namespace Kuuzu\KU\Core\Site\Admin\Application\PaymentModules\Action\Install;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Admin\Application\PaymentModules\PaymentModules;

  class Process {
    public static function execute(ApplicationAbstract $application) {
      $data = HTML::sanitize(basename($_GET['code']));

      if ( PaymentModules::install($data) ) {
        KUUZU::redirect(KUUZU::getLink(null, null, 'Save&code=' . $_GET['code']));
      } else {
        Registry::get('MessageStack')->add(null, KUUZU::getDef('ms_error_action_not_performed'), 'error');

        KUUZU::redirect(KUUZU::getLink());
      }
    }
  }
?>
