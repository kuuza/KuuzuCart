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
  <?php echo HTML::inputField('search', null, 'id="liveSearchField" class="searchField" placeholder="' . KUUZU::getDef('placeholder_search') . '"') . HTML::button(array('type' => 'button', 'params' => 'onclick="Kuu_DataTable.reset();"', 'title' => KUUZU::getDef('button_reset'))) . '&nbsp;' . HTML::selectMenu('cid', array_merge(array(array('id' => '0', 'text' => KUUZU::getDef('top_category'))), $KUUZU_Application->getCategoryList())); ?>

  <span style="float: right;">

<?php
  if ( $KUUZU_Application->getCurrentCategoryID() > 0 ) {
    echo HTML::button(array('href' => KUUZU::getLink(null, null, 'cid=' . $KUUZU_CategoryTree->getParentID($KUUZU_Application->getCurrentCategoryID())), 'priority' => 'secondary', 'icon' => 'triangle-1-w', 'title' => KUUZU::getDef('button_back'))) . ' ';
  }

  echo HTML::button(array('href' => KUUZU::getLink(null, null, 'Save&cid=' . $KUUZU_Application->getCurrentCategoryID()), 'icon' => 'plus', 'title' => KUUZU::getDef('button_insert')));
?>

  </span>
</form>

<script>
$(function() {
  $('#cid').change(function() {
    window.location.href='<?php echo KUUZU::getLink(null, null, 'cid=CATEGORYID'); ?>'.replace('CATEGORYID', $('#cid option:selected').val());
  });
});
</script>

<div style="padding: 20px 5px 5px 5px; height: 16px;">
  <span id="batchTotalPages"></span>
  <span id="batchPageLinks"></span>
</div>

<form name="batch" action="#" method="post">

<table border="0" width="100%" cellspacing="0" cellpadding="2" class="dataTable" id="categoriesDataTable">
  <thead>
    <tr>
      <th><?php echo KUUZU::getDef('table_heading_categories'); ?></th>
      <th width="150"><?php echo KUUZU::getDef('table_heading_action'); ?></th>
      <th align="center" width="20"><?php echo HTML::checkboxField('batchFlag', null, null, 'onclick="flagCheckboxes(this);"'); ?></th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th align="right" colspan="2"><?php echo HTML::submitImage(HTML::iconRaw('move.png'), KUUZU::getDef('icon_move'), 'onclick="document.batch.action=\'' . KUUZU::getLink(null, null, 'BatchMove&cid=' . $KUUZU_Application->getCurrentCategoryID()) . '\';"') . '&nbsp;<a href="#" onclick="$(\'#dialogBatchDeleteConfirm\').dialog(\'open\'); return false;">' . HTML::icon('trash.png') . '</a>'; ?></th>
      <th align="center" width="20"><?php echo HTML::checkboxField('batchFlag', null, null, 'onclick="flagCheckboxes(this);"'); ?></th>
    </tr>
  </tfoot>
  <tbody>
  </tbody>
</table>

</form>

<div style="padding: 2px;">
  <span id="dataTableLegend"><?php echo '<b>' . KUUZU::getDef('table_action_legend') . '</b> ' . HTML::icon('edit.png') . '&nbsp;' . KUUZU::getDef('icon_edit') . '&nbsp;&nbsp;' . HTML::icon('move.png') . '&nbsp;' . KUUZU::getDef('icon_move') . '&nbsp;&nbsp;' . HTML::icon('trash.png') . '&nbsp;' . KUUZU::getDef('icon_trash'); ?></span>
  <span id="batchPullDownMenu"></span>
</div>

