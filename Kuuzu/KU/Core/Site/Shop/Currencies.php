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

  namespace Kuuzu\KU\Core\Site\Shop;

  use Kuuzu\KU\Core\Registry;

  class Currencies {
    protected $currencies = array();

    public function __construct() {
      $KUUZU_PDO = Registry::get('PDO');

      $Qcurrencies = $KUUZU_PDO->prepare('select * from :table_currencies');
      $Qcurrencies->setCache('currencies');
      $Qcurrencies->execute();

      while ( $Qcurrencies->fetch() ) {
        $this->currencies[$Qcurrencies->value('code')] = array('id' => $Qcurrencies->valueInt('currencies_id'),
                                                               'title' => $Qcurrencies->value('title'),
                                                               'symbol_left' => $Qcurrencies->value('symbol_left'),
                                                               'symbol_right' => $Qcurrencies->value('symbol_right'),
                                                               'decimal_places' => $Qcurrencies->valueInt('decimal_places'),
                                                               'value' => $Qcurrencies->valueDecimal('value'));
      }
    }

    public function format($number, $currency_code = null, $currency_value = null) {
      $KUUZU_Language = Registry::get('Language');

      if ( empty($currency_code) || ($this->exists($currency_code) == false) ) {
        $currency_code = (isset($_SESSION['currency']) ? $_SESSION['currency'] : DEFAULT_CURRENCY);
      }

      if ( empty($currency_value) || !is_numeric($currency_value) ) {
        $currency_value = $this->currencies[$currency_code]['value'];
      }

      return $this->currencies[$currency_code]['symbol_left'] . number_format(round($number * $currency_value, $this->currencies[$currency_code]['decimal_places']), $this->currencies[$currency_code]['decimal_places'], $KUUZU_Language->getNumericDecimalSeparator(), $KUUZU_Language->getNumericThousandsSeparator()) . $this->currencies[$currency_code]['symbol_right'];
    }

    public function formatRaw($number, $currency_code = null, $currency_value = null) {
      if ( empty($currency_code) || ($this->exists($currency_code) == false) ) {
        $currency_code = (isset($_SESSION['currency']) ? $_SESSION['currency'] : DEFAULT_CURRENCY);
      }

      if ( empty($currency_value) || !is_numeric($currency_value) ) {
        $currency_value = $this->currencies[$currency_code]['value'];
      }

      return number_format(round($number * $currency_value, $this->currencies[$currency_code]['decimal_places']), $this->currencies[$currency_code]['decimal_places'], '.', '');
    }

    public function addTaxRateToPrice($price, $tax_rate, $quantity = 1) {
      $price = round($price, $this->currencies[DEFAULT_CURRENCY]['decimal_places']);

      if ( (DISPLAY_PRICE_WITH_TAX == '1') && ($tax_rate > 0) ) {
        $price += round($price * ($tax_rate / 100), $this->currencies[DEFAULT_CURRENCY]['decimal_places']);
      }

      return round($price * $quantity, $this->currencies[DEFAULT_CURRENCY]['decimal_places']);
    }

    public function displayPrice($price, $tax_class_id, $quantity = 1, $currency_code = null, $currency_value = null) {
      $KUUZU_Tax = Registry::get('Tax');

      $price = round($price, $this->currencies[DEFAULT_CURRENCY]['decimal_places']);

      if ( (DISPLAY_PRICE_WITH_TAX == '1') && ($tax_class_id > 0) ) {
        $price += round($price * ($KUUZU_Tax->getTaxRate($tax_class_id) / 100), $this->currencies[DEFAULT_CURRENCY]['decimal_places']);
      }

      return $this->format($price * $quantity, $currency_code, $currency_value);
    }

    public function displayPriceRaw($price, $tax_class_id, $quantity = 1, $currency_code = null, $currency_value = null) {
      $KUUZU_Tax = Registry::get('Tax');

      if ( !isset($currency_code) ) {
        $currency_code = DEFAULT_CURRENCY;
      }

      if ( !isset($currency_value) ) {
        $currency_value = $this->currencies[DEFAULT_CURRENCY]['value'];
      }

      $price = round($price, $this->currencies[DEFAULT_CURRENCY]['decimal_places']);

      if ( (DISPLAY_PRICE_WITH_TAX == '1') && ($tax_class_id > 0) ) {
        $price += round($price * ($KUUZU_Tax->getTaxRate($tax_class_id) / 100), $this->currencies[DEFAULT_CURRENCY]['decimal_places']);
      }

      return $this->formatRaw($price * $quantity, $currency_code, $currency_value);
    }

    public function displayPriceWithTaxRate($price, $tax_rate, $quantity = 1, $force = false, $currency_code = null, $currency_value = null) {
      $price = round($price, $this->currencies[DEFAULT_CURRENCY]['decimal_places']);

      if ( (($force === true) || (DISPLAY_PRICE_WITH_TAX == '1')) && ($tax_rate > 0) ) {
        $price += round($price * ($tax_rate / 100), $this->currencies[DEFAULT_CURRENCY]['decimal_places']);
      }

      return $this->format($price * $quantity, $currency_code, $currency_value);
    }

    public function exists($code) {
      return isset($this->currencies[$code]);
    }

    public function decimalPlaces($code) {
      if ( $this->exists($code) ) {
        return $this->currencies[$code]['decimal_places'];
      }

      return false;
    }

    public function value($code) {
      if ( $this->exists($code) ) {
        return $this->currencies[$code]['value'];
      }

      return false;
    }

    public function getData() {
      return $this->currencies;
    }

    public function getCode($id = null) {
      if ( is_numeric($id) ) {
        foreach ( $this->currencies as $key => $value ) {
          if ( $value['id'] == $id ) {
            return $key;
          }
        }
      } else {
        return $_SESSION['currency'];
      }
    }

    public function getID($code = null) {
      if ( empty($code) ) {
        $code = $_SESSION['currency'];
      }

      return $this->currencies[$code]['id'];
    }
  }
?>
