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
  use Kuuzu\KU\Core\Site\Admin\Application\Administrators\Administrators;
?>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<div class="infoBox">
  <h3><?php echo HTML::icon('edit.png') . ' ' . KUUZU::getDef('action_heading_batch_edit_administrators'); ?></h3>

  <form name="aEditBatch" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'BatchSave&Process'); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_batch_edit_administrators'); ?></p>

<?php
  $Qadmins = $KUUZU_PDO->query('select id, user_name from :table_administrators where id in ("' . implode('", "', array_unique(array_filter(array_slice($_POST['batch'], 0, MAX_DISPLAY_SEARCH_RESULTS), 'is_numeric'))) . '") order by user_name');
  $Qadmins->execute();

  $names_string = '';

  while ( $Qadmins->fetch() ) {
    $names_string .= HTML::hiddenField('batch[]', $Qadmins->valueInt('id')) . '<b>' . $Qadmins->valueProtected('user_name') . '</b>, ';
  }

  if ( !empty($names_string) ) {
    $names_string = substr($names_string, 0, -2);
  }

  echo '<p>' . $names_string . '</p>';
?>

  <fieldset>
    <p><?php echo HTML::radioField('mode', array(array('id' => Administrators::ACCESS_MODE_ADD, 'text' => KUUZU::getDef('add_to')), array('id' => Administrators::ACCESS_MODE_REMOVE, 'text' => KUUZU::getDef('remove_from')), array('id' => Administrators::ACCESS_MODE_SET, 'text' => KUUZU::getDef('set_to'))), Administrators::ACCESS_MODE_ADD); ?></p>

    <p><select name="accessModules" id="modulesList"><option value="-1" disabled="disabled">-- Access Modules --</option><option value="0"><?php echo KUUZU::getDef('global_access'); ?></option></select></p>

    <ul id="accessToModules" class="modulesListing"></ul>
  </fieldset>

  <p><?php echo HTML::button(array('priority' => 'primary', 'icon' => 'check', 'title' => KUUZU::getDef('button_save'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))); ?></p>

  </form>
</div>

<script type="text/javascript">
  var accessModules = <?php echo json_encode(Administrators::getAccessModules()); ?>;
  var deleteAccessModuleIcon = '<?php echo HTML::icon('uninstall.png'); ?>';

  var $modulesList = $('#modulesList');

  $.each(accessModules, function(i, item) {
    var sGroup = document.createElement('optgroup');
    sGroup.label = i;

    $.each(item, function(key, value) {
      var sOption = new Option(value['text'], value['id']);
      sOption.id = 'am' + value['id'];

      sGroup.appendChild(sOption);
    });

    $modulesList.append(sGroup); 
  });

  $('#modulesList').change(function() {
    if ( $('#modulesList :selected').val() == '0' ) {
      $('#accessToModules li').remove();
      $('#accessToModules').append('<li id="atm' + $('#modulesList :selected').val() + '">' + $('#modulesList :selected').text() + ' <span style="float: right;"><a href="#" onclick="removeAccessToModule(\'' + $('#modulesList :selected').val() + '\');">' + deleteAccessModuleIcon + '</a><input type="hidden" name="modules[]" value="' + $('#modulesList :selected').val() + '" /></span></li>');

      $('#modulesList').attr('disabled', 'disabled');
      $('#modulesList').val('-1');

      $('#accessToModules li').tsort();
    } else if ( $('#modulesList :selected').val() != '-1' ) {
      $('#accessToModules').append('<li id="atm' + $('#modulesList :selected').val() + '">' + $('#modulesList :selected').parent().attr('label') + ' &raquo; ' + $('#modulesList :selected').text() + ' <span style="float: right;"><a href="#" onclick="removeAccessToModule(\'' + $('#modulesList :selected').val() + '\');">' + deleteAccessModuleIcon + '</a><input type="hidden" name="modules[]" value="' + $('#modulesList :selected').val() + '" /></span></li>');

      $('#modulesList :selected').attr('disabled', 'disabled');
      $('#modulesList').val('-1');

      $('#accessToModules li').tsort();
    }
  });

  function removeAccessToModule(module) {
    if ( module == '0' ) {
      $('#modulesList').removeAttr('disabled');
      $('#modulesList :disabled').removeAttr('disabled');
      $('#modulesList :first').attr('disabled', 'disabled');
    } else {
      $('#am' + module).removeAttr('disabled');
    }

    $('#atm' + module).remove();
  }
</script>
