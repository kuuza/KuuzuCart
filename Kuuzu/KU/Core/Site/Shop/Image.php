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

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

  class Image {
    protected $_groups;

    public function __construct() {
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_Language = Registry::get('Language');

      $this->_groups = array();

      $Qgroups = $KUUZU_PDO->prepare('select * from :table_products_images_groups where language_id = :language_id');
      $Qgroups->bindInt(':language_id', $KUUZU_Language->getID());
      $Qgroups->setCache('images_groups-' . $KUUZU_Language->getID());
      $Qgroups->execute();

      foreach ( $Qgroups->fetchAll() as $group ) {
        $this->_groups[(int)$group['id']] = $group;
      }
    }

    public function getID($code) {
      foreach ( $this->_groups as $group ) {
        if ( $group['code'] == $code ) {
          return $group['id'];
        }
      }

      return 0;
    }

    public function getCode($id) {
      return $this->_groups[$id]['code'];
    }

    public function getWidth($code) {
      return $this->_groups[$this->getID($code)]['size_width'];
    }

    public function getHeight($code) {
      return $this->_groups[$this->getID($code)]['size_height'];
    }

    public function exists($code) {
      return isset($this->_groups[$this->getID($code)]);
    }

    public function show($image, $title, $parameters = null, $group = null) {
      if ( empty($group) || !$this->exists($group) ) {
        $group = $this->getCode(DEFAULT_IMAGE_GROUP_ID);
      }

      $group_id = $this->getID($group);

      $width = $height = '';

      if ( ($this->_groups[$group_id]['force_size'] == '1') || empty($image) ) {
        $width = $this->_groups[$group_id]['size_width'];
        $height = $this->_groups[$group_id]['size_height'];
      }

      if ( empty($image) ) {
        $image = 'pixel_trans.gif';
      } else {
        $image = $this->_groups[$group_id]['code'] . '/' . $image;
      }

      $url = (KUUZU::getRequestType() == 'NONSSL') ? KUUZU::getConfig('product_images_http_server') . KUUZU::getConfig('product_images_dir_ws_http_server') : KUUZU::getConfig('product_images_http_server') . KUUZU::getConfig('product_images_dir_ws_http_server');

      return HTML::image($url . $image, $title, $width, $height, $parameters);
    }

    public function getAddress($image, $group = 'default') {
      $group_id = $this->getID($group);

      $url = (KUUZU::getRequestType() == 'NONSSL') ? KUUZU::getConfig('product_images_http_server') . KUUZU::getConfig('product_images_dir_ws_http_server') : KUUZU::getConfig('product_images_http_server') . KUUZU::getConfig('product_images_dir_ws_http_server');

      return $url . $this->_groups[$group_id]['code'] . '/' . $image;
    }
  }
?>