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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Products;

  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Shop\Product;
  use Kuuzu\KU\Core\KUUZU;

  class Controller extends \Kuuzu\KU\Core\Site\Shop\ApplicationAbstract {
    protected function initialize() {
      $KUUZU_Language = Registry::get('Language');
      $KUUZU_Session = Registry::get('Session');
      $KUUZU_Template = Registry::get('Template');
      $KUUZU_Service = Registry::get('Service');
      $KUUZU_Breadcrumb = Registry::get('Breadcrumb');

      $KUUZU_Language->load('products');

      $requested_product = null;
      $product_check = false;

      if ( count($_GET) > 1 ) {
        $requested_product = basename(key(array_slice($_GET, 1, 1, true)));

        if ( $requested_product == KUUZU::getSiteApplication() ) {
          unset($requested_product);

          if ( count($_GET) > 2 ) {
            $requested_product = basename(key(array_slice($_GET, 2, 1, true)));
          }
        }
      }

      if ( isset($requested_product) ) {
        if ( !self::siteApplicationActionExists($requested_product) ) {
          if ( Product::checkEntry($requested_product) ) {
            $product_check = true;

            Registry::set('Product', new Product($requested_product));
            $KUUZU_Product = Registry::get('Product');
            $KUUZU_Product->incrementCounter();

            $KUUZU_Template->addPageTags('keywords', $KUUZU_Product->getTitle());
            $KUUZU_Template->addPageTags('keywords', $KUUZU_Product->getModel());

            if ( $KUUZU_Product->hasTags() ) {
              $KUUZU_Template->addPageTags('keywords', $KUUZU_Product->getTags());
            }

            $KUUZU_Template->addJavascriptFilename(KUUZU::getPublicSiteLink('javascript/products/info.js'));

// HPDL            Kuu_Services_category_path::process($Kuu_Product->getCategoryID());

            if ( $KUUZU_Service->isStarted('Breadcrumb') ) {
              $KUUZU_Breadcrumb->add($KUUZU_Product->getTitle(), KUUZU::getLink(null, null, $KUUZU_Product->getKeyword()));
            }

            $this->_page_title = $KUUZU_Product->getTitle();
          }
        }
      }

      if ( $product_check === false ) {
        $this->_page_title = KUUZU::getDef('product_not_found_heading');
        $this->_page_contents = 'not_found.php';
      }
    }
  }
?>
