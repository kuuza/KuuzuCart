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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Services\Action\Install;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Admin\Application\Services\Services;

/**
 * @since v3.0.2
 */

  class Process {
    public static function execute(ApplicationAbstract $application) {
      $data = HTML::sanitize(basename($_GET['code']));

      if ( Services::install($data) ) {
        $class = 'Kuuzu\\KU\\Core\\Site\\Admin\\Module\\Service\\' . $data;
        $KUUZU_SM = new $class();

        if ( $KUUZU_SM->hasKeys() ) {
          KUUZU::redirect(KUUZU::getLink(null, null, 'Save&code=' . $data));
        } else {
          Registry::get('MessageStack')->add(null, KUUZU::getDef('ms_success_action_performed'), 'success');

          KUUZU::redirect(KUUZU::getLink());
        }
      } else {
        Registry::get('MessageStack')->add(null, KUUZU::getDef('ms_error_action_not_performed'), 'error');

        KUUZU::redirect(KUUZU::getLink());
      }
    }
  }
?>
