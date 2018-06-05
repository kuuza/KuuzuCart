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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Currencies\Action\UpdateRates;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Site\Admin\Application\Currencies\Currencies;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;

  class Process {
    public static function execute(ApplicationAbstract $application) {
      if ( isset($_POST['service']) && (($_POST['service'] == 'oanda') || ($_POST['service'] == 'xe')) ) {
        $results = Currencies::updateRates($_POST['service']);

        foreach ( $results[0] as $result ) {
          Registry::get('MessageStack')->add(null, sprintf(KUUZU::getDef('ms_error_invalid_currency'), $result['title'], $result['code']), 'error');
        }

        foreach ( $results[1] as $result ) {
          Registry::get('MessageStack')->add(null, sprintf(KUUZU::getDef('ms_success_currency_updated'), $result['title'], $result['code']), 'success');
        }
      }

      KUUZU::redirect(KUUZU::getLink());
    }
  }
?>
