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
  use Kuuzu\KU\Core\Site\Shop\Products;
  use Kuuzu\KU\Core\Site\Shop\ProductVariants;
  use Kuuzu\KU\Core\Site\Shop\Reviews;
?>

<h1><?php echo $KUUZU_Template->getPageTitle(); ?></h1>

<div>

<?php
  if ( $KUUZU_Product->hasImage() ) {
?>

  <div style="float: left; text-align: center; padding: 0 10px 10px 0; width: <?php echo $KUUZU_Image->getWidth('product_info'); ?>px;">
    <?php echo HTML::link(KUUZU::getLink(null, 'Products', 'Images&' . $KUUZU_Product->getKeyword()), $KUUZU_Image->show($KUUZU_Product->getImage(), $KUUZU_Product->getTitle(), null, 'product_info'), 'target="_blank" onclick="window.open(\'' . KUUZU::getLink(null, 'Products', 'Images&' . $KUUZU_Product->getKeyword()) . '\', \'popUp\', \'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=' . (($KUUZU_Product->numberOfImages() > 1) ? $KUUZU_Image->getWidth('large') + ($KUUZU_Image->getWidth('thumbnails') * 2) + 70 : $KUUZU_Image->getWidth('large') + 20) . ',height=' . ($KUUZU_Image->getHeight('large') + 20) . '\'); return false;"'); ?>
  </div>

<?php
  }
?>

  <div style="<?php if ( $KUUZU_Product->hasImage() ) { echo 'margin-left: ' . ($KUUZU_Image->getWidth('product_info') + 20) . 'px; '; } ?>min-height: <?php echo $KUUZU_Image->getHeight('product_info'); ?>px;">
    <form name="cart_quantity" action="<?php echo KUUZU::getLink(null, 'Cart', 'Add&' . $KUUZU_Product->getKeyword()); ?>" method="post">

    <div style="float: right;">
      <?php echo HTML::button(array('icon' => 'cart', 'title' => KUUZU::getDef('button_add_to_cart'))); ?>
    </div>

    <table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="productInfoKey">Price:</td>
        <td class="productInfoValue"><span id="productInfoPrice"><?php echo $KUUZU_Product->getPriceFormated(true); ?></span> (plus <?php echo HTML::link(KUUZU::getLink(null, 'Info', 'Shipping'), 'shipping'); ?>)</td>
      </tr>

<?php
  if ( $KUUZU_Product->hasAttribute('shipping_availability') ) { // HPDL check case
?>

      <tr>
        <td class="productInfoKey">Availability:</td>
        <td class="productInfoValue" id="productInfoAvailability"><?php echo $KUUZU_Product->getAttribute('shipping_availability'); ?></td>
      </tr>

<?php
  }
?>

    </table>

<?php
  if ( $KUUZU_Product->hasVariants() ) {
?>

    <div id="variantsBlock">
      <div id="variantsBlockTitle"><?php echo KUUZU::getDef('product_attributes'); ?></div>

      <div id="variantsBlockData">

<?php
    foreach ( $KUUZU_Product->getVariants() as $group_id => $value ) {
      echo ProductVariants::parse($value['module'], $value);
    }

    echo ProductVariants::defineJavascript($KUUZU_Product->getVariants(false));
?>

      </div>
    </div>

<?php
  }
?>

    </form>
  </div>
</div>

<div style="clear: both;"></div>

<table border="0" cellspacing="0" cellpadding="0">

<?php
  if ( $KUUZU_Product->hasAttribute('manufacturers') ) { // HPDL check case
?>

  <tr>
    <td class="productInfoKey">Manufacturer:</td>
    <td class="productInfoValue"><?php echo $KUUZU_Product->getAttribute('manufacturers'); // HPDL check case ?></td>
  </tr>

<?php
  }
?>

  <tr>
    <td class="productInfoKey">Model:</td>
    <td class="productInfoValue"><span id="productInfoModel"><?php echo $KUUZU_Product->getModel(); ?></span></td>
  </tr>

<?php
  if ( $KUUZU_Product->hasAttribute('date_available') ) { // HPDL check case
?>

  <tr>
    <td class="productInfoKey">Date Available:</td>
    <td class="productInfoValue"><?php echo DateTime::getShort($KUUZU_Product->getAttribute('date_available')); ?></td>
  </tr>

<?php
  }
?>

</table>

<?php
  if ( $KUUZU_Product->hasVariants() ) {
?>

<script language="javascript" type="text/javascript">
  var originalPrice = '<?php echo $KUUZU_Product->getPriceFormated(true); ?>';
  var productInfoNotAvailable = '<span id="productVariantCombinationNotAvailable">Not available in this combination. Please select another combination for your order.</span>';
  var productInfoAvailability = '<?php if ( $KUUZU_Product->hasAttribute('shipping_availability') ) { echo addslashes($KUUZU_Product->getAttribute('shipping_availability')); } ?>';

  refreshVariants();
</script>

<?php
  }
?>

<div>
  <?php echo $KUUZU_Product->getDescription(); ?>
</div>

<?php
  if ($KUUZU_Service->isStarted('Reviews') && Reviews::exists(Products::getProductID($KUUZU_Product->getID()), true)) {
?>

<p><?php echo KUUZU::getDef('number_of_product_reviews') . ' ' . Reviews::getTotal(Products::getProductID($KUUZU_Product->getID())); ?></p>

<?php
  }

  if ( $KUUZU_Product->hasURL() ) {
?>

<p><?php echo sprintf(KUUZU::getDef('go_to_external_products_webpage'), KUUZU::getLink(null, 'Redirect', 'action=url&goto=' . urlencode($KUUZU_Product->getURL()), 'NONSSL', null, false)); ?></p>

<?php
  }
?>

<div class="submitFormButtons" style="text-align: right;">

<?php
  if ( $KUUZU_Service->isStarted('Reviews')) {
    echo HTML::button(array('href' => KUUZU::getLink(null, null, 'Reviews&' . KUUZU::getAllGET()), 'icon' => 'comment', 'title' => KUUZU::getDef('button_reviews')));
  }
?>

</div>
