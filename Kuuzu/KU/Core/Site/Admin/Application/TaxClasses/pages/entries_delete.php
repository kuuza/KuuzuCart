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
  use Kuuzu\KU\Core\ObjectInfo;
  use Kuuzu\KU\Core\KUUZU;
  use Kuuzu\KU\Core\Site\Admin\Application\TaxClasses\TaxClasses;

  $KUUZU_ObjectInfo = new ObjectInfo(TaxClasses::getEntry($_GET['rID']));
?>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<div class="infoBox">
  <h3><?php echo HTML::icon('trash.png') . ' ' . $KUUZU_ObjectInfo->get('tax_class_title') . ': ' . $KUUZU_ObjectInfo->getProtected('geo_zone_name'); ?></h3>

  <form name="rDelete" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'EntryDelete&Process&id=' . $_GET['id'] . '&rID=' . $KUUZU_ObjectInfo->getInt('tax_rates_id')); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_delete_tax_rate'); ?></p>

  <p><?php echo '<b>' . $KUUZU_ObjectInfo->getProtected('tax_class_title') . ': ' . $KUUZU_ObjectInfo->getProtected('geo_zone_name') . '</b>'; ?></p>

  <p><?php echo HTML::button(array('priority' => 'primary', 'icon' => 'trash', 'title' => KUUZU::getDef('button_delete'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(null, null, 'id=' . $_GET['id']), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))); ?></p>

  </form>
</div>
