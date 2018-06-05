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

  use Kuuzu\KU\Core\DateTime;
  use Kuuzu\KU\Core\HTML;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\PDO;
  use Kuuzu\KU\Core\Site\Shop\Product;
  use Kuuzu\KU\Core\Site\Shop\Products;
?>

<h1><?php echo $KUUZU_Template->getPageTitle(); ?></h1>

<table border="0" width="100%" cellspacing="0" cellpadding="2">

<?php
  $KUUZU_Products = new Products();
  $KUUZU_Products->setSortBy('date_added', '-');

  $products_listing = $KUUZU_Products->execute();

  if ( $products_listing['total'] > 0 ) {
    foreach ( $products_listing['entries'] as $p ) {
      $KUUZU_Product = new Product($p['products_id']);
?>

  <tr>
    <td width="<?php echo $KUUZU_Image->getWidth('thumbnails') + 10; ?>" valign="top" align="center">

<?php
      if ( $KUUZU_Product->hasImage() ) {
        echo HTML::link(KUUZU::getLink(null, null, $KUUZU_Product->getKeyword()), $KUUZU_Image->show($KUUZU_Product->getImage(), $KUUZU_Product->getTitle()));
      }
?>

    </td>
    <td valign="top"><?php echo HTML::link(KUUZU::getLink(null, null, $KUUZU_Product->getKeyword()), '<b><u>' . $KUUZU_Product->getTitle() . '</u></b>') . '<br />' . KUUZU::getDef('date_added') . ' ' . DateTime::getLong($KUUZU_Product->getDateAdded()) . '<br />' . KUUZU::getDef('manufacturer') . ' ' . $KUUZU_Product->getManufacturer() . '<br /><br />' . KUUZU::getDef('price') . ' ' . $KUUZU_Product->getPriceFormated(); ?></td>
    <td align="right" valign="middle"><?php echo HTML::button(array('href' => KUUZU::getLink(null, 'Cart', 'Add&' . $KUUZU_Product->getKeyword()), 'icon' => 'cart', 'title' => KUUZU::getDef('button_add_to_cart'))); ?></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>

<?php
    }
  } else {
?>

  <tr>
    <td><?php echo KUUZU::getDef('no_new_products'); ?></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>

<?php
  }
?>

</table>

<div class="listingPageLinks">
  <span style="float: right;"><?php echo PDO::getBatchPageLinks('page', $products_listing['total'], KUUZU::getAllGET('page')); ?></span>

  <?php echo PDO::getBatchTotalPages(KUUZU::getDef('result_set_number_of_products'), (isset($_GET['page']) ? $_GET['page'] : 1), $products_listing['total']); ?>
</div>
