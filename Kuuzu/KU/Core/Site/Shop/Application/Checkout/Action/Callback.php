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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Checkout\Action;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\HTML;

  class Callback {
    public static function execute(ApplicationAbstract $application) {
      if ( isset($_GET['module']) && !empty($_GET['module']) ) {
        $module = HTML::sanitize($_GET['module']);

        if ( class_exists('Kuuzu\\KU\\Core\\Site\\Shop\\Module\\Payment\\' . $module) ) {
          $module = 'Kuuzu\\KU\\Core\\Site\\Shop\\Module\\Payment\\' . $module;
          $module = new $module();
          $module->callback();
        }
      }

      exit;
    }
  }
?>
