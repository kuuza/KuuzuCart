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

/**
 * @since v3.0.3
 */

  class DateAvailable extends \Kuuzu\KU\Core\Site\Admin\ProductAttributeModuleAbstract {
    public function getInputField($value) {
      return HTML::inputField('attributes[' . self::getID() . ']', $value, 'id="attributes_' . self::getID() . '"') . '<script>$(function() { $("#attributes_' . self::getID() . '").datepicker( { dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true } ); });</script>';
    }
  }
?>
