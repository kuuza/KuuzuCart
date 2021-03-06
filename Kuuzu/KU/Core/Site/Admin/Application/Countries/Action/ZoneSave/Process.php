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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Countries\Action\ZoneSave;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Site\Admin\Application\Countries\Countries;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;

  class Process {
    public static function execute(ApplicationAbstract $application) {
      $data = array('name' => $_POST['zone_name'],
                    'code' => $_POST['zone_code'],
                    'country_id' => $_GET['id']);

      if ( Countries::saveZone((isset($_GET['zID']) && is_numeric($_GET['zID']) ? $_GET['zID'] : null), $data) ) {
        Registry::get('MessageStack')->add(null, KUUZU::getDef('ms_success_action_performed'), 'success');
      } else {
        Registry::get('MessageStack')->add(null, KUUZU::getDef('ms_error_action_not_performed'), 'error');
      }

      KUUZU::redirect(KUUZU::getLink(null, null, 'id=' . $_GET['id']));
    }
  }
?>
