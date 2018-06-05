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

  class RecentlyVisited {
    var $visits = array();

    public function __construct() {
      if ( !isset($_SESSION['Shop']['RecentlyVisited']) ) {
        $_SESSION['Shop']['RecentlyVisited'] = array();
      }

      $this->visits =& $_SESSION['Shop']['RecentlyVisited'];
    }

    function initialize() {
      $KUUZU_Category = Registry::get('Category');

      if ( SERVICE_RECENTLY_VISITED_SHOW_PRODUCTS == '1' ) {
        if ( Registry::exists('Product') && (Registry::get('Product') instanceof Product) ) {
          $this->setProduct(Registry::get('Product')->getMasterID());
        }
      }

      if ( (SERVICE_RECENTLY_VISITED_SHOW_CATEGORIES == '1') && ($KUUZU_Category->getID() > 0) ) {
        $this->setCategory($KUUZU_Category->getID());
      }

      if ( SERVICE_RECENTLY_VISITED_SHOW_SEARCHES == '1' ) {
        if ( Registry::exists('Search') && (Registry::get('Search') instanceof Search) && (Registry::get('Search')->hasKeywords()) ) {
          $this->setSearchQuery(Registry::get('Search')->getKeywords());
        }
      }
    }

    function setProduct($id) {
      if (isset($this->visits['products'])) {
        foreach ($this->visits['products'] as $key => $value) {
          if ($value['id'] == $id) {
            unset($this->visits['products'][$key]);
            break;
          }
        }

        if (sizeof($this->visits['products']) > (SERVICE_RECENTLY_VISITED_MAX_PRODUCTS * 2)) {
          array_pop($this->visits['products']);
        }
      } else {
        $this->visits['products'] = array();
      }

      array_unshift($this->visits['products'], array('id' => $id));
    }

    function setCategory($id) {
      if (isset($this->visits['categories'])) {
        foreach ($this->visits['categories'] as $key => $value) {
          if ($value['id'] == $id) {
            unset($this->visits['categories'][$key]);
            break;
          }
        }

        if (sizeof($this->visits['categories']) > (SERVICE_RECENTLY_VISITED_MAX_CATEGORIES * 2)) {
          array_pop($this->visits['categories']);
        }
      } else {
        $this->visits['categories'] = array();
      }

      array_unshift($this->visits['categories'], array('id' => $id));
    }

    function setSearchQuery($keywords) {
      $KUUZU_Search = Registry::get('Search');

      if (isset($this->visits['searches'])) {
        foreach ($this->visits['searches'] as $key => $value) {
          if ($value['keywords'] == $keywords) {
            unset($this->visits['searches'][$key]);
            break;
          }
        }

        if (sizeof($this->visits['searches']) > (SERVICE_RECENTLY_VISITED_MAX_SEARCHES * 2)) {
          array_pop($this->visits['searches']);
        }
      } else {
        $this->visits['searches'] = array();
      }

      array_unshift($this->visits['searches'], array('keywords' => $keywords,
                                                     'results' => $KUUZU_Search->getNumberOfResults()
                                                    ));
    }

    function hasHistory() {
      if ($this->hasProducts() || $this->hasCategories() || $this->hasSearches()) {
        return true;
      }

      return false;
    }

    function hasProducts() {
      if ( SERVICE_RECENTLY_VISITED_SHOW_PRODUCTS == '1' ) {
        if ( isset($this->visits['products']) && !empty($this->visits['products']) ) {
          foreach ($this->visits['products'] as $k => $v) {
            if ( !Product::checkEntry($v['id']) ) {
              unset($this->visits['products'][$k]);
            }
          }

          return (sizeof($this->visits['products']) > 0);
        }
      }

      return false;
    }

    function getProducts() {
      $history = array();

      if (isset($this->visits['products']) && (empty($this->visits['products']) === false)) {
        $counter = 0;

        foreach ($this->visits['products'] as $k => $v) {
          $counter++;

          $KUUZU_Product = new Product($v['id']);
          $KUUZU_Category = new Category($KUUZU_Product->getCategoryID());

          $history[] = array('name' => $KUUZU_Product->getTitle(),
                             'id' => $KUUZU_Product->getID(),
                             'keyword' => $KUUZU_Product->getKeyword(),
                             'price' => (SERVICE_RECENTLY_VISITED_SHOW_PRODUCT_PRICES == '1') ? $KUUZU_Product->getPriceFormated(true) : '',
                             'image' => $KUUZU_Product->getImage(),
                             'category_name' =>  $KUUZU_Category->getTitle(),
                             'category_path' => $KUUZU_Category->getPath()
                            );

          if ($counter == SERVICE_RECENTLY_VISITED_MAX_PRODUCTS) {
            break;
          }
        }
      }

      return $history;
    }

    function hasCategories() {
      return ( (SERVICE_RECENTLY_VISITED_SHOW_CATEGORIES == '1') && isset($this->visits['categories']) && !empty($this->visits['categories']) );
    }

    function getCategories() {
      $history = array();

      if (isset($this->visits['categories']) && (empty($this->visits['categories']) === false)) {
        $counter = 0;

        foreach ($this->visits['categories'] as $k => $v) {
          $counter++;

          $KUUZU_Category = new Category($v['id']);

          if ($KUUZU_Category->hasParent()) {
            $KUUZU_CategoryParent = new Category($KUUZU_Category->getParent());
          }

          $history[]  = array('id' => $KUUZU_Category->getID(),
                              'name' => $KUUZU_Category->getTitle(),
                              'path' => $KUUZU_Category->getPath(),
                              'image' => $KUUZU_Category->getImage(),
                              'parent_name' => ($KUUZU_Category->hasParent()) ? $KUUZU_CategoryParent->getTitle() : '',
                              'parent_id' => ($KUUZU_Category->hasParent()) ? $KUUZU_CategoryParent->getID() : ''
                             );

          if ($counter == SERVICE_RECENTLY_VISITED_MAX_CATEGORIES) {
            break;
          }
        }
      }

      return $history;
    }

    function hasSearches() {
      return ( (SERVICE_RECENTLY_VISITED_SHOW_SEARCHES == '1') && isset($this->visits['searches']) && !empty($this->visits['searches']) );
    }

    function getSearches() {
      $history = array();

      if (isset($this->visits['searches']) && (empty($this->visits['searches']) === false)) {
        $counter = 0;

        foreach ($this->visits['searches'] as $k => $v) {
          $counter++;

          $history[]  = array('keywords' => $this->visits['searches'][$k]['keywords'],
                              'results' => $this->visits['searches'][$k]['results']
                             );

          if ($counter == SERVICE_RECENTLY_VISITED_MAX_SEARCHES) {
            break;
          }
        }
      }

      return $history;
    }
  }
?>
