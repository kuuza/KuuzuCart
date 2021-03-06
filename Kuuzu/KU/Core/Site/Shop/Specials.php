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

  class Specials {
    protected $_specials = array();

    public function activateAll() {
      $KUUZU_PDO = Registry::get('PDO');

      $Qspecials = $KUUZU_PDO->query('select specials_id from :table_specials where status = 0 and now() >= start_date and start_date > 0 and now() < expires_date');
      $Qspecials->execute();

      while ( $Qspecials->fetch() ) {
        $this->_setStatus($Qspecials->valueInt('specials_id'), true);
      }
    }

    public function expireAll() {
      $KUUZU_PDO = Registry::get('PDO');

      $Qspecials = $KUUZU_PDO->query('select specials_id from :table_specials where status = 1 and now() >= expires_date and expires_date > 0');
      $Qspecials->execute();

      while ( $Qspecials->fetch() ) {
        $this->_setStatus($Qspecials->valueInt('specials_id'), false);
      }
    }

    public function isActive($id) {
      if ( !isset($this->_specials[$id]) ) {
        $this->_specials[$id] = $this->getPrice($id);
      }

      return is_numeric($this->_specials[$id]);
    }

    public function getPrice($id) {
      $KUUZU_PDO = Registry::get('PDO');

      if ( !isset($this->_specials[$id]) ) {
        $Qspecial = $KUUZU_PDO->prepare('select specials_new_products_price from :table_specials where products_id = :products_id and status = 1');
        $Qspecial->bindInt(':products_id', $id);
        $Qspecial->execute();

        $result = $Qspecial->fetch();

        if ( count($result) > 0 ) {
          $this->_specials[$id] = $result['specials_new_products_price'];
        } else {
          $this->_specials[$id] = null;
        }
      }

      return $this->_specials[$id];
    }

    public static function getListing() {
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_Language = Registry::get('Language');

      $result = array();

      $Qspecials = $KUUZU_PDO->prepare('select SQL_CALC_FOUND_ROWS p.products_id, p.products_price, p.products_tax_class_id, pd.products_name, pd.products_keyword, s.specials_new_products_price, i.image from :table_products p left join :table_products_images i on (p.products_id = i.products_id and i.default_flag = :default_flag), :table_products_description pd, :table_specials s where p.products_status = 1 and s.products_id = p.products_id and p.products_id = pd.products_id and pd.language_id = :language_id and s.status = 1 order by s.specials_date_added desc limit :batch_pageset, :batch_max_results; select found_rows();');
      $Qspecials->bindInt(':default_flag', 1);
      $Qspecials->bindInt(':language_id', $KUUZU_Language->getID());
      $Qspecials->bindInt(':batch_pageset', $KUUZU_PDO->getBatchFrom((isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1), (int)MAX_DISPLAY_SPECIAL_PRODUCTS));
      $Qspecials->bindInt(':batch_max_results', (int)MAX_DISPLAY_SPECIAL_PRODUCTS);
      $Qspecials->execute();

      $result['entries'] = $Qspecials->fetchAll();

      $Qspecials->nextRowset();

      $result['total'] = $Qspecials->fetchColumn();

      return $result;
    }

    protected function _setStatus($id, $status) {
      $KUUZU_PDO = Registry::get('PDO');

      $Qstatus = $KUUZU_PDO->prepare('update :table_specials set status = :status, date_status_change = now() where specials_id = :specials_id');
      $Qstatus->bindInt(':status', ($status === true) ? '1' : '0');
      $Qstatus->bindInt(':specials_id', $id);
      $Qstatus->execute();
    }
  }
?>
