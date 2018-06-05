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

  namespace Kuuzu\KU\Core\Site\Admin\Application\Services\Model;

/**
 * @since v3.0.2
 */

  class get {
    public static function execute($code, $key = null) {
      $class = 'Kuuzu\\KU\\Core\\Site\\Admin\\Module\\Service\\' . $code;

      $KUUZU_SM = new $class();

      $result = array('code' => $KUUZU_SM->getCode(),
                      'title' => $KUUZU_SM->getTitle(),
                      'description' => $KUUZU_SM->getDescription(),
                      'uninstallable' => $KUUZU_SM->isUninstallable(),
                      'keys' => $KUUZU_SM->keys());

      if ( isset($key) ) {
        $result = $result[$key] ?: null;
      }

      return $result;
    }
  }
?>
