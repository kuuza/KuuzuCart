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

  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\PDO;
  use Kuuzu\KU\Core\Site\Shop\Product;
  use Kuuzu\KU\Core\Site\Shop\Products;

// create column list
  $define_list = array('PRODUCT_LIST_MODEL' => PRODUCT_LIST_MODEL,
                       'PRODUCT_LIST_NAME' => PRODUCT_LIST_NAME,
                       'PRODUCT_LIST_MANUFACTURER' => PRODUCT_LIST_MANUFACTURER,
                       'PRODUCT_LIST_PRICE' => PRODUCT_LIST_PRICE,
                       'PRODUCT_LIST_QUANTITY' => PRODUCT_LIST_QUANTITY,
                       'PRODUCT_LIST_WEIGHT' => PRODUCT_LIST_WEIGHT,
                       'PRODUCT_LIST_IMAGE' => PRODUCT_LIST_IMAGE,
                       'PRODUCT_LIST_BUY_NOW' => PRODUCT_LIST_BUY_NOW);

  asort($define_list);

  $column_list = array();

  foreach ( $define_list as $key => $value ) {
    if ($value > 0) $column_list[] = $key;
  }

  if ( (count($products_listing['entries']) > 0) && ( (PREV_NEXT_BAR_LOCATION == '1') || (PREV_NEXT_BAR_LOCATION == '3') ) ) {
?>

<div class="listingPageLinks">
  <span style="float: right;"><?php echo PDO::getBatchPageLinks('page', $products_listing['total'], KUUZU::getAllGET('page')); ?></span>

  <?php echo PDO::getBatchTotalPages(KUUZU::getDef('result_set_number_of_products'), (isset($_GET['page']) ? $_GET['page'] : 1), $products_listing['total']); ?>
</div>

<?php
  }
?>

<div>
  
<?php
  if ( count($products_listing['entries']) > 0 ) {
?>

  <table border="0" width="100%" cellspacing="0" cellpadding="2">
    <tr>

<?php
    for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
      $lc_key = false;
      $lc_align = '';

      switch ($column_list[$col]) {
        case 'PRODUCT_LIST_MODEL':
          $lc_text = KUUZU::getDef('listing_model_heading');
          $lc_key = 'model';
          break;
        case 'PRODUCT_LIST_NAME':
          $lc_text = KUUZU::getDef('listing_products_heading');
          $lc_key = 'name';
          break;
        case 'PRODUCT_LIST_MANUFACTURER':
          $lc_text = KUUZU::getDef('listing_manufacturer_heading');
          $lc_key = 'manufacturer';
          break;
        case 'PRODUCT_LIST_PRICE':
          $lc_text = KUUZU::getDef('listing_price_heading');
          $lc_key = 'price';
          $lc_align = 'right';
          break;
        case 'PRODUCT_LIST_QUANTITY':
          $lc_text = KUUZU::getDef('listing_quantity_heading');
          $lc_key = 'quantity';
          $lc_align = 'right';
          break;
        case 'PRODUCT_LIST_WEIGHT':
          $lc_text = KUUZU::getDef('listing_weight_heading');
          $lc_key = 'weight';
          $lc_align = 'right';
          break;
        case 'PRODUCT_LIST_IMAGE':
          $lc_text = KUUZU::getDef('listing_image_heading');
          $lc_align = 'center';
          break;
        case 'PRODUCT_LIST_BUY_NOW':
          $lc_text = KUUZU::getDef('listing_buy_now_heading');
          $lc_align = 'center';
          break;
      }

      if ($lc_key !== false) {
        $lc_text = Products::getListingSortLink($lc_key, $lc_text);
      }

      echo '      <td align="' . $lc_align . '" class="productListing-heading">&nbsp;' . $lc_text . '&nbsp;</td>' . "\n";
    }
?>

    </tr>

