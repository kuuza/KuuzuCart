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

  $Qzones = $KUUZU_PDO->query('select zone_id, zone_name from :table_zones where zone_id in (\'' . implode('\', \'', array_unique(array_filter($_POST['batch'], 'is_numeric'))) . '\') order by zone_name');
  $Qzones->execute();

  $names_string = '';

  while ( $Qzones->fetch() ) {
    $names_string .= HTML::hiddenField('batch[]', $Qzones->valueInt('zone_id')) . '<b>' . $Qzones->valueProtected('zone_name') . '</b>, ';
  }

  if ( !empty($names_string) ) {
    $names_string = substr($names_string, 0, -2);
  }
?>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<div class="infoBox">
  <h3><?php echo HTML::icon('trash.png') . ' ' . KUUZU::getDef('action_heading_batch_delete_zones'); ?></h3>

  <form name="cDeleteBatch" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'BatchDeleteZones&Process&id=' . $_GET['id']); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_batch_delete_zones'); ?></p>

  <p><?php echo $names_string; ?></p>

  <p><?php echo HTML::button(array('priority' => 'primary', 'icon' => 'trash', 'title' => KUUZU::getDef('button_delete'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(null, null, 'id=' . $_GET['id']), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))); ?></p>

  </form>
</div>
