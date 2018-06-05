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

  namespace Kuuzu\KU\Core\Site\Shop\Module\Content\RecentlyVisited;

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

  class Controller extends \Kuuzu\KU\Core\Modules {
    var $_title,
        $_code = 'RecentlyVisited',
        $_author_name = 'Kuuzu',
        $_author_www = 'https://kuuzu.org',
        $_group = 'Content';

    public function __construct() {
      $this->_title = KUUZU::getDef('recently_visited_title');
    }

    function initialize() {
      $KUUZU_Service = Registry::get('Service');
      $KUUZU_RecentlyVisited = Registry::get('RecentlyVisited');
      $KUUZU_Image = Registry::get('Image');

      if ( $KUUZU_Service->isStarted('RecentlyVisited') && $KUUZU_RecentlyVisited->hasHistory() ) {
        $this->_content = '<table border="0" width="100%" cellspacing="0" cellpadding="2">' .
                          '  <tr>';

        if ( $KUUZU_RecentlyVisited->hasProducts() ) {
          $this->_content .= '    <td valign="top">' .
                             '      <h6>' . KUUZU::getDef('recently_visited_products_title') . '</h6>' .
                             '      <ol style="list-style: none; margin: 0; padding: 0;">';

          foreach ( $KUUZU_RecentlyVisited->getProducts() as $product ) {
            $this->_content .= '<li style="padding-bottom: 15px;">';

            if ( SERVICE_RECENTLY_VISITED_SHOW_PRODUCT_IMAGES == '1' ) {
              $this->_content .= '<span style="float: left; width: ' . ($KUUZU_Image->getWidth('mini') + 10) . 'px; text-align: center;">' . HTML::link(KUUZU::getLink(null, 'Products', $product['keyword']), $KUUZU_Image->show($product['image'], $product['name'], null, 'mini')) . '</span>';
            }

            $this->_content .= '<div style="float: left;">' . HTML::link(KUUZU::getLink(null, 'Products', $product['keyword']), $product['name']) . '<br />';

            if ( SERVICE_RECENTLY_VISITED_SHOW_PRODUCT_PRICES == '1' ) {
              $this->_content .= $product['price'] . '&nbsp;';
            }

            $this->_content .= '<i>(' . sprintf(KUUZU::getDef('recently_visited_item_in_category'), HTML::link(KUUZU::getLink(null, 'Index', 'cPath=' . $product['category_path']), $product['category_name'])) . ')</i></div>' .
                               '<div style="clear: both;"></div>' .
                               '</li>';
          }

          $this->_content .= '      </ol>' .
                             '    </td>';
        }

        if ( $KUUZU_RecentlyVisited->hasCategories() ) {
          $this->_content .= '      <td valign="top">' .
                             '        <h6>' . KUUZU::getDef('recently_visited_categories_title') . '</h6>' .
                             '        <ol style="list-style: none; margin: 0; padding: 0;">';

          foreach ( $KUUZU_RecentlyVisited->getCategories() as $category ) {
            $this->_content .= '<li>' . HTML::link(KUUZU::getLink(null, 'Index', 'cPath=' . $category['path']), $category['name']);

            if ( !empty($category['parent_id']) ) {
              $this->_content .= '&nbsp;<i>(' . sprintf(KUUZU::getDef('recently_visited_item_in_category'), HTML::link(KUUZU::getLink(null, 'Index', 'cPath=' . $category['parent_id']), $category['parent_name'])) . ')</i>';
            }

            $this->_content .= '</li>';
          }

          $this->_content .= '      </ol>' .
                             '    </td>';
        }

        if ( $KUUZU_RecentlyVisited->hasSearches() ) {
          $this->_content .= '      <td valign="top">' .
                             '        <h6>' . KUUZU::getDef('recently_visited_searches_title') . '</h6>' .
                             '        <ol style="list-style: none; margin: 0; padding: 0;">';

          foreach ( $KUUZU_RecentlyVisited->getSearches() as $searchphrase ) {
            $this->_content .= '<li>' . HTML::link(KUUZU::getLink(null, 'Search', 'Q=' . $searchphrase['keywords']), HTML::outputProtected($searchphrase['keywords'])) . ' <i>(' . number_format($searchphrase['results']) . ' results)</i></li>';
          }

          $this->_content .= '      </ol>' .
                             '    </td>';
        }

        $this->_content .= '  </tr>' .
                           '</table>';
      }
    }
  }
?>
