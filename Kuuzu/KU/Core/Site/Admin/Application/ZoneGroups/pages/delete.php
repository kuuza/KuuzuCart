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
  use Kuuzu\KU\Core\Site\Admin\Application\ZoneGroups\ZoneGroups;

  $KUUZU_ObjectInfo = new ObjectInfo(ZoneGroups::get($_GET['id']));
?>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<div class="infoBox">
  <h3><?php echo HTML::icon('trash.png') . ' ' . $KUUZU_ObjectInfo->getProtected('geo_zone_name'); ?></h3>

  <form name="zDelete" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'Delete&Process&id=' . $KUUZU_ObjectInfo->getInt('geo_zone_id')); ?>" method="post">

<?php
  if ( ZoneGroups::hasTaxRates($KUUZU_ObjectInfo->getInt('geo_zone_id')) ) {
?>

  <p><?php echo '<b>' . sprintf(KUUZU::getDef('delete_warning_group_in_use_tax_rate'), ZoneGroups::getNumberOfTaxRates($KUUZU_ObjectInfo->getInt('geo_zone_id'))) . '</b>'; ?></p>

  <p><?php echo HTML::button(array('href' => KUUZU::getLink(), 'icon' => 'triangle-1-w', 'title' => KUUZU::getDef('button_back'))); ?></p>

<?php
  } else {
?>

  <p><?php echo KUUZU::getDef('introduction_delete_zone_group'); ?></p>

  <p><?php echo '<b>' . $KUUZU_ObjectInfo->getProtected('geo_zone_name') . ' (' . sprintf(KUUZU::getDef('total_entries'), $KUUZU_ObjectInfo->getInt('total_entries')) . ')</b>'; ?></p>

  <p><?php echo HTML::button(array('priority' => 'primary', 'icon' => 'trash', 'title' => KUUZU::getDef('button_delete'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))); ?></p>

<?php
  }
?>

  </form>
</div>
