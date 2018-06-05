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
  use Kuuzu\KU\Core\Site\Admin\Application\ZoneGroups\ZoneGroups;
?>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<div class="infoBox">
  <h3><?php echo HTML::icon('trash.png') . ' ' . KUUZU::getDef('action_heading_batch_delete_zone_groups'); ?></h3>

  <form name="zDeleteBatch" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'BatchDelete&Process'); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_batch_delete_zone_groups'); ?></p>

<?php
  $check_tax_zones_flag = array();

  $Qzones = $KUUZU_PDO->query('select geo_zone_id, geo_zone_name from :table_geo_zones where geo_zone_id in (\'' . implode('\', \'', array_unique(array_filter(array_slice($_POST['batch'], 0, MAX_DISPLAY_SEARCH_RESULTS), 'is_numeric'))) . '\') order by geo_zone_name');
  $Qzones->execute();

  $names_string = '';

  while ( $Qzones->fetch() ) {
    if ( ZoneGroups::hasTaxRates($Qzones->valueInt('geo_zone_id')) ) {
      $check_tax_zones_flag[] = $Qzones->value('geo_zone_name');
    }

    $names_string .= HTML::hiddenField('batch[]', $Qzones->valueInt('geo_zone_id')) . '<b>' . $Qzones->valueProtected('geo_zone_name') . ' (' . sprintf(KUUZU::getDef('total_entries'), ZoneGroups::getNumberOfEntries($Qzones->valueInt('geo_zone_id'))) . ')</b>, ';
  }

  if ( !empty($names_string) ) {
    $names_string = substr($names_string, 0, -2);
  }

  echo '<p>' . $names_string . '</p>';

  if ( empty($check_tax_zones_flag) ) {
    echo '<p>' . HTML::button(array('priority' => 'primary', 'icon' => 'trash', 'title' => KUUZU::getDef('button_delete'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))) . '</p>';
  } else {
    echo '<p><b>' . KUUZU::getDef('batch_delete_warning_group_in_use_tax_rate') . '</b></p>' .
         '<p>' . implode(', ', $check_tax_zones_flag) . '</p>';

    echo '<p>' . HTML::button(array('href' => KUUZU::getLink(), 'priority' => 'primary', 'icon' => 'triangle-1-w', 'title' => KUUZU::getDef('button_back'))) . '</p>';
  }
?>

  </form>
</div>
