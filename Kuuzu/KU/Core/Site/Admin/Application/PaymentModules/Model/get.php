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

  namespace Kuuzu\KU\Core\Site\Admin\Application\PaymentModules\Model;

  use Kuuzu\KU\Core\Registry;

  class get {
    public static function execute($code) {
      $KUUZU_Language = Registry::get('Language');

      $class = 'Kuuzu\\KU\\Core\\Site\\Admin\\Module\\Payment\\' . $code;

      $KUUZU_Language->injectDefinitions('modules/payment/' . $code . '.xml');

      $KUUZU_PM = new $class();

      $result = array('code' => $KUUZU_PM->getCode(),
                      'title' => $KUUZU_PM->getTitle(),
                      'sort_order' => $KUUZU_PM->getSortOrder(),
                      'status' => $KUUZU_PM->isEnabled(),
                      'keys' => $KUUZU_PM->getKeys());

      return $result;
    }
  }
?>
