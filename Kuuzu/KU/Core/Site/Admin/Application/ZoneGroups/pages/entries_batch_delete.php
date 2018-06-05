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
?>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<div class="infoBox">
  <h3><?php echo HTML::icon('trash.png') . ' ' . KUUZU::getDef('action_heading_batch_delete_zone_entries'); ?></h3>

  <form name="zDeleteBatch" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'BatchDeleteEntries&Process&id=' . $_GET['id']); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_batch_delete_zone_entries'); ?></p>

<?php
  $Qentries = $KUUZU_PDO->query('select z2gz.association_id, z2gz.zone_country_id, c.countries_name, z2gz.zone_id, z.zone_name from :table_zones_to_geo_zones z2gz left join :table_countries c on (z2gz.zone_country_id = c.countries_id) left join :table_zones z on (z2gz.zone_id = z.zone_id) where z2gz.association_id in (\'' . implode('\', \'', array_unique(array_filter(array_slice($_POST['batch'], 0, MAX_DISPLAY_SEARCH_RESULTS), 'is_numeric'))) . '\') order by c.countries_name, z.zone_name');
  $Qentries->execute();

  $names_string = '';

  while ( $Qentries->fetch() ) {
    $names_string .= HTML::hiddenField('batch[]', $Qentries->valueInt('association_id')) . '<b>' . (($Qentries->valueInt('zone_country_id') > 0) ? $Qentries->value('countries_name') : KUUZU::getDef('all_countries')) . ': ' . (($Qentries->valueInt('zone_id') > 0) ? $Qentries->value('zone_name') : KUUZU::getDef('all_zones')) . '</b>, ';
  }

  if ( !empty($names_string) ) {
    $names_string = substr($names_string, 0, -2) . HTML::hiddenField('subaction', 'confirm');
  }

  echo '<p>' . $names_string . '</p>';

  echo '<p>' . HTML::button(array('priority' => 'primary', 'icon' => 'trash', 'title' => KUUZU::getDef('button_delete'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(null, null, 'id=' . $_GET['id']), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))) . '</p>';
?>

  </form>
</div>
