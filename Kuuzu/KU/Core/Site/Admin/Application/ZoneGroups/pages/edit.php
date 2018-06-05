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
  <h3><?php echo HTML::icon('edit.png') . ' ' . $KUUZU_ObjectInfo->getProtected('geo_zone_name'); ?></h3>

  <form name="zEdit" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'Save&Process&id=' . $KUUZU_ObjectInfo->getInt('geo_zone_id')); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_edit_zone_group'); ?></p>

  <fieldset>
    <p><label for="zone_name"><?php echo KUUZU::getDef('field_name'); ?></label><?php echo HTML::inputField('zone_name', $KUUZU_ObjectInfo->get('geo_zone_name')); ?></p>
    <p><label for="zone_description"><?php echo KUUZU::getDef('field_description'); ?></label><?php echo HTML::inputField('zone_description', $KUUZU_ObjectInfo->get('geo_zone_description')); ?></p>
  </fieldset>

  <p><?php echo HTML::button(array('priority' => 'primary', 'icon' => 'check', 'title' => KUUZU::getDef('button_save'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))); ?></p>

  </form>
</div>
