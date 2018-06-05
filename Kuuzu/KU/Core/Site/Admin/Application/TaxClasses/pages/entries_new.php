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

  $zones_array = array();

  foreach ( ObjectInfo::to(ZoneGroups::getAll(-1))->get('entries') as $group ) {
    $zones_array[] = array('id' => $group['geo_zone_id'],
                           'text' => $group['geo_zone_name']);
  }
?>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<div class="infoBox">
  <h3><?php echo HTML::icon('new.png') . ' ' . KUUZU::getDef('action_heading_new_tax_rate'); ?></h3>

  <form name="rNew" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'EntrySave&Process&id=' . $_GET['id']); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_new_tax_rate'); ?></p>

  <fieldset>
    <p><label for="tax_zone_id"><?php echo KUUZU::getDef('field_tax_rate_zone_group'); ?></label><?php echo HTML::selectMenu('tax_zone_id', $zones_array); ?></p>
    <p><label for="tax_rate"><?php echo KUUZU::getDef('field_tax_rate'); ?></label><?php echo HTML::inputField('tax_rate'); ?></p>
    <p><label for="tax_description"><?php echo KUUZU::getDef('field_tax_rate_description'); ?></label><?php echo HTML::inputField('tax_description'); ?></p>
    <p><label for="tax_priority"><?php echo KUUZU::getDef('field_tax_rate_priority'); ?></label><?php echo HTML::inputField('tax_priority'); ?></p>
  </fieldset>

  <p><?php echo HTML::button(array('priority' => 'primary', 'icon' => 'check', 'title' => KUUZU::getDef('button_save'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(null, null, 'id=' . $_GET['id']), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))); ?></p>

  </form>
</div>
