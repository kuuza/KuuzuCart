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

  $products_listing = $KUUZU_Search->getResult();
?>

<h1><?php echo $KUUZU_Template->getPageTitle(); ?></h1>

<?php
  require(KUUZU::BASE_DIRECTORY . 'Core/Site/Shop/Application/Products/pages/product_listing.php');
?>

<div class="submitFormButtons">
  <?php echo HTML::button(array('href' => KUUZU::getLink(), 'icon' => 'triangle-1-w', 'title' => KUUZU::getDef('button_back'))); ?>
</div>
