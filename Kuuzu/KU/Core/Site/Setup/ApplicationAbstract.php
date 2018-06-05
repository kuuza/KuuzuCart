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

  namespace Kuuzu\KU\Core\Site\Setup;

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;

  abstract class ApplicationAbstract extends \Kuuzu\KU\Core\ApplicationAbstract {
    public function __construct() {
      $this->initialize();

      if ( isset($_GET['action']) && !empty($_GET['action']) ) {
        $action = HTML::sanitize(basename($_GET['action']));

        if ( class_exists('Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Application\\' . KUUZU::getSiteApplication() . '\\Action\\' . $action) ) {
          call_user_func(array('Kuuzu\\KU\\Core\\Site\\' . KUUZU::getSite() . '\\Application\\' . KUUZU::getSiteApplication() . '\\Action\\' . $action, 'execute'), $this);
        }
      }
    }
  }
?>
