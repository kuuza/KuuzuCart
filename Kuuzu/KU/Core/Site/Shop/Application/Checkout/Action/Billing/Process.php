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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Checkout\Action\Billing;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Site\Shop\PaymentModuleAbstract;

  class Process {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_Payment = Registry::get('Payment');
      $KUUZU_ShoppingCart = Registry::get('ShoppingCart');

      if ( isset($_POST['payment_method']) && !empty($_POST['payment_method']) ) {
        if ( $KUUZU_Payment->hasActive() && Registry::exists('Payment_' . $_POST['payment_method']) && (Registry::get('Payment_' . $_POST['payment_method']) instanceof PaymentModuleAbstract) && Registry::get('Payment_' . $_POST['payment_method'])->isEnabled() ) {
          $KUUZU_ShoppingCart->setBillingMethod(array('id' => Registry::get('Payment_' . $_POST['payment_method'])->getCode(),
                                                      'title' => Registry::get('Payment_' . $_POST['payment_method'])->getMethodTitle()));

          KUUZU::redirect(KUUZU::getLink(null, null, null, 'SSL'));
        }
      }
    }
  }
?>
