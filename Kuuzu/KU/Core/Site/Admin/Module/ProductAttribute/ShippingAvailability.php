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

  namespace Kuuzu\KU\Core\Site\Admin\Module\ProductAttribute;

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

/**
 * @since v3.0.3
 */

  class ShippingAvailability extends \Kuuzu\KU\Core\Site\Admin\ProductAttributeModuleAbstract {
    public function getInputField($value) {
      $KUUZU_Language = Registry::get('Language');
      $KUUZU_PDO = Registry::get('PDO');

      $array = array();

      $Qstatus = $KUUZU_PDO->prepare('select id, title from :table_shipping_availability where languages_id = :languages_id order by title');
      $Qstatus->bindInt(':languages_id', $KUUZU_Language->getID());
      $Qstatus->execute();

      while ( $Qstatus->fetch() ) {
        $array[] = array('id' => $Qstatus->valueInt('id'),
                         'text' => $Qstatus->value('title'));
      }

      return HTML::selectMenu('attributes[' . self::getID() . ']', $array, $value);
    }
  }
?>
