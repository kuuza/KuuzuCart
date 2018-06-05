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

  namespace Kuuzu\KU\Core\Site\Shop\Module\Service;

  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Shop\Currencies as CurrenciesClass;

  class Currencies implements \Kuuzu\KU\Core\Site\Shop\ServiceInterface {
    public static function start() {
      Registry::set('Currencies', new CurrenciesClass());
      $KUUZU_Currencies = Registry::get('Currencies');

      $KUUZU_Language = Registry::get('Language');

      if ( !isset($_SESSION['currency']) || isset($_GET['currency']) || ( (USE_DEFAULT_LANGUAGE_CURRENCY == '1') && ($KUUZU_Currencies->getCode($KUUZU_Language->getCurrencyID()) != $_SESSION['currency']) ) ) {
        if ( isset($_GET['currency']) && $KUUZU_Currencies->exists($_GET['currency']) ) {
          $_SESSION['currency'] = $_GET['currency'];
        } else {
          $_SESSION['currency'] = (USE_DEFAULT_LANGUAGE_CURRENCY == '1') ? $KUUZU_Currencies->getCode($KUUZU_Language->getCurrencyID()) : DEFAULT_CURRENCY;
        }

        if ( isset($_SESSION['cartID']) ) {
          unset($_SESSION['cartID']);
        }
      }

      return true;
    }

    public static function stop() {
      return true;
    }
  }
?>