<?php
    $rows = 0;

    foreach ( $products_listing['entries'] as $p ) {
      $KUUZU_Product = new Product($p['products_id']);

      $rows++;

      echo '    <tr class="' . ((($rows/2) == floor($rows/2)) ? 'productListing-even' : 'productListing-odd') . '">' . "\n";

      for ($col=0, $n=sizeof($column_list); $col<$n; $col++) {
        $lc_align = '';

        switch ($column_list[$col]) {
          case 'PRODUCT_LIST_MODEL':
            $lc_align = '';
            $lc_text = '&nbsp;' . $KUUZU_Product->getModel() . '&nbsp;';
            break;
          case 'PRODUCT_LIST_NAME':
            $lc_align = '';
            if (isset($_GET['manufacturers'])) {
              $lc_text = HTML::link(KUUZU::getLink(null, 'Products', $KUUZU_Product->getKeyword() . '&manufacturers=' . $_GET['manufacturers']), $KUUZU_Product->getTitle());
            } else {
              $lc_text = '&nbsp;' . HTML::link(KUUZU::getLink(null, 'Products', $KUUZU_Product->getKeyword() . ($KUUZU_Category->getID() > 0 ? '&cPath=' . $KUUZU_Category->getPath() : '')), $KUUZU_Product->getTitle()) . '&nbsp;';
            }
            break;
          case 'PRODUCT_LIST_MANUFACTURER':
            $lc_align = '';
            $lc_text = '&nbsp;';

            if ( $KUUZU_Product->hasManufacturer() ) {
              $lc_text = '&nbsp;' . HTML::link(KUUZU::getLink(null, 'Index', 'Manufacturers=' . $KUUZU_Product->getManufacturerID()), $KUUZU_Product->getManufacturer()) . '&nbsp;';
            }
            break;
          case 'PRODUCT_LIST_PRICE':
            $lc_align = 'right';
            $lc_text = '&nbsp;' . $KUUZU_Product->getPriceFormated() . '&nbsp;';
            break;
          case 'PRODUCT_LIST_QUANTITY':
            $lc_align = 'right';
            $lc_text = '&nbsp;' . $KUUZU_Product->getQuantity() . '&nbsp;';
            break;
          case 'PRODUCT_LIST_WEIGHT':
            $lc_align = 'right';
            $lc_text = '&nbsp;' . $KUUZU_Product->getWeight() . '&nbsp;';
            break;
          case 'PRODUCT_LIST_IMAGE':
            $lc_align = 'center';
            if (isset($_GET['manufacturers'])) {
              $lc_text = HTML::link(KUUZU::getLink(null, 'Products', $KUUZU_Product->getKeyword() . '&manufacturers=' . $_GET['manufacturers']), $KUUZU_Image->show($KUUZU_Product->getImage(), $KUUZU_Product->getTitle()));
            } else {
              $lc_text = '&nbsp;' . HTML::link(KUUZU::getLink(null, 'Products', $KUUZU_Product->getKeyword() . ($KUUZU_Category->getID() > 0 ? '&cPath=' . $KUUZU_Category->getPath() : '')), $KUUZU_Image->show($KUUZU_Product->getImage(), $KUUZU_Product->getTitle())) . '&nbsp;';
            }
            break;
          case 'PRODUCT_LIST_BUY_NOW':
            $lc_align = 'center';
            $lc_text = HTML::button(array('href' => KUUZU::getLink(null, 'Cart', 'Add&' . $KUUZU_Product->getKeyword()), 'icon' => 'cart', 'title' => KUUZU::getDef('button_buy_now')));
            break;
        }

        echo '      <td ' . ((empty($lc_align) === false) ? 'align="' . $lc_align . '" ' : '') . 'class="productListing-data">' . $lc_text . '</td>' . "\n";
      }

      echo '    </tr>' . "\n";
    }
?>

  </table>

<?php
  } else {
    echo KUUZU::getDef('no_products_in_category');
  }
?>

</div>

<?php
  if ( (count($products_listing['entries']) > 0) && ((PREV_NEXT_BAR_LOCATION == '2') || (PREV_NEXT_BAR_LOCATION == '3')) ) {
?>

<div class="listingPageLinks">
  <span style="float: right;"><?php echo PDO::getBatchPageLinks('page', $products_listing['total'], KUUZU::getAllGET('page')); ?></span>

  <?php echo PDO::getBatchTotalPages(KUUZU::getDef('result_set_number_of_products'), (isset($_GET['page']) ? $_GET['page'] : 1), $products_listing['total']); ?>
</div>

<?php
  }
?>
