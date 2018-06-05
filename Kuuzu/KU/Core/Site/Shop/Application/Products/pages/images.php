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

  $large_image = $KUUZU_Image->show($KUUZU_Product->getImage(), $KUUZU_Product->getTitle(), 'id="productImageLarge"', 'large');
?>

<style type="text/css">
BODY {
  min-width: 0;
}
</style>

<script language="javascript" type="text/javascript">
function loadImage(imageUrl) {
  $("#productImageLarge").fadeOut('fast', function() {
    $("#productImageLarge").attr('src', imageUrl);
    $("#productImageLarge").fadeIn("slow");
  });
}
</script>

<div class="moduleBox">

<?php
  if ( $KUUZU_Product->numberOfImages() > 1 ) {
?>

  <div id="productImageThumbnails" class="content" style="position: absolute; top: 10px; overflow: auto; width: <?php echo ($KUUZU_Image->getWidth('thumbnails') * 2) + 15; ?>px;">

<?php
    foreach ( $KUUZU_Product->getImages() as $images ) {
      if ( isset($_GET['image']) && ($_GET['image'] == $images['id']) ) {
        $large_image = $KUUZU_Image->show($images['image'], $KUUZU_Product->getTitle(), 'id="productImageLarge"', 'large');
      }

      echo '<span style="width: ' . $KUUZU_Image->getWidth($KUUZU_Image->getCode(DEFAULT_IMAGE_GROUP_ID)) . 'px; padding: 2px; float: left; text-align: center;">' . HTML::link(KUUZU::getLink(null, null, 'Images&' . $KUUZU_Product->getKeyword() . '&image=' . $images['id']),  $KUUZU_Image->show($images['image'], $KUUZU_Product->getTitle(), 'height="' . $KUUZU_Image->getHeight($KUUZU_Image->getCode(DEFAULT_IMAGE_GROUP_ID)) . '" style="max-width: ' . $KUUZU_Image->getWidth($KUUZU_Image->getCode(DEFAULT_IMAGE_GROUP_ID)) . 'px;"'), 'onclick="loadImage(\'' . $KUUZU_Image->getAddress($images['image'], 'large') . '\'); return false;"') . '</span>';
    }
?>

  </div>

<?php
  }
?>

  <div id="productImageLargeBlock" style="position: absolute; left: <?php echo ($KUUZU_Product->numberOfImages() > 1) ? ($KUUZU_Image->getWidth($KUUZU_Image->getCode(DEFAULT_IMAGE_GROUP_ID)) * 2) + 60 : 10; ?>px; top: 10px; text-align: center; width: <?php echo $KUUZU_Image->getWidth('large'); ?>px;">

<?php
  echo $large_image;
?>

  </div>
</div>
