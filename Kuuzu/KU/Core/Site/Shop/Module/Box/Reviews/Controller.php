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

  namespace Kuuzu\KU\Core\Site\Shop\Module\Box\Reviews;

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Registry;

  class Controller extends \Kuuzu\KU\Core\Modules {
    var $_title,
        $_code = 'Reviews',
        $_author_name = 'Kuuzu',
        $_author_www = 'https://kuuzu.org',
        $_group = 'Box';

    public function __construct() {
      $this->_title = KUUZU::getDef('box_reviews_heading');
    }

    public function initialize() {
      $KUUZU_Service = Registry::get('Service');
      $KUUZU_Cache = Registry::get('Cache');
      $KUUZU_Product = ( Registry::exists('Product') ) ? Registry::get('Product') : null;
      $KUUZU_Language = Registry::get('Language');
      $KUUZU_PDO = Registry::get('PDO');
      $KUUZU_Image = Registry::get('Image');

      $this->_title_link = KUUZU::getLink(null, 'Products', 'Reviews');

      if ( $KUUZU_Service->isStarted('Reviews') ) {
        if ( (BOX_REVIEWS_CACHE > 0) && $KUUZU_Cache->read('box-reviews' . (isset($KUUZU_Product) && ($KUUZU_Product instanceof \Kuuzu\KU\Site\Shop\Product) && $KUUZU_Product->isValid() ? '-' . $KUUZU_Product->getID() : '') . '-' . $KUUZU_Language->getCode(), BOX_REVIEWS_CACHE) ) {
          $data = $KUUZU_Cache->getCache();
        } else {
          $data = array();

          $sql_query = 'select r.reviews_id, r.reviews_rating, p.products_id, pd.products_name, pd.products_keyword, i.image from :table_reviews r, :table_products p left join :table_products_images i on (p.products_id = i.products_id and i.default_flag = :default_flag), :table_products_description pd where r.products_id = p.products_id and p.products_status = 1 and r.languages_id = :language_id and p.products_id = pd.products_id and pd.language_id = :language_id and r.reviews_status = 1';

          if ( isset($KUUZU_Product) && ($KUUZU_Product instanceof \Kuuzu\KU\Site\Shop\Product) && $KUUZU_Product->isValid() ) {
            $sql_query .= ' and p.products_id = :products_id';
          }

          $sql_query .= ' order by r.reviews_id desc limit :max_random_select_reviews';

          $Qreview = $KUUZU_PDO->prepare($sql_query);
          $Qreview->bindInt(':default_flag', 1);
          $Qreview->bindInt(':language_id', $KUUZU_Language->getID());
          $Qreview->bindInt(':language_id', $KUUZU_Language->getID());

          if ( isset($KUUZU_Product) && ($KUUZU_Product instanceof \Kuuzu\KU\Site\Shop\Product) && $KUUZU_Product->isValid() ) {
            $Qreview->bindInt(':products_id', $KUUZU_Product->getID());
          }

          $Qreview->bindInt(':max_random_select_reviews', (int)BOX_REVIEWS_RANDOM_SELECT);
          $Qreview->execute();

          $result = $Qreview->fetchAll();

          if ( count($result) > 0 ) {
            $result = $result[rand(0, count($result) - 1)];

            $Qtext = $KUUZU_PDO->prepare('select substring(reviews_text, 1, 60) as reviews_text from :table_reviews where reviews_id = :reviews_id and languages_id = :languages_id');
            $Qtext->bindInt(':reviews_id', $result['reviews_id']);
            $Qtext->bindInt(':languages_id', $KUUZU_Language->getID());
            $Qtext->execute();

            $data = array_merge($result, $Qtext->fetch());
          }

          $KUUZU_Cache->write($data);
        }

        $this->_content = '';

        if ( empty($data) ) {
          if ( isset($KUUZU_Product) && ($KUUZU_Product instanceof \Kuuzu\KU\Site\Shop\Product) && $KUUZU_Product->isValid() ) {
            $this->_content = '<div style="float: left; width: 55px;">' . HTML::button(array('href' => KUUZU::getLink(null, 'Products', 'Reviews&Write&' . $KUUZU_Product->getKeyword()), 'icon' => 'pencil', 'title' => KUUZU::getDef('button_write_review'))) . '</div>' .
                              HTML::link(KUUZU::getLink(null, 'Products', 'Reviews&Write&' . $KUUZU_Product->getKeyword()), KUUZU::getDef('box_reviews_write')) .
                              '<div style="clear: both;"></div>';
          }
        } else {
          if ( !empty($data['image']) ) {
            $this->_content = '<div align="center">' . HTML::link(KUUZU::getLink(null, 'Products', 'Reviews&View=' . $data['reviews_id'] . '&' . $data['products_keyword']), $KUUZU_Image->show($data['image'], $data['products_name'])) . '</div>';
          }

          $this->_content .= HTML::link(KUUZU::getLink(null, 'Products', 'Reviews&View=' . $data['reviews_id'] . '&' . $data['products_keyword']), wordwrap(HTML::outputProtected($data['reviews_text']), 15, '&shy;') . ' ..') . '<br /><div align="center">' . HTML::image(KUUZU::getPublicSiteLink('images/stars_' . $data['reviews_rating'] . '.png'), sprintf(KUUZU::getDef('box_reviews_stars_rating'), $data['reviews_rating'])) . '</div>';
        }
      }
    }

    public function install() {
      $KUUZU_PDO = Registry::get('PDO');

      parent::install();

      $KUUZU_PDO->exec("insert into :table_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Random Review Selection', 'BOX_REVIEWS_RANDOM_SELECT', '10', 'Select a random review from this amount of the newest reviews available', '6', '0', now())");
      $KUUZU_PDO->exec("insert into :table_configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Cache Contents', 'BOX_REVIEWS_CACHE', '1', 'Number of minutes to keep the contents cached (0 = no cache)', '6', '0', now())");
    }

    public function getKeys() {
      if (!isset($this->_keys)) {
        $this->_keys = array('BOX_REVIEWS_RANDOM_SELECT', 'BOX_REVIEWS_CACHE');
      }

      return $this->_keys;
    }
  }
?>
