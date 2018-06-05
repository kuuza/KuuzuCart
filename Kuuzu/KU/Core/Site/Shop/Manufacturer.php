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

  class Manufacturer {
    protected $_data = array();

    public function __construct($id) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qmanufacturer = $KUUZU_PDO->prepare('select manufacturers_id as id, manufacturers_name as name, manufacturers_image as image from :table_manufacturers where manufacturers_id = :manufacturers_id');
      $Qmanufacturer->bindInt(':manufacturers_id', $id);
      $Qmanufacturer->execute();

      $result = $Qmanufacturer->fetch();

      if ( $result !== false ) {
        $this->_data = $result;
      }
    }

    function getID() {
      if ( isset($this->_data['id']) ) {
        return $this->_data['id'];
      }

      return false;
    }

    function getTitle() {
      if ( isset($this->_data['name']) ) {
        return $this->_data['name'];
      }

      return false;
    }

    function getImage() {
      if ( isset($this->_data['image']) ) {
        return $this->_data['image'];
      }

      return false;
    }
  }
?>
