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

  namespace Kuuzu\KU\Core\Site\Shop\Application\Cart\Action;

  use Kuuzu\KU\Core\ApplicationAbstract;
  use Kuuzu\KU\Core\Registry;
  use Kuuzu\KU\Core\Site\Shop\Product;
  use Kuuzu\KU\Core\KUUZU;

  class Add {
    public static function execute(ApplicationAbstract $application) {
      $KUUZU_ShoppingCart = Registry::get('ShoppingCart');

      $requested_product = null;

      if ( count($_GET) > 2 ) {
        $requested_product = basename(key(array_slice($_GET, 2, 1, true)));

        if ( $requested_product == 'Add' ) {
          unset($requested_product);

          if ( count($_GET) > 3 ) {
            $requested_product = basename(key(array_slice($_GET, 3, 1, true)));
          }
        }
      }

      if ( isset($requested_product) ) {
        if ( Product::checkEntry($requested_product) ) {
          $KUUZU_Product = new Product($requested_product);

          if ( $KUUZU_Product->isTypeActionAllowed('AddToShoppingCart') ) {
            if ( $KUUZU_Product->hasVariants() ) {
              if ( isset($_POST['variants']) && is_array($_POST['variants']) && !empty($_POST['variants']) ) {
                if ( $KUUZU_Product->variantExists($_POST['variants']) ) {
                  $KUUZU_ShoppingCart->add($KUUZU_Product->getProductVariantID($_POST['variants']));
                } else {
                  KUUZU::redirect(KUUZU::getLink(null, 'Products', $KUUZU_Product->getKeyword()));
                }
              } else {
                KUUZU::redirect(KUUZU::getLink(null, 'Products', $KUUZU_Product->getKeyword()));
              }
            } else {
              $KUUZU_ShoppingCart->add($KUUZU_Product->getID());
            }
          }
        }
      }

      KUUZU::redirect(KUUZU::getLink(null, 'Cart'));
    }
  }
?>