<script>
  var moduleParamsCookieName = 'kuuzu_admin_' + pageModule;
  var dataTablePageSetName = 'page';

  var moduleParams = new Object();
  moduleParams[dataTablePageSetName] = 1;
  moduleParams['search'] = '';

  if ( $.cookie(moduleParamsCookieName) != null ) {
    moduleParams = $.secureEvalJSON($.cookie(moduleParamsCookieName));
  }

  var dataTableName = 'categoriesDataTable';
  var dataTableDataURL = '<?php echo KUUZU::getRPCLink(null, null, 'GetAll&cid=' . $KUUZU_Application->getCurrentCategoryID()); ?>';

  var dragIcon = '<?php echo HTML::icon('drag.png', null, null, 'class="dragIcon"'); ?>';

  var categoryLink = '<?php echo KUUZU::getLink(null, null, 'cid=CATEGORYID'); ?>';
  var categoryLinkIcon = '<?php echo HTML::icon('folder.png'); ?>';

  var categoryEditLink = '<?php echo KUUZU::getLink(null, null, 'Save&id=CATEGORYID'); ?>';
  var categoryEditLinkIcon = '<?php echo HTML::icon('edit.png'); ?>';

  var categoryDeleteLinkIcon = '<?php echo HTML::icon('trash.png'); ?>';

  var Kuu_DataTable = new Kuu_DataTable();
  Kuu_DataTable.load();

  function feedDataTable(data) {
    var rowCounter = 0;

    for ( var r in data.entries ) {
      var record = data.entries[r];

      var newRow = $('#' + dataTableName)[0].tBodies[0].insertRow(rowCounter);
      newRow.id = 'row_' + parseInt(record.id); // row id reuires an underscore for jQuery.sortable()

      $('#row_' + parseInt(record.id)).hover( function() { $(this).addClass('mouseOver'); }, function() { $(this).removeClass('mouseOver'); }).click(function(event) {
        if (event.target.type !== 'checkbox') {
          $(':checkbox', this).trigger('click');
        }
      }).css('cursor', 'pointer');

      var newCell = newRow.insertCell(0);
      var categoryColumn = '';
      if ( ($('#liveSearchField').val().length < 1) || ($('#liveSearchField').val() == $('#liveSearchField').attr('placeholder')) ) {
        categoryColumn += dragIcon + '&nbsp;';
      }
      categoryColumn += categoryLinkIcon + '&nbsp;<a href="' + categoryLink.replace('CATEGORYID', parseInt(record.id)) + '" class="parent">' + htmlSpecialChars(record.title) + '</a><span style="float: right;">(' + parseInt(record.products) + ')</span>';
      newCell.innerHTML = categoryColumn;

      newCell = newRow.insertCell(1);
      newCell.innerHTML = '<a href="' + categoryEditLink.replace('CATEGORYID', parseInt(record.id)) + '">' + categoryEditLinkIcon + '</a>&nbsp;<a href="#" onclick="$(\'#dialogDeleteConfirm\').data(\'id\', ' + parseInt(record.id) + ').dialog(\'open\'); return false;">' + categoryDeleteLinkIcon + '</a>';
      newCell.align = 'right';

      newCell = newRow.insertCell(2);
      newCell.innerHTML = '<input type="checkbox" name="batch[]" value="' + parseInt(record.id) + '" id="batch' + parseInt(record.id) + '" />';
      newCell.align = 'center';

      rowCounter++;
    }
  }

  $('#categoriesDataTable tbody').sortable({
    handle: '.dragIcon',
    update: function () {
      $('#batchTotalPages .updateStatus').remove();
      var sortStatus = $('#batchTotalPages').html();

      $('#batchTotalPages').html(batchIconProgress + '&nbsp;Updating&hellip;');

      $.getJSON('<?php echo KUUZU::getRPCLink(null, null, 'SaveSortOrder'); ?>', $('#categoriesDataTable tbody').sortable('serialize'), function (response) {
        if ( response.rpcStatus == 1 ) {
          $('#batchTotalPages').html(sortStatus);
        } else {
          $('#batchTotalPages').html(sortStatus + '<span class="updateStatus" style="color: #ff0000; padding-left: 10px;">Update failed</span>');
        }
      });
    }
  });
</script>

<div id="dialogDeleteConfirm" title="<?php echo HTML::output(KUUZU::getDef('dialog_delete_category_title')); ?>">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span><?php echo KUUZU::getDef('dialog_delete_category_desc'); ?></p>
</div>

<div id="dialogBatchDeleteConfirm" title="<?php echo HTML::output(KUUZU::getDef('dialog_batch_delete_category_title')); ?>">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span><?php echo KUUZU::getDef('dialog_batch_delete_category_desc'); ?></p>
</div>

<script>
$(function() {
  $('#dialogDeleteConfirm').dialog({
    autoOpen: false,
    resizable: false,
    modal: true,
    buttons: {
      '<?php echo addslashes(KUUZU::getDef('button_delete')); ?>': function() {
        window.location.href='<?php echo KUUZU::getLink(null, null, 'Delete&Process&id=CATEGORYID'); ?>'.replace('CATEGORYID', $(this).data('id'));
      },
      '<?php echo addslashes(KUUZU::getDef('button_cancel')); ?>': function() {
        $(this).dialog('close');
      }
    }
  });

  $('#dialogBatchDeleteConfirm').dialog({
    autoOpen: false,
    resizable: false,
    modal: true,
    buttons: {
      '<?php echo addslashes(KUUZU::getDef('button_delete')); ?>': function() {
        document.batch.action='<?php echo KUUZU::getLink(null, null, 'BatchDelete&Process&cid=' . $KUUZU_Application->getCurrentCategoryID()); ?>';
        document.batch.submit();
      },
      '<?php echo addslashes(KUUZU::getDef('button_cancel')); ?>': function() {
        $(this).dialog('close');
      }
    }
  });
});
</script>
