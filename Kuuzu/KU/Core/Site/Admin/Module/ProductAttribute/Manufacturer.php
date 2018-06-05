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

  class Manufacturer extends \Kuuzu\KU\Core\Site\Admin\ProductAttributeModuleAbstract {
    public function getInputField($value) {
      $KUUZU_PDO = Registry::get('PDO');

      $array = array(array('id' => '',
                           'text' => KUUZU::getDef('none')));

      $Qm = $KUUZU_PDO->query('select manufacturers_id, manufacturers_name from :table_manufacturers order by manufacturers_name');

      while ( $Qm->fetch() ) {
        $array[] = array('id' => $Qm->valueInt('manufacturers_id'),
                         'text' => $Qm->value('manufacturers_name'));
      }

      return HTML::selectMenu('attributes[' . self::getID() . ']', $array, $value);
    }
  }
?>
