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

  <span style="float: right;"><?php echo HTML::button(array('href' => KUUZU::getLink(null, null, 'Import'), 'icon' => 'triangle-1-se', 'title' => KUUZU::getDef('button_import'))); ?></span>
</form>

<div style="padding: 20px 5px 5px 5px; height: 16px;">
  <span id="batchTotalPages"></span>
  <span id="batchPageLinks"></span>
</div>

<form name="batch" action="#" method="post">

<table border="0" width="100%" cellspacing="0" cellpadding="2" class="dataTable" id="langDataTable">
  <thead>
    <tr>
      <th><?php echo KUUZU::getDef('table_heading_languages'); ?></th>
      <th width="20">&nbsp;</th>
      <th><?php echo KUUZU::getDef('table_heading_code'); ?></th>
      <th width="150"><?php echo KUUZU::getDef('table_heading_action'); ?></th>
      <th align="center" width="20"><?php echo HTML::checkboxField('batchFlag', null, null, 'onclick="flagCheckboxes(this);"'); ?></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th align="right" colspan="4"><?php echo HTML::submitImage(HTML::iconRaw('trash.png'), KUUZU::getDef('icon_trash'), 'onclick="document.batch.action=\'' . KUUZU::getLink(null, null, 'BatchDelete') . '\';"'); ?></th>
      <th align="center" width="20"><?php echo HTML::checkboxField('batchFlag', null, null, 'onclick="flagCheckboxes(this);"'); ?></th>
    </tr>
  </tfoot>
  <tbody>
  </tbody>
</table>

</form>

<div style="padding: 2px;">
  <span id="dataTableLegend"><?php echo '<b>' . KUUZU::getDef('table_action_legend') . '</b> ' . HTML::icon('edit.png') . '&nbsp;' . KUUZU::getDef('icon_edit') . '&nbsp;&nbsp;' . HTML::icon('export.png') . '&nbsp;' . KUUZU::getDef('icon_export') . '&nbsp;&nbsp;' . HTML::icon('trash.png') . '&nbsp;' . KUUZU::getDef('icon_trash'); ?></span>
  <span id="batchPullDownMenu"></span>
</div>

<script type="text/javascript">
  var moduleParamsCookieName = 'kuuzu_admin_' + pageModule;
  var dataTablePageSetName = 'page';

  var moduleParams = new Object();
  moduleParams[dataTablePageSetName] = 1;
  moduleParams['search'] = '';

  if ( $.cookie(moduleParamsCookieName) != null ) {
    moduleParams = $.secureEvalJSON($.cookie(moduleParamsCookieName));
  }

  var dataTableName = 'langDataTable';
  var dataTableDataURL = '<?php echo KUUZU::getRPCLink(null, null, 'GetAll'); ?>';

  var languageLink = '<?php echo KUUZU::getLink(null, null, 'id=LANGUAGEID'); ?>';
  var languageLinkIcon = '<?php echo HTML::icon('folder.png'); ?>';

  var languageIcon = '<?php echo HTML::image(KUUZU::getPublicSiteLink('images/worldflags/LANGUAGECODE.png', null, 'Shop'), 'LANGUAGENAME'); ?>';

  var languageEditLink = '<?php echo KUUZU::getLink(null, null, 'Save&id=LANGUAGEID'); ?>';
  var languageEditLinkIcon = '<?php echo HTML::icon('edit.png'); ?>';

  var languageExportLink = '<?php echo KUUZU::getLink(null, null, 'Export&id=LANGUAGEID'); ?>';
  var languageExportLinkIcon = '<?php echo HTML::icon('export.png'); ?>';

  var languageDeleteLink = '<?php echo KUUZU::getLink(null, null, 'Delete&id=LANGUAGEID'); ?>';
  var languageDeleteLinkIcon = '<?php echo HTML::icon('trash.png'); ?>';

  var defaultLanguage = '<?php echo DEFAULT_LANGUAGE; ?>';
  var defaultText = '<?php echo addslashes(KUUZU::getDef('default_entry')); ?>';

  var Kuu_DataTable = new Kuu_DataTable();
  Kuu_DataTable.load();

  function feedDataTable(data) {
    var rowCounter = 0;

    for ( var r in data.entries ) {
      var record = data.entries[r];

      var languageName = record.name;

      if ( record.code == defaultLanguage ) {
        languageName += ' (' + defaultText + ')';
      }

      var newRow = $('#' + dataTableName)[0].tBodies[0].insertRow(rowCounter);
      newRow.id = 'row' + parseInt(record.languages_id);

      $('#row' + parseInt(record.languages_id)).hover( function() { $(this).addClass('mouseOver'); }, function() { $(this).removeClass('mouseOver'); }).click(function(event) {
        if (event.target.type !== 'checkbox') {
          $(':checkbox', this).trigger('click');
        }
      }).css('cursor', 'pointer');

      var newCell = newRow.insertCell(0);
      newCell.innerHTML = languageLinkIcon + '&nbsp;<a href="' + languageLink.replace('LANGUAGEID', parseInt(record.languages_id)) + '" class="parent">' + htmlSpecialChars(languageName) + '</a><span style="float: right;">(' + parseInt(record.total_definitions) + ')</span>';

      newCell = newRow.insertCell(1);
      newCell.innerHTML = languageIcon.replace('LANGUAGECODE', htmlSpecialChars(record.code.toLowerCase().substring(3))).replace('LANGUAGENAME', htmlSpecialChars(record.name)).replace('LANGUAGENAME', htmlSpecialChars(record.name));

      newCell = newRow.insertCell(2);
      newCell.innerHTML = htmlSpecialChars(record.code);

      newCell = newRow.insertCell(3);
      newCell.innerHTML = '<a href="' + languageEditLink.replace('LANGUAGEID', parseInt(record.languages_id)) + '">' + languageEditLinkIcon + '</a>&nbsp;<a href="' + languageExportLink.replace('LANGUAGEID', parseInt(record.languages_id)) + '">' + languageExportLinkIcon + '</a>&nbsp;<a href="' + languageDeleteLink.replace('LANGUAGEID', parseInt(record.languages_id)) + '">' + languageDeleteLinkIcon + '</a>';
      newCell.align = 'right';

      newCell = newRow.insertCell(4);
      newCell.innerHTML = '<input type="checkbox" name="batch[]" value="' + parseInt(record.languages_id) + '" id="batch' + parseInt(record.languages_id) + '" />';
      newCell.align = 'center';

      rowCounter++;
    }
  }
</script>
