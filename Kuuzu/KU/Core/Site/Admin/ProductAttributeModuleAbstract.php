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

  namespace Kuuzu\KU\Core\Site\Admin;

  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\KUUZU;

/**
 * @since v3.0.3
 */

  abstract class ProductAttributeModuleAbstract {
    protected $_title;

    abstract public function getInputField($value);

    public function __construct() {
      $KUUZU_Language = Registry::get('Language');

      $KUUZU_Language->loadIniFile('modules/ProductAttribute/' . $this->getCode() . '.php');

      $this->_title = KUUZU::getDef('product_attribute_' . $this->getCode() . '_title');
    }

    public function getID() {
      $KUUZU_PDO = Registry::get('PDO');

      $Qmodule = $KUUZU_PDO->prepare('select id from :table_templates_boxes where code = :code and modules_group = :modules_group');
      $Qmodule->bindValue(':code', $this->getCode());
      $Qmodule->bindValue(':modules_group', 'ProductAttribute');
      $Qmodule->execute();

      return ( $Qmodule->fetch() !== false ) ? $Qmodule->valueInt('id') : 0;
    }

    public function getCode() {
      $tmp = explode('\\', get_class($this));

      return end($tmp);
    }

    public function getTitle() {
      return $this->_title;
    }

    public function isInstalled() {
      return ($this->getID() > 0);
    }

    public function install() {
      $KUUZU_PDO = Registry::get('PDO');

      $Qinstall = $KUUZU_PDO->prepare('insert into :table_templates_boxes (title, code, author_name, author_www, modules_group) values (:title, :code, :author_name, :author_www, :modules_group)');
      $Qinstall->bindValue(':title', $this->getTitle());
      $Qinstall->bindValue(':code', $this->getCode());
      $Qinstall->bindValue(':author_name', '');
      $Qinstall->bindValue(':author_www', '');
      $Qinstall->bindValue(':modules_group', 'ProductAttribute');
      $Qinstall->execute();

      return ( $Qinstall->isError() === false );
    }

    public function uninstall() {
      $KUUZU_PDO = Registry::get('PDO');

      $error = false;

      $KUUZU_PDO->beginTransaction();

      $Qdelete = $KUUZU_PDO->prepare('delete from :table_product_attributes where id = :id');
      $Qdelete->bindInt(':id', $this->getID());
      $Qdelete->execute();

      if ( $Qdelete->isError() ) {
        $error = true;
      }

      if ( $error === false ) {
        $Quninstall = $KUUZU_PDO->prepare('delete from :table_templates_boxes where code = :code and modules_group = :modules_group');
        $Quninstall->bindValue(':code', $this->getCode());
        $Quninstall->bindValue(':modules_group', 'ProductAttribute');
        $Quninstall->execute();

        if ( $Quninstall->isError() ) {
          $error = true;
        }
      }

      if ( $error === false ) {
        $KUUZU_PDO->commit();
      } else {
        $KUUZU_PDO->rollBack();
      }

      return ( $error === false );
    }
  }
?>
