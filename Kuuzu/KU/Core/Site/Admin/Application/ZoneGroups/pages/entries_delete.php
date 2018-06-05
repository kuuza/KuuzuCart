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

  $KUUZU_ObjectInfo = new ObjectInfo(ZoneGroups::getEntry($_GET['zID']));
?>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<div class="infoBox">
  <h3><?php echo HTML::icon('trash.png') . ' ' . $KUUZU_ObjectInfo->getProtected('countries_name') . ': ' . $KUUZU_ObjectInfo->getProtected('zone_name'); ?></h3>

  <form name="zDelete" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'EntryDelete&Process&id=' . $_GET['id'] . '&zID=' . $KUUZU_ObjectInfo->getInt('association_id')); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_delete_zone_entry'); ?></p>

  <p><?php echo '<b>' . $KUUZU_ObjectInfo->getProtected('countries_name') . ': ' . $KUUZU_ObjectInfo->getProtected('zone_name') . '</b>'; ?></p>

  <p><?php echo HTML::button(array('priority' => 'primary', 'icon' => 'trash', 'title' => KUUZU::getDef('button_delete'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(null, null, 'id=' . $_GET['id']), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))); ?></p>

  </form>
</div>
