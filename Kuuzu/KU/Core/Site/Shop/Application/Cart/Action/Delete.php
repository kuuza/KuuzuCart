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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Cart\Action;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;

  class Delete {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_ShoppingCart = Registry::get('ShoppingCart');

      if ( is_numeric($_GET['Delete']) ) {
        $KUUZU_ShoppingCart->remove($_GET['Delete']);
      }

      KUUZU::redirect(KUUZU::getLink(null, 'Cart'));
    }
  }
?>
