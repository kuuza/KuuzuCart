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

  class Weight {
    protected $weight_classes = array();
    protected $precision = 2;

    public function __construct($precision = null) {
      if ( is_int($precision) ) {
        $this->precision = $precision;
      }

      $this->prepareRules();
    }

    public static function getTitle($id) {
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_Language = Registry::get('Language');

      $Qweight = $KUUZU_PDO->prepare('select weight_class_title from :table_weight_classes where weight_class_id = :weight_class_id and language_id = :language_id');
      $Qweight->bindInt(':weight_class_id', $id);
      $Qweight->bindInt(':language_id', $KUUZU_Language->getID());
      $Qweight->execute();

      return $Qweight->value('weight_class_title');
    }

    public function prepareRules() {
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_Language = Registry::get('Language');

      $Qrules = $KUUZU_PDO->prepare('select r.weight_class_from_id, r.weight_class_to_id, r.weight_class_rule from :table_weight_classes_rules r, :table_weight_classes c where c.weight_class_id = r.weight_class_from_id');
      $Qrules->setCache('weight-rules');
      $Qrules->execute();

      while ( $Qrules->fetch() ) {
        $this->weight_classes[$Qrules->valueInt('weight_class_from_id')][$Qrules->valueInt('weight_class_to_id')] = $Qrules->value('weight_class_rule');
      }

      $Qclasses = $KUUZU_PDO->prepare('select weight_class_id, weight_class_key, weight_class_title from :table_weight_classes where language_id = :language_id');
      $Qclasses->bindInt(':language_id', $KUUZU_Language->getID());
      $Qclasses->setCache('weight-classes');
      $Qclasses->execute();

      while ( $Qclasses->fetch() ) {
        $this->weight_classes[$Qclasses->valueInt('weight_class_id')]['key'] = $Qclasses->value('weight_class_key');
        $this->weight_classes[$Qclasses->valueInt('weight_class_id')]['title'] = $Qclasses->value('weight_class_title');
      }
    }

    public function convert($value, $unit_from, $unit_to) {
      $KUUZU_Language = Registry::get('Language');

      if ( $unit_from == $unit_to ) {
        return number_format($value, $this->precision, $KUUZU_Language->getNumericDecimalSeparator(), $KUUZU_Language->getNumericThousandsSeparator());
      } else {
        return number_format($value * $this->weight_classes[(int)$unit_from][(int)$unit_to], $this->precision, $KUUZU_Language->getNumericDecimalSeparator(), $KUUZU_Language->getNumericThousandsSeparator());
      }
    }

    public function display($value, $class) {
      $KUUZU_Language = Registry::get('Language');

      return number_format($value, $this->precision, $KUUZU_Language->getNumericDecimalSeparator(), $KUUZU_Language->getNumericThousandsSeparator()) . $this->weight_classes[$class]['key'];
    }

    public static function getClasses() {
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_Language = Registry::get('Language');

      $weight_class_array = array();

      $Qclasses = $KUUZU_PDO->prepare('select weight_class_id, weight_class_title from :table_weight_classes where language_id = :language_id order by weight_class_title');
      $Qclasses->bindInt(':language_id', $KUUZU_Language->getID());
      $Qclasses->execute();

      while ( $Qclasses->fetch() ) {
        $weight_class_array[] = array('id' => $Qclasses->valueInt('weight_class_id'),
                                      'title' => $Qclasses->value('weight_class_title'));
      }

      return $weight_class_array;
    }
  }
?>
