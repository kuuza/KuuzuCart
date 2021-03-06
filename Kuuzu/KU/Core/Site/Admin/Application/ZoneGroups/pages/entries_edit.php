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
  use Kuuzu\KU\Core\Site\Shop\Address;

  $KUUZU_ObjectInfo = new ObjectInfo(ZoneGroups::getEntry($_GET['zID']));

  $countries_array = array(array('id' => '',
                                 'text' => KUUZU::getDef('all_countries')));

  foreach ( Address::getCountries() as $country ) {
    $countries_array[] = array('id' => $country['id'],
                               'text' => $country['name']);
  }

  $zones_array = array(array('id' => '',
                             'text' => KUUZU::getDef('all_zones')));

  if ( $KUUZU_ObjectInfo->get('zone_country_id') > 0 ) {
    foreach ( Address::getZones($KUUZU_ObjectInfo->get('zone_country_id')) as $zone ) {
      $zones_array[] = array('id' => $zone['id'],
                             'text' => $zone['name']);
    }
  }
?>

<script type="text/javascript">
  function update_zone(theForm) {
    var NumState = theForm.zone_id.options.length;
    var SelectedCountry = "";

    while(NumState > 0) {
      NumState--;
      theForm.zone_id.options[NumState] = null;
    }

    SelectedCountry = theForm.zone_country_id.options[theForm.zone_country_id.selectedIndex].value;

<?php echo ZoneGroups::getJSList('SelectedCountry', 'theForm', 'zone_id'); ?>
  }
</script>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<div class="infoBox">
  <h3><?php echo HTML::icon('edit.png') . ' ' . $KUUZU_ObjectInfo->getProtected('countries_name') . ': ' . $KUUZU_ObjectInfo->getProtected('zone_name'); ?></h3>

  <form name="zEdit" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'EntrySave&Process&id=' . $_GET['id'] . '&zID=' . $KUUZU_ObjectInfo->getInt('association_id')); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_edit_zone_entry'); ?></p>

  <fieldset>
    <p><label for="zone_country_id"><?php echo KUUZU::getDef('field_country'); ?></label><?php echo HTML::selectMenu('zone_country_id', $countries_array, $KUUZU_ObjectInfo->get('zone_country_id'), 'onchange="update_zone(this.form);"'); ?></p>
    <p><label for="zone_id"><?php echo KUUZU::getDef('field_zone'); ?></label><?php echo HTML::selectMenu('zone_id', $zones_array, $KUUZU_ObjectInfo->get('zone_id')); ?></p>
  </fieldset>

  <p><?php echo HTML::button(array('priority' => 'primary', 'icon' => 'check', 'title' => KUUZU::getDef('button_save'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(null, null, 'id=' . $_GET['id']), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))); ?></p>

  </form>
</div>
