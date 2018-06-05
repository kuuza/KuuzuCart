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

  namespace Kuuzu\KU\Core\Site\Admin\Application\TaxClasses\Action\EntrySave;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Site\Admin\Application\TaxClasses\TaxClasses;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;

  class Process {
    public static function execute(ApplicationAbstract $application) {
      $data = array('zone_id' => $_POST['tax_zone_id'],
                    'rate' => $_POST['tax_rate'],
                    'description' => $_POST['tax_description'],
                    'priority' => $_POST['tax_priority'],
                    'rate' => $_POST['tax_rate'],
                    'tax_class_id' => $_GET['id']);

      if ( TaxClasses::saveEntry((isset($_GET['rID']) && is_numeric($_GET['rID']) ? $_GET['rID'] : null), $data) ) {
        Registry::get('MessageStack')->add(null, KUUZU::getDef('ms_success_action_performed'), 'success');
      } else {
        Registry::get('MessageStack')->add(null, KUUZU::getDef('ms_error_action_not_performed'), 'error');
      }

      KUUZU::redirect(KUUZU::getLink(null, null, 'id=' . $_GET['id']));
    }
  }
?>
