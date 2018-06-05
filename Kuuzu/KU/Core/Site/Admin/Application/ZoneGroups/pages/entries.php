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

<form id="liveSearchForm">
  <?php echo HTML::inputField('search', null, 'id="liveSearchField" class="searchField" placeholder="' . KUUZU::getDef('placeholder_search') . '"') . HTML::button(array('type' => 'button', 'params' => 'onclick="Kuu_DataTable.reset();"', 'title' => KUUZU::getDef('button_reset'))); ?>

  <span style="float: right;"><?php echo HTML::button(array('href' => KUUZU::getLink(), 'priority' => 'secondary', 'icon' => 'triangle-1-w', 'title' => KUUZU::getDef('button_back'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(null, null, 'EntrySave&id=' . $_GET['id']), 'icon' => 'plus', 'title' => KUUZU::getDef('button_insert'))); ?></span>
</form>

<div style="padding: 20px 5px 5px 5px; height: 16px;">
  <span id="batchTotalPages"></span>
  <span id="batchPageLinks"></span>
</div>

<form name="batch" action="#" method="post">

<table border="0" width="100%" cellspacing="0" cellpadding="2" class="dataTable" id="zoneGroupEntriesDataTable">
  <thead>
    <tr>
      <th><?php echo KUUZU::getDef('table_heading_country'); ?></th>
      <th><?php echo KUUZU::getDef('table_heading_zone'); ?></th>
      <th width="150"><?php echo KUUZU::getDef('table_heading_action'); ?></th>
      <th align="center" width="20"><?php echo HTML::checkboxField('batchFlag', null, null, 'onclick="flagCheckboxes(this);"'); ?></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th align="right" colspan="3"><?php echo HTML::submitImage(HTML::iconRaw('trash.png'), KUUZU::getDef('icon_trash'), 'onclick="document.batch.action=\'' . KUUZU::getLink(null, null, 'BatchDeleteEntries&id=' . $_GET['id']) . '\';"'); ?></th>
      <th align="center" width="20"><?php echo HTML::checkboxField('batchFlag', null, null, 'onclick="flagCheckboxes(this);"'); ?></th>
    </tr>
  </tfoot>
  <tbody>
  </tbody>
</table>

</form>

<div style="padding: 2px;">
  <span id="dataTableLegend"><?php echo '<b>' . KUUZU::getDef('table_action_legend') . '</b> ' . HTML::icon('edit.png') . '&nbsp;' . KUUZU::getDef('icon_edit') . '&nbsp;&nbsp;' . HTML::icon('trash.png') . '&nbsp;' . KUUZU::getDef('icon_trash'); ?></span>
  <span id="batchPullDownMenu"></span>
</div>

<script type="text/javascript">
  var moduleParamsCookieName = 'kuuzu_admin_' + pageModule;
  var dataTablePageSetName = 'entries_page';

  var moduleParams = new Object();
  moduleParams[dataTablePageSetName] = 1;
  moduleParams['search'] = '';

  if ( $.cookie(moduleParamsCookieName) != null ) {
    moduleParams = $.secureEvalJSON($.cookie(moduleParamsCookieName));
  }

  var dataTableName = 'zoneGroupEntriesDataTable';
  var dataTableDataURL = '<?php echo KUUZU::getRPCLink(null, null, 'GetAllEntries&id=' . $_GET['id']); ?>';

  var entryEditLink = '<?php echo KUUZU::getLink(null, null, 'EntrySave&id=' . $_GET['id'] . '&zID=ENTRYID'); ?>';
  var entryEditLinkIcon = '<?php echo HTML::icon('edit.png'); ?>';

  var entryDeleteLink = '<?php echo KUUZU::getLink(null, null, 'EntryDelete&id=' . $_GET['id'] . '&zID=ENTRYID'); ?>';
  var entryDeleteLinkIcon = '<?php echo HTML::icon('trash.png'); ?>';

  var allCountries = '<?php echo addslashes(KUUZU::getDef('all_countries')); ?>';
  var allZones = '<?php echo addslashes(KUUZU::getDef('all_zones')); ?>';
  
  var Kuu_DataTable = new Kuu_DataTable();
  Kuu_DataTable.load();

  function feedDataTable(data) {
    var rowCounter = 0;

    for ( var r in data.entries ) {
      var record = data.entries[r];

      var countryName = record.countries_name;
      if ( isNaN(parseInt(record.zone_country_id)) || parseInt(record.zone_country_id) < 1 ) {
        countryName = allCountries;
      }

      var zoneName = record.zone_name;
      if ( isNaN(parseInt(record.zone_id)) || parseInt(record.zone_id) < 1 ) {
        zoneName = allZones;
      }

      var newRow = $('#' + dataTableName)[0].tBodies[0].insertRow(rowCounter);
      newRow.id = 'row' + parseInt(record.association_id);

      $('#row' + parseInt(record.association_id)).hover( function() { $(this).addClass('mouseOver'); }, function() { $(this).removeClass('mouseOver'); }).click(function(event) {
        if (event.target.type !== 'checkbox') {
          $(':checkbox', this).trigger('click');
        }
      }).css('cursor', 'pointer');

      var newCell = newRow.insertCell(0);
      newCell.innerHTML = htmlSpecialChars(countryName);

      newCell = newRow.insertCell(1);
      newCell.innerHTML = htmlSpecialChars(zoneName);

      newCell = newRow.insertCell(2);
      newCell.innerHTML = '<a href="' + entryEditLink.replace('ENTRYID', parseInt(record.association_id)) + '">' + entryEditLinkIcon + '</a>&nbsp;<a href="' + entryDeleteLink.replace('ENTRYID', parseInt(record.association_id)) + '">' + entryDeleteLinkIcon + '</a>';
      newCell.align = 'right';

      newCell = newRow.insertCell(3);
      newCell.innerHTML = '<input type="checkbox" name="batch[]" value="' + parseInt(record.association_id) + '" id="batch' + parseInt(record.association_id) + '" />';
      newCell.align = 'center';

      rowCounter++;
    }
  }
</script>
