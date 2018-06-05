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
  use Kuuzu\KU\Core\Site\Admin\Application\Languages\Languages;

  $KUUZU_ObjectInfo = new ObjectInfo(Languages::get($_GET['id']));

  $groups_array = array();

  foreach ( ObjectInfo::to(Languages::getGroups($KUUZU_ObjectInfo->getInt('languages_id')))->get('entries') as $group ) {
    $groups_array[] = array('id' => $group['content_group'],
                            'text' => $group['content_group']);
  }
?>

<h1><?php echo $KUUZU_Template->getIcon(32) . HTML::link(KUUZU::getLink(), $KUUZU_Template->getPageTitle()); ?></h1>

<?php
  if ( $KUUZU_MessageStack->exists() ) {
    echo $KUUZU_MessageStack->get();
  }
?>

<div class="infoBox">
  <h3><?php echo HTML::icon('export.png') . ' ' . $KUUZU_ObjectInfo->getProtected('name'); ?></h3>

  <form name="lExport" class="dataForm" action="<?php echo KUUZU::getLink(null, null, 'Export&Process&id=' . $_GET['id']); ?>" method="post">

  <p><?php echo KUUZU::getDef('introduction_export_language'); ?></p>

  <fieldset>
    <p>(<a href="javascript:selectAllFromPullDownMenu('groups');"><u><?php echo KUUZU::getDef('select_all'); ?></u></a> | <a href="javascript:resetPullDownMenuSelection('groups');"><u><?php echo KUUZU::getDef('select_none'); ?></u></a>)<br /><?php echo HTML::selectMenu('groups[]', $groups_array, array('account', 'checkout', 'general', 'index', 'info', 'order', 'products', 'search'), 'id="groups" size="10" multiple="multiple"'); ?></p>

    <p><?php echo HTML::checkboxField('include_data', array(array('id' => '', 'text' => KUUZU::getDef('field_export_with_data'))), true); ?></p>
  </fieldset>

  <p><?php echo HTML::button(array('priority' => 'primary', 'icon' => 'triangle-1-nw', 'title' => KUUZU::getDef('button_export'))) . ' ' . HTML::button(array('href' => KUUZU::getLink(), 'priority' => 'secondary', 'icon' => 'close', 'title' => KUUZU::getDef('button_cancel'))); ?></p>

  </form>
</div>
