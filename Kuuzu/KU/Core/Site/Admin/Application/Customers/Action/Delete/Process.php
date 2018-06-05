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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Customers\Action\Delete;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Site\Admin\Application\Customers\Customers;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;

/**
 * @since v3.0.2
 */

  class Process {
    public static function execute(ApplicationAbstract $application) {
      if ( Customers::delete($_GET['id']) ) {
        Registry::get('MessageStack')->add(null, KUUZU::getDef('ms_success_action_performed'), 'success');
      } else {
        Registry::get('MessageStack')->add(null, KUUZU::getDef('ms_error_action_not_performed'), 'error');
      }

      KUUZU::redirect(KUUZU::getLink());
    }
  }
?>
