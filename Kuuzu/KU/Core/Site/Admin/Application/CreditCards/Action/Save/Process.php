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

  namespace Kuuzu\KU\Core\Site\Admin\Application\CreditCards\Action\Save;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Site\Admin\Application\CreditCards\CreditCards;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;

  class Process {
    public static function execute(ApplicationAbstract $application) {
      $data = array('name' => $_POST['credit_card_name'],
                    'pattern' => $_POST['pattern'],
                    'status' => (isset($_POST['credit_card_status']) && ($_POST['credit_card_status'] == '1') ? 1 : 0),
                    'sort_order' => $_POST['sort_order']);

      if ( CreditCards::save((isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : null), $data) ) {
        Registry::get('MessageStack')->add(null, KUUZU::getDef('ms_success_action_performed'), 'success');
      } else {
        Registry::get('MessageStack')->add(null, KUUZU::getDef('ms_error_action_not_performed'), 'error');
      }

      KUUZU::redirect(KUUZU::getLink());
    }
  }
?>
