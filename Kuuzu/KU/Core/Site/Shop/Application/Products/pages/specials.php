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
  use Kuuzu\KU\Core\Site\Shop\Specials;

  $specials_listing = Specials::getListing();
?>

<h1><?php echo $KUUZU_Template->getPageTitle(); ?></h1>

<div style="overflow: auto;">

<?php
  foreach ( $specials_listing['entries'] as $s ) {
    echo '<span style="width: 33%; float: left; text-align: center;">';

    if ( !empty($s['image']) ) {
      echo HTML::link(KUUZU::getLink(null, null, $s['products_keyword']), $KUUZU_Image->show($s['image'], $s['products_name'])) . '<br />';
    }

    echo HTML::link(KUUZU::getLink(null, null, $s['products_keyword']), $s['products_name']) . '<br />' .
         '<s>' . $KUUZU_Currencies->displayPrice($s['products_price'], $s['products_tax_class_id']) . '</s> <span class="productSpecialPrice">' . $KUUZU_Currencies->displayPrice($s['specials_new_products_price'], $s['products_tax_class_id']) . '</span>' .
         '</span>' . "\n";
  }
?>

</div>

<div class="listingPageLinks">
  <span style="float: right;"><?php echo PDO::getBatchPageLinks('page', $specials_listing['total'], KUUZU::getAllGET('page')); ?></span>

  <?php echo PDO::getBatchTotalPages(KUUZU::getDef('result_set_number_of_products'), (isset($_GET['page']) ? $_GET['page'] : 1), $specials_listing['total']); ?>
</div>
